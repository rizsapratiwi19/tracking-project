<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TahapanAlurSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // Dari kartu kendali KKPR. Pembagian peran masih SEMENTARA dan perlu dikonfirmasi pembimbing.
        $tahapKkpr = [
            ['Penerimaan Berkas',                                         'front_office'],
            ['Register Berkas',                                           'front_office'],
            ['Verifikasi',                                                'verifikator'],
            ['Cetak Surat Tanggapan',                                     'cetak_izin'],
            ['Cetak Surat Tugas',                                         'back_office'],
            ['Survey Lapangan',                                           'back_office'],
            ['Penerimaan Pertimbangan / Kajian Teknis dari Dinas PUPR',   'back_office'],
            ['Penerimaan Pertimbangan Teknis Pertanahan dari ATR/BPN',    'back_office'],
            ['Cetak Sertifikat Izin',                                     'cetak_izin'],
            ['Validasi',                                                  'verifikator'],
            ['Penandatanganan Izin',                                      'kepala_dinas'],
            ['Penomoran dan Pengarsipan',                                 'cetak_izin'],
        ];

        // Tahap umum sementara untuk jenis izin lain, sampai kartu kendalinya ada
        $tahapUmum = [
            ['Penerimaan Berkas',         'front_office'],
            ['Register Berkas',           'front_office'],
            ['Verifikasi',                'verifikator'],
            ['Cetak Surat Tanggapan',     'cetak_izin'],
            ['Survey Lapangan',           'back_office'],
            ['Cetak Sertifikat Izin',     'cetak_izin'],
            ['Validasi',                  'verifikator'],
            ['Penandatanganan Izin',      'kepala_dinas'],
            ['Penomoran dan Pengarsipan', 'cetak_izin'],
        ];

        $rows = [];

        foreach ($this->db->table('jenis_izin')->get()->getResultArray() as $jenis) {
            $tahap  = ($jenis['kode'] === 'PKKPR') ? $tahapKkpr : $tahapUmum;
            $urutan = 1;

            foreach ($tahap as [$nama, $peran]) {
                $rows[] = [
                    'jenis_izin_id' => $jenis['id'],
                    'urutan'        => $urutan++,
                    'nama_tahap'    => $nama,
                    'peran'         => $peran,
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }

        $this->db->table('tahapan_alur')->insertBatch($rows);
    }
}