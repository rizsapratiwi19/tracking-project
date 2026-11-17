<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (! session()->get('login')) {
            return redirect()->to('/login');
        }

        if (session()->get('peran') === 'front_office') {
            return redirect()->to('/permohonan');
        }

        return view('dashboard/index');
    }
}