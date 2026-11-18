<?php

namespace App\Controllers;

use App\Models\PermohonanModel;
use App\Models\RiwayatTahapanModel;
use App\Models\TahapanAlurModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Berkas extends BaseController
{
    private function ambil(int $id): array
    {
        $row = (new PermohonanModel())
            ->select('permohonan.*, jenis_izin.nama AS nama_jenis')
            ->join('jenis_izin', 'jenis_izin.id = permohonan.jenis_izin_id')
            ->where('permohonan.id', $id)
            ->first();

        if (! $row) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $row;
    }

    public function tugas()
    {
        $peran = session()->get('peran');

        $query = (new PermohonanModel())
            ->select('permohonan.*, jenis_izin.nama AS nama_jenis, tahapan_alur.nama_tahap, tahapan_alur.peran AS peran_tahap')
            ->join('jenis_izin', 'jenis_izin.id = permohonan.jenis_izin_id')
            ->join('tahapan_alur', 'tahapan_alur.id = permohonan.tahapan_id')
            ->where('permohonan.status', 'proses');

        // Admin melihat semua tugas; peran lain hanya yang menjadi bagiannya
        if ($peran !== 'admin') {
            $query->where('tahapan_alur.peran', $peran);
        }

        $daftar = $query
            ->orderBy('permohonan.tanggal_terima', 'ASC')
            ->orderBy('permohonan.id', 'ASC')
            ->findAll();

        return view('berkas/tugas', [
            'judul'  => 'Tugas Saya',
            'daftar' => $daftar,
            'semua'  => ($peran === 'admin'),
        ]);
    }

    public function detail($id)
    {
        $p = $this->ambil((int) $id);

        $tahapan = (new TahapanAlurModel())
            ->where('jenis_izin_id', $p['jenis_izin_id'])
            ->orderBy('urutan')
            ->findAll();

        $baris = (new RiwayatTahapanModel())
            ->select('riwayat_tahapan.*, pengguna.nama AS nama_pengguna')
            ->join('pengguna', 'pengguna.id = riwayat_tahapan.pengguna_id', 'left')
            ->where('riwayat_tahapan.permohonan_id', $p['id'])
            ->findAll();

        $riwayat = [];
        foreach ($baris as $r) {
            $riwayat[$r['tahapan_id']] = $r;
        }

        $tahapSekarang = null;
        foreach ($tahapan as $t) {
            if ((int) $t['id'] === (int) $p['tahapan_id']) {
                $tahapSekarang = $t;
            }
        }

        $idTerakhir = $tahapan ? $tahapan[count($tahapan) - 1]['id'] : null;

        $bisaProses = $p['status'] === 'proses'
            && $tahapSekarang !== null
            && $tahapSekarang['peran'] === session()->get('peran');

        return view('berkas/detail', [
            'judul'         => 'Detail Berkas',
            'p'             => $p,
            'tahapan'       => $tahapan,
            'riwayat'       => $riwayat,
            'tahapSekarang' => $tahapSekarang,
            'terakhir'      => $tahapSekarang !== null && (int) $tahapSekarang['id'] === (int) $idTerakhir,
            'bisaProses'    => $bisaProses,
        ]);
    }

    public function teruskan($id)
    {
        $p      = $this->ambil((int) $id);
        $balik  = redirect()->to('/berkas/' . $p['id']);
        $model  = new TahapanAlurModel();

        $sekarang = $p['tahapan_id'] ? $model->find($p['tahapan_id']) : null;

        if ($p['status'] !== 'proses' || ! $sekarang) {
            return $balik->with('error', 'Berkas ini tidak sedang menunggu tindakan.');
        }

        // Mencegah klik ganda atau halaman lama yang masih terbuka
        if ((int) $this->request->getPost('tahapan_id') !== (int) $sekarang['id']) {
            return $balik->with('error', 'Tahap berkas sudah berubah. Silakan periksa kembali.');
        }

        if ($sekarang['peran'] !== session()->get('peran')) {
            return $balik->with('error', 'Tahap ini bukan bagian dari peran Anda.');
        }

        $berikut = $model
            ->where('jenis_izin_id', $p['jenis_izin_id'])
            ->where('urutan >', $sekarang['urutan'])
            ->orderBy('urutan')
            ->first();

        $db = \Config\Database::connect();
        $db->transStart();

        (new RiwayatTahapanModel())->insert([
            'permohonan_id' => $p['id'],
            'tahapan_id'    => $sekarang['id'],
            'pengguna_id'   => session()->get('user_id'),
            'tanggal'       => date('Y-m-d H:i:s'),
            'catatan'       => trim((string) $this->request->getPost('catatan')) ?: null,
        ]);

        (new PermohonanModel())->update($p['id'], [
            'tahapan_id' => $berikut['id'] ?? null,
            'status'     => $berikut ? 'proses' : 'selesai',
        ]);

        $db->transComplete();

        if (! $db->transStatus()) {
            return $balik->with('error', 'Gagal menyimpan, silakan coba lagi.');
        }

        $pesan = $berikut
            ? 'Tahap "' . $sekarang['nama_tahap'] . '" selesai. Berkas diteruskan ke tahap "' . $berikut['nama_tahap'] . '".'
            : 'Tahap terakhir selesai. Berkas ditandai selesai.';

        return $balik->with('sukses', $pesan);
    }
}