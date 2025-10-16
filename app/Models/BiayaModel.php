<?php

namespace App\Models;

use CodeIgniter\Model;

class BiayaModel extends Model
{
    protected $table      = 'tb_biaya';
    protected $primaryKey = 'id_biaya';
    protected $allowedFields = [
        'jenis_biaya',
        'peruntukan',
        'tingkat',
        'biaya',
        'status_biaya',
        'keterangan_biaya'
    ];
}
