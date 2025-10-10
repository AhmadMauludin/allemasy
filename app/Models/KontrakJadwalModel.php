<?php

namespace App\Models;

use CodeIgniter\Model;

class KontrakJadwalModel extends Model
{
    protected $table = 'tb_kontrak_jadwal';
    protected $primaryKey = 'id_kontrak_jadwal';
    protected $allowedFields = [
        'id_mapel',
        'id_user',
        'id_kelas',
        'id_tahun_ajaran',
        'jumlah_jam',
        'status',
        'ket',
        'foto'
    ];

    public function getAllKontrak()
    {
        return $this->select('tb_kontrak_jadwal.*, 
                              tb_mapel.nama_mapel, 
                              tb_kelas.nama_kelas,
                              tb_tahun_ajaran.tahun, 
                              tb_tahun_ajaran.semester,  
                              tb_user.username AS nama_guru')
            ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
            ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
            ->join('tb_tahun_ajaran', 'tb_tahun_ajaran.id_tahun_ajaran = tb_kontrak_jadwal.id_tahun_ajaran', 'left')
            ->findAll();
    }
}
