<?php

namespace App\Models;

use CodeIgniter\Model;

class SholatModel extends Model
{
    protected $table = 'tb_sholat';
    protected $primaryKey = 'id_sholat';
    protected $allowedFields = [
        'hari',
        'tanggal',
        'sholat',
        'waktu_mulai',
        'waktu_selesai',
        'status_sholat',
        'ket_sholat'
    ];
}
