<?php

namespace App\Models;

use CodeIgniter\Model;

class PresensiModel extends Model
{
    protected $table = 'tb_presensi';
    protected $primaryKey = 'id_presensi';
    protected $allowedFields = ['id_pertemuan', 'id_pesdik', 'status', 'ket', 'foto'];
}
