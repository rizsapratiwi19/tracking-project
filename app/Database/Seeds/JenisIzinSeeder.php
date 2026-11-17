<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisIzinSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            ['nama' => 'PKKPR',                       'kode' => 'PKKPR',   'urutan' => 1, 'punya_pencabutan' => 0],
            ['nama' => 'Reklame',                     'kode' => 'REKLAME', 'urutan' => 2, 'punya_pencabutan' => 0],
            ['nama' => 'Izin Pendidikan',             'kode' => 'PEND',    'urutan' => 3, 'punya_pencabutan' => 0],
            ['nama' => 'Izin Rekomendasi Penelitian', 'kode' => 'REKPEN',  'urutan' => 4, 'punya_pencabutan' => 0],
            ['nama' => 'Izin Lingkungan',             'kode' => 'LING',    'urutan' => 5, 'punya_pencabutan' => 0],
            ['nama' => 'Izin Praktek Dokter Hewan',   'kode' => 'DOKHEW',  'urutan' => 6, 'punya_pencabutan' => 0],
            ['nama' => 'Izin Kesehatan',              'kode' => 'KES',     'urutan' => 7, 'punya_pencabutan' => 1],
        ];

        foreach ($data as &$row) {
            $row['aktif']      = 1;
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        unset($row);

        $this->db->table('jenis_izin')->insertBatch($data);
    }
}