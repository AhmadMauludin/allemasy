<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasPesdikModel extends Model
{
    protected $table            = 'tb_kelas_pesdik';
    protected $primaryKey       = 'id_kelas_pesdik';
    protected $allowedFields    = [
        'id_kelas',
        'id_pesdik',
        'tanggal_enroll',
        'status'
    ];

    protected $useTimestamps    = false;

    /**
     * Ambil semua kelas yang diikuti oleh seorang pesdik.
     */
    public function getKelasByPesdik($id_pesdik)
    {
        return $this->select('tb_kelas_pesdik.*, tb_kelas.nama_kelas, tb_kelas.jenis_kelas')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kelas_pesdik.id_kelas', 'left')
            ->where('tb_kelas_pesdik.id_pesdik', $id_pesdik)
            ->findAll();
    }

    /**
     * Ambil semua pesdik yang terdaftar dalam kelas tertentu.
     */
    public function getPesdikByKelas($id_kelas)
    {
        return $this->select('tb_kelas_pesdik.*, tb_pesdik.nama_lengkap, tb_pesdik.nis')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_kelas_pesdik.id_pesdik', 'left')
            ->where('tb_kelas_pesdik.id_kelas', $id_kelas)
            ->findAll();
    }

    /**
     * Cek apakah pesdik sudah terdaftar di kelas tertentu.
     */
    public function isEnrolled($id_pesdik, $id_kelas)
    {
        return $this->where('id_pesdik', $id_pesdik)
            ->where('id_kelas', $id_kelas)
            ->first();
    }
}
