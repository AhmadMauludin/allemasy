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
        'id_buku',
        'status',
        'ket',
        'foto'
    ];

    public function getMapelWithBuku()
    {
        return $this->select('tb_mapel.*, tb_buku.judul AS nama_buku')
            ->join('tb_buku', 'tb_buku.id_buku = tb_mapel.id_buku', 'left')
            ->findAll();
    }
}
