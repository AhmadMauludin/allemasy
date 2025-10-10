<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table = 'tb_guru';
    protected $primaryKey = 'id_guru';
    protected $allowedFields = ['id_user', 'nama', 'nip', 'alamat', 'tanggal_lahir', 'telp', 'email', 'status', 'foto'];
}
