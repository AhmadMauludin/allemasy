<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'tb_buku';
    protected $primaryKey = 'id_buku';
    protected $allowedFields = [
        'judul', 'pengarang', 'penerbit', 'keilmuan', 'tahun', 'status', 'ket', 'foto'
    ];

    public function search($keyword)
    {
        return $this->table($this->table)
            ->like('judul', $keyword)
            ->orLike('pengarang', $keyword)
            ->orLike('penerbit', $keyword)
            ->orLike('keilmuan', $keyword);
    }
}
