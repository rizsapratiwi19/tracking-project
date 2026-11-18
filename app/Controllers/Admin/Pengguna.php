<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pengguna extends BaseController
{
    private array $daftarPeran = [
        'front_office' => 'Front Office',
        'verifikator'  => 'Verifikator dan Validator',
        'back_office'  => 'Back Office',
        'cetak_izin'   => 'Cetak Izin',
        'kepala_dinas' => 'Kepala Dinas',
        'admin'        => 'Admin',
    ];

    private function ambil(int $id): array
    {
        $item = (new PenggunaModel())->find($id);

        if (! $item) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $item;
    }

    private function peranValid(): string
    {
        return implode(',', array_keys($this->daftarPeran));
    }

    public function index()
    {
        return view('admin/pengguna/index', [
            'judul'       => 'Pengguna',
            'daftar'      => (new PenggunaModel())->orderBy('peran')->orderBy('nama')->findAll(),
            'daftarPeran' => $this->daftarPeran,
        ]);
    }

    public function tambah()
    {
        return view('admin/pengguna/form', [
            'judul'       => 'Tambah Pengguna',
            'item'        => null,
            'aksi'        => site_url('admin/pengguna/simpan'),
            'daftarPeran' => $this->daftarPeran,
        ]);
    }

    public function simpan()
    {
        $rules = [
            'nama'     => 'required|max_length[100]',
            'username' => 'required|alpha_numeric|min_length[3]|max_length[50]|is_unique[pengguna.username]',
            'password' => 'required|min_length[8]|max_length[72]',
            'peran'    => 'required|in_list[' . $this->peranValid() . ']',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        (new PenggunaModel())->insert([
            'nama'     => trim($this->request->getPost('nama')),
            'username' => strtolower(trim($this->request->getPost('username'))),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'peran'    => $this->request->getPost('peran'),
            'aktif'    => 1,
        ]);

        return redirect()->to('/admin/pengguna')->with('sukses', 'Pengguna berhasil ditambahkan.');
    }

    public function ubah($id)
    {
        return view('admin/pengguna/form', [
            'judul'       => 'Ubah Pengguna',
            'item'        => $this->ambil((int) $id),
            'aksi'        => site_url('admin/pengguna/perbarui/' . (int) $id),
            'daftarPeran' => $this->daftarPeran,
        ]);
    }

    public function perbarui($id)
    {
        $id   = (int) $id;
        $item = $this->ambil($id);

        $rules = [
            'nama'     => 'required|max_length[100]',
            'username' => "required|alpha_numeric|min_length[3]|max_length[50]|is_unique[pengguna.username,id,{$id}]",
            'password' => 'permit_empty|min_length[8]|max_length[72]',
            'peran'    => 'required|in_list[' . $this->peranValid() . ']',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Akun sendiri tidak boleh diubah perannya, supaya admin tidak mengunci dirinya
        $peran = ($id === (int) session()->get('user_id'))
            ? $item['peran']
            : $this->request->getPost('peran');

        $data = [
            'nama'     => trim($this->request->getPost('nama')),
            'username' => strtolower(trim($this->request->getPost('username'))),
            'peran'    => $peran,
        ];

        $passwordBaru = (string) $this->request->getPost('password');
        if ($passwordBaru !== '') {
            $data['password'] = password_hash($passwordBaru, PASSWORD_DEFAULT);
        }

        (new PenggunaModel())->update($id, $data);

        return redirect()->to('/admin/pengguna')->with('sukses', 'Data pengguna diperbarui.');
    }

    public function status($id)
    {
        $id   = (int) $id;
        $item = $this->ambil($id);

        if ($id === (int) session()->get('user_id')) {
            return redirect()->to('/admin/pengguna')->with('error', 'Akun yang sedang dipakai tidak bisa dinonaktifkan.');
        }

        (new PenggunaModel())->update($id, ['aktif' => $item['aktif'] ? 0 : 1]);

        return redirect()->to('/admin/pengguna')->with('sukses', 'Status pengguna diubah.');
    }
}