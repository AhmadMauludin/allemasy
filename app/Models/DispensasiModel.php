<?php

namespace App\Models;

use CodeIgniter\Model;

class DispensasiModel extends Model
{
    protected $table = 'tb_dispensasi';
    protected $primaryKey = 'id_dispensasi';
    protected $allowedFields = ['id_user_pesdik', 'tanggal', 'alasan', 'id_user_guru', 'status', 'ket'];

    // Relasi untuk menampilkan nama guru & pesdik
    public function getAll()
    {
        return $this->select('tb_dispensasi.*, 
                              guru.username as nama_guru, 
                              pesdik.username as nama_pesdik')
            ->join('tb_user as guru', 'guru.id_user = tb_dispensasi.id_user_guru', 'left')
            ->join('tb_user as pesdik', 'pesdik.id_user = tb_dispensasi.id_user_pesdik', 'left')
            ->orderBy('tb_dispensasi.tanggal', 'DESC')
            ->findAll();
    }

    public function getById($id)
    {
        return $this->select('tb_dispensasi.*, 
                              guru.username as nama_guru, 
                              pesdik.username as nama_pesdik')
            ->join('tb_user as guru', 'guru.id_user = tb_dispensasi.id_user_guru', 'left')
            ->join('tb_user as pesdik', 'pesdik.id_user = tb_dispensasi.id_user_pesdik', 'left')
            ->where('id_dispensasi', $id)
            ->first();
    }
}
