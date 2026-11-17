<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JenisIzinModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class JenisIzin extends BaseController
{
    private function model(): JenisIzinModel
    {
        return new JenisIzinModel();
    }

    // Jenis izin yang sudah punya berkas tidak boleh dihapus (nanti, setelah tabel permohonan ada)
    private function sudahDipakai(int $id): bool
    {
        $db = \Config\Database::connect();

        if (! $db->tableExists('permohonan')) {
            return false;
        }

        return $db->table('permohonan')->where('jenis_izin_id', $id)->countAllResults() > 0;
    }

    private function ambil(int $id): array
    {
        $item = $this->model()->find($id);

        if (! $item) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $item;
    }

    public function index()
    {
        return view('admin/jenis_izin/index', [
            'judul'  => 'Jenis Izin',
            'daftar' => $this->model()->orderBy('urutan')->findAll(),
        ]);
    }

    public function tambah()
    {
        return view('admin/jenis_izin/form', [
            'judul' => 'Tambah Jenis Izin',
            'item'  => null,
            'aksi'  => site_url('admin/jenis-izin/simpan'),
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama'   => 'required|max_length[100]|is_unique[jenis_izin.nama]',
            'kode'   => 'required|max_length[20]',
            'urutan' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model()->insert([
            'nama'             => trim($this->request->getPost('nama')),
            'kode'             => strtoupper(trim($this->request->getPost('kode'))),
            'urutan'           => (int) $this->request->getPost('urutan'),
            'punya_pencabutan' => $this->request->getPost('punya_pencabutan') ? 1 : 0,
            'aktif'            => 1,
        ]);

        return redirect()->to('/admin/jenis-izin')->with('sukses', 'Jenis izin berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        return view('admin/jenis_izin/form', [
            'judul' => 'Ubah Jenis Izin',
            'item'  => $this->ambil((int) $id),
            'aksi'  => site_url('admin/jenis-izin/perbarui/' . (int) $id),
        ]);
    }

    public function perbarui($id)
    {
        $id = (int) $id;
        $this->ambil($id);

        $rules = [
            'nama'   => "required|max_length[100]|is_unique[jenis_izin.nama,id,{$id}]",
            'kode'   => 'required|max_length[20]',
            'urutan' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model()->update($id, [
            'nama'             => trim($this->request->getPost('nama')),
            'kode'             => strtoupper(trim($this->request->getPost('kode'))),
            'urutan'           => (int) $this->request->getPost('urutan'),
            'punya_pencabutan' => $this->request->getPost('punya_pencabutan') ? 1 : 0,
        ]);

        return redirect()->to('/admin/jenis-izin')->with('sukses', 'Jenis izin berhasil diperbarui.');
    }

    public function status($id)
    {
        $id   = (int) $id;
        $item = $this->ambil($id);

        $this->model()->update($id, ['aktif' => $item['aktif'] ? 0 : 1]);

        return redirect()->to('/admin/jenis-izin')->with('sukses', 'Status jenis izin diubah.');
    }

    public function hapus($id)
    {
        $id = (int) $id;
        $this->ambil($id);

        if ($this->sudahDipakai($id)) {
            return redirect()->to('/admin/jenis-izin')
                ->with('error', 'Jenis izin ini sudah punya berkas, jadi tidak bisa dihapus. Nonaktifkan saja.');
        }

        $this->model()->delete($id);

        return redirect()->to('/admin/jenis-izin')->with('sukses', 'Jenis izin berhasil dihapus.');
    }
}