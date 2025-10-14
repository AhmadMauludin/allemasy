<?php

namespace App\Models;

use CodeIgniter\Model;

class KompetensiPesdikModel extends Model
{
    protected $table = 'tb_kompetensi_pesdik';
    protected $primaryKey = 'id_kompetensi_pesdik';
    protected $allowedFields = [
        'id_kompetensi',
        'id_pesdik',
        'id_guru',
        'nomor_sk',
        'status',
        'predikat',
        'tanggal_selesai',
        'foto'
    ];

    public function getByKompetensi($id_kompetensi)
    {
        return $this->select('tb_kompetensi_pesdik.*, tb_user.username AS nama_pesdik, g.username AS nama_guru')
            ->join('tb_user', 'tb_user.id_user = tb_kompetensi_pesdik.id_pesdik', 'left')
            ->join('tb_user AS g', 'g.id_user = tb_kompetensi_pesdik.id_guru', 'left')
            ->where('tb_kompetensi_pesdik.id_kompetensi', $id_kompetensi)
            ->findAll();
    }
}
