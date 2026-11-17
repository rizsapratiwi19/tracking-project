<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $passwordContoh = password_hash('password123', PASSWORD_DEFAULT);

        $data = [
            ['nama' => 'Admin Sistem',        'username' => 'admin',        'peran' => 'admin'],
            ['nama' => 'Front Office Contoh', 'username' => 'frontoffice1', 'peran' => 'front_office'],
            ['nama' => 'Verifikator Contoh',  'username' => 'verifikator1', 'peran' => 'verifikator'],
        ];

        foreach ($data as &$row) {
            $row['password']   = $passwordContoh;
            $row['aktif']      = 1;
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        unset($row);

        $this->db->table('pengguna')->insertBatch($data);
    }
}