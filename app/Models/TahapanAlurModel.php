<?php

namespace App\Models;

use CodeIgniter\Model;

class TahapanAlurModel extends Model
{
    protected $table         = 'tahapan_alur';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['jenis_izin_id', 'urutan', 'nama_tahap', 'peran'];
    protected $useTimestamps = true;
}