<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table = 'tb_materi';
    protected $primaryKey = 'id_materi';
    protected $allowedFields = ['id_pertemuan', 'judul', 'deskripsi', 'file', 'link_video', 'status'];

    public function getByPertemuan($id_pertemuan)
    {
        return $this->where('id_pertemuan', $id_pertemuan)->findAll();
    }
}
