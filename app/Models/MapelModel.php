<?php

namespace App\Models;

use CodeIgniter\Model;

class MapelModel extends Model
{
    protected $table = 'tb_mapel';
    protected $primaryKey = 'id_mapel';
    protected $allowedFields = [
        'kode_mapel',
        'nama_mapel',
        'golongan',
        'tingkat',
        'status',
        'ket',
        'foto'
    ];

    public function getMapelWithBuku()
    {
        return $this->select('tb_mapel.*')
            ->findAll();
    }
}
