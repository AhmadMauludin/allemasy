<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiSholatModel extends Model
{
    protected $table = 'tb_presensi_sholat';
    protected $primaryKey = 'id_presensi_sholat';
    protected $allowedFields = [
        'id_sholat',
        'id_pesdik',
        'waktu_presensi',
        'status_presensi',
        'ket_presensi'
    ];
}
