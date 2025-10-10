<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $table = 'tb_jabatan';
    protected $primaryKey = 'id_jabatan';
    protected $allowedFields = ['id_user', 'jabatan', 'status'];
}
