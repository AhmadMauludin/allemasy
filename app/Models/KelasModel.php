<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'tb_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = [
        'nama_kelas',
        'jenis_kelas',
        'tingkat',
        'id_user',
        'id_ruangan',
        'ket',
        'status',
        'foto'
    ];
}
