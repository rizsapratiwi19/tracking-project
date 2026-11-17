<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Belum login: kembali ke halaman login
        if (! session()->get('login')) {
            return redirect()->to('/login');
        }

        // Kalau filter diberi daftar peran, peran pengguna harus ada di daftar itu
        if (! empty($arguments) && ! in_array(session()->get('peran'), $arguments, true)) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak punya akses ke halaman itu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}