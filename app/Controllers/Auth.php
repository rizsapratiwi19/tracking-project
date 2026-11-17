<?php

namespace App\Controllers;

use App\Models\PenggunaModel;

class Auth extends BaseController
{
    // Peran yang tampil di halaman login (admin sengaja tidak ditampilkan)
    private array $daftarPeran = [
        'front_office' => 'Front Office',
        'verifikator'  => 'Verifikator dan Validator',
        'back_office'  => 'Back Office',
        'cetak_izin'   => 'Cetak Izin',
        'kepala_dinas' => 'Kepala Dinas',
    ];

    public function pilihPeran()
    {
        if (session()->get('login')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/pilih_peran', ['daftarPeran' => $this->daftarPeran]);
    }

    public function formLogin($peran)
    {
        $semuaPeran = $this->daftarPeran + ['admin' => 'Admin'];

        if (! isset($semuaPeran[$peran])) {
            return redirect()->to('/login');
        }

        $pengguna = (new PenggunaModel())
            ->where('peran', $peran)
            ->where('aktif', 1)
            ->orderBy('nama')
            ->findAll();

        return view('auth/form_login', [
            'peran'      => $peran,
            'labelPeran' => $semuaPeran[$peran],
            'pengguna'   => $pengguna,
        ]);
    }

    public function proses()
    {
        $id       = (int) $this->request->getPost('pengguna_id');
        $password = (string) $this->request->getPost('password');
        $peran    = (string) $this->request->getPost('peran');

        $user = (new PenggunaModel())
            ->where('id', $id)
            ->where('aktif', 1)
            ->first();

        if (! $user || $user['peran'] !== $peran || ! password_verify($password, $user['password'])) {
            return redirect()->to('/login/' . $peran)->with('error', 'Nama atau kata sandi salah.');
        }

        session()->regenerate();
        session()->set([
            'login'   => true,
            'user_id' => $user['id'],
            'nama'    => $user['nama'],
            'peran'   => $user['peran'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}