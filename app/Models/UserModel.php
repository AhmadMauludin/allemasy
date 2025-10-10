<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'tb_user';
    protected $primaryKey       = 'id_user';
    protected $allowedFields    = ['username', 'password', 'role', 'status', 'foto'];
    protected $useTimestamps    = false; // ubah ke true jika kamu punya kolom created_at / updated_at

    /**
     * Ambil data user berdasarkan username
     */
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * Fitur pencarian user
     */
    public function search($keyword)
    {
        if (!$keyword) {
            return $this;
        }

        return $this->groupStart()
            ->like('username', $keyword)
            ->orLike('role', $keyword)
            ->orLike('status', $keyword)
            ->groupEnd();
    }
}
