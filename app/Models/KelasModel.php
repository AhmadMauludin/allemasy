<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'tb_kelas';
    protected $primaryKey = 'id_kelas';
    protected $allowedFields = [
        'nama_kelas',
        'jenis_kelas',
        'tingkat',
        'id_user',
        'id_ruangan',
        'ket',
        'status',
        'foto'
    ];

    public function getPesdikByJenisTingkat($jenis_kelas, $tingkat = null)
    {
        $builder = $this->db->table('tb_kelas_pesdik kp')
            ->join('tb_kelas k', 'kp.id_kelas = k.id_kelas')
            ->select('kp.id_pesdik');

        $builder->where('k.jenis_kelas', $jenis_kelas);
        if ($tingkat && $tingkat != 'Semua') {
            $builder->where('k.tingkat', $tingkat);
        }

        return $builder->get()->getResultArray();
    }
}
