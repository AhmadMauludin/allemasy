<?php

namespace App\Models;

use CodeIgniter\Model;

class TahunAjaranModel extends Model
{
    protected $table = 'tb_tahun_ajaran';
    protected $primaryKey = 'id_tahun_ajaran';
    protected $allowedFields = [
        'tahun',
        'semester',
        'status',
        'ket'
    ];
}
