<?php

namespace App\Models;

use CodeIgniter\Model;

class KompetensiModel extends Model
{
    protected $table = 'tb_kompetensi';
    protected $primaryKey = 'id_kompetensi';
    protected $allowedFields = [
        'jenis_kompetensi',
        'id_mapel',
        'id_buku',
        'status',
        'keterangan',
        'foto'
    ];

    public function getAll()
    {
        return $this->select('tb_kompetensi.*, tb_mapel.nama_mapel, tb_buku.judul')
            ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kompetensi.id_mapel', 'left')
            ->join('tb_buku', 'tb_buku.id_buku = tb_kompetensi.id_buku', 'left')
            ->orderBy('id_kompetensi', 'DESC')
            ->findAll();
    }
}
