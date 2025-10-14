<?php

namespace App\Models;

use CodeIgniter\Model;

class UjikomModel extends Model
{
    protected $table = 'tb_ujikom';
    protected $primaryKey = 'id_ujikom';
    protected $allowedFields = [
        'id_kompetensi_pesdik',
        'waktu',
        'status',
        'rincian',
        'foto'
    ];

    protected $useTimestamps = false;
}
