<?php

namespace App\Models;

use CodeIgniter\Model;

class PengumpulanTugasModel extends Model
{
    protected $table = 'tb_pengumpulan_tugas';
    protected $primaryKey = 'id_pengumpulan_tugas';
    protected $allowedFields = [
        'id_tugas',
        'id_pesdik',
        'lampiran',
        'nilai',
        'status',
        'intruksi'
    ];

    // Ambil semua pengumpulan berdasarkan id_tugas
    public function getByTugas($id_tugas)
    {
        return $this->select('tb_pengumpulan_tugas.*, tb_pesdik.nama as nama_pesdik')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_pengumpulan_tugas.id_pesdik', 'left')
            ->where('tb_pengumpulan_tugas.id_tugas', $id_tugas)
            ->findAll();
    }

    // Ambil pengumpulan berdasarkan id_tugas dan id_pesdik (untuk cek apakah sudah dikumpul)
    public function getByTugasAndPesdik($id_tugas, $id_pesdik)
    {
        return $this->where(['id_tugas' => $id_tugas, 'id_pesdik' => $id_pesdik])->first();
    }
}
