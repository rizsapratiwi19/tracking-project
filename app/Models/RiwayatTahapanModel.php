<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatTahapanModel extends Model
{
    protected $table         = 'riwayat_tahapan';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['permohonan_id', 'tahapan_id', 'pengguna_id', 'tanggal', 'catatan'];
    protected $useTimestamps = true;
    protected $updatedField  = '';
}