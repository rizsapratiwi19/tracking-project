<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaLainSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $passwordContoh = password_hash('password123', PASSWORD_DEFAULT);

        $data = [
            ['nama' => 'Back Office Contoh',  'username' => 'backoffice1', 'peran' => 'back_office'],
            ['nama' => 'Cetak Izin Contoh',   'username' => 'cetakizin1',  'peran' => 'cetak_izin'],
            ['nama' => 'Kepala Dinas Contoh', 'username' => 'kepaladinas1', 'peran' => 'kepala_dinas'],
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