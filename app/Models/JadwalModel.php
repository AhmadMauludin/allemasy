<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'tb_jadwal';
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = [
        'id_kontrak_jadwal',
        'hari',
        'jampel',
        'waktu_mulai',
        'waktu_selesai',
        'id_ruangan',
        'status',
        'ket',
        'foto'
    ];

    public function getAllJadwal()
    {
        return $this->select('tb_jadwal.*, 
                              tb_kontrak_jadwal.id_tahun_ajaran,
                              tb_kontrak_jadwal.jumlah_jam,
                              tb_mapel.nama_mapel,
                              tb_kelas.nama_kelas,
                              tb_user.username AS nama_guru,
                              tb_ruangan.nama_ruangan')
            ->join('tb_kontrak_jadwal', 'tb_kontrak_jadwal.id_kontrak_jadwal = tb_jadwal.id_kontrak_jadwal', 'left')
            ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
            ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
            ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_jadwal.id_ruangan', 'left')
            ->orderBy('FIELD(hari, "Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu")', '', false)
            ->orderBy('waktu_mulai', 'ASC')
            ->findAll();
    }
}
