<?php

namespace App\Models;

use CodeIgniter\Model;

class PermohonanModel extends Model
{
    protected $table         = 'permohonan';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'nomor_register', 'jenis_izin_id', 'jenis_proses', 'uraian_permohonan',
        'nama_pemohon', 'nama_kuasa', 'lokasi', 'no_hp', 'kelengkapan',
        'tanggal_terima', 'tahapan_id', 'status', 'dibuat_oleh',
    ];
    protected $useTimestamps = true;
}