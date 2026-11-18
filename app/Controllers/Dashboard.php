<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('login')) {
            return redirect()->to('/login');
        }

        $peran = session()->get('peran');

        if ($peran === 'front_office') {
            return redirect()->to('/permohonan');
        }

        if ($peran !== 'admin') {
            return redirect()->to('/tugas');
        }

        return view('dashboard/index');
    }
}