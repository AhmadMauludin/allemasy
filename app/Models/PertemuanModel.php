<?php

namespace App\Models;

use CodeIgniter\Model;

class PertemuanModel extends Model
{
    protected $table = 'tb_pertemuan';
    protected $primaryKey = 'id_pertemuan';
    protected $allowedFields = ['id_jadwal', 'tanggal', 'status', 'ket', 'materi', 'foto'];
}
