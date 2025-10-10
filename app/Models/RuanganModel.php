<?php

namespace App\Models;

use CodeIgniter\Model;

class RuanganModel extends Model
{
    protected $table = 'tb_ruangan';
    protected $primaryKey = 'id_ruangan';
    protected $allowedFields = [
        'id_user',
        'nama_ruangan',
        'latitude',
        'longitude',
        'status',
        'ket',
        'foto'
    ];
}
