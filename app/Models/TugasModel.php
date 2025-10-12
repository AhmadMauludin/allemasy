<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasModel extends Model
{
    protected $table = 'tb_tugas';
    protected $primaryKey = 'id_tugas';
    protected $allowedFields = ['id_pertemuan', 'judul', 'instruksi', 'deadline', 'status', 'file'];

    public function getByPertemuan($id_pertemuan)
    {
        return $this->where('id_pertemuan', $id_pertemuan)->findAll();
    }
}
