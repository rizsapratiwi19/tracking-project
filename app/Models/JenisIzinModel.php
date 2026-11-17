<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisIzinModel extends Model
{
    protected $table         = 'jenis_izin';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['nama', 'kode', 'urutan', 'punya_pencabutan', 'aktif'];
    protected $useTimestamps = true;
}