<?php

namespace App\Models;

use CodeIgniter\Model;

class PesdikModel extends Model
{
    protected $table = 'tb_pesdik';
    protected $primaryKey = 'id_pesdik';
    protected $allowedFields = ['id_user', 'nama', 'jk',  'nisn', 'nis', 'tanggal_lahir', 'telp', 'email', 'alamat', 'status', 'foto'];

    public function search($keyword)
    {
        if (!$keyword) {
            return $this;
        }

        return $this->groupStart()
            ->like('nama', $keyword)
            ->orLike('jk', $keyword)
            ->groupEnd();
    }
}
