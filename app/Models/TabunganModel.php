<?php

namespace App\Models;

use CodeIgniter\Model;

class TabunganModel extends Model
{
    protected $table = 'tb_tabungan';
    protected $primaryKey = 'id_tabungan';
    protected $allowedFields = [
        'id_pesdik',
        'tanggal_transaksi',
        'jenis_transaksi',
        'jumlah',
        'keterangan',
        'bukti_transaksi',
        'verifikator',
        'status_transaksi'
    ];

    protected $useTimestamps = true;

    public function getAllData($role, $id_pesdik = null, $keyword = null, $tanggal = null, $jenis_transaksi = null)
    {
        $builder = $this->select('tb_tabungan.*, tb_pesdik.nama, tb_user.username as nama_verifikator')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_tabungan.id_pesdik', 'left')
            ->join('tb_user', 'tb_user.id_user = tb_tabungan.verifikator', 'left');

        // Filter role
        if ($role === 'pesdik') {
            $builder->where('tb_tabungan.id_pesdik', $id_pesdik);
        }

        // 🔍 Filter pencarian nama pesdik
        if (!empty($keyword)) {
            $builder->like('tb_pesdik.nama', $keyword);
        }

        // 📅 Filter tanggal transaksi
        if (!empty($tanggal)) {
            $builder->where('DATE(tb_tabungan.tanggal_transaksi)', $tanggal);
        }

        // 💰 Filter jenis transaksi
        if (!empty($jenis_transaksi)) {
            $builder->where('tb_tabungan.jenis_transaksi', $jenis_transaksi);
        }

        // Urutkan terbaru
        $builder->orderBy('tb_tabungan.tanggal_transaksi', 'DESC');

        // ✅ Return builder (bukan findAll, supaya bisa paginate)
        return $builder;
    }


    public function getSaldo($id_pesdik)
    {
        $setor = $this->where(['id_pesdik' => $id_pesdik, 'jenis_transaksi' => 'setor', 'status_transaksi' => 'disetujui'])->selectSum('jumlah')->get()->getRow()->jumlah ?? 0;
        $tarik = $this->where(['id_pesdik' => $id_pesdik, 'jenis_transaksi' => 'tarik', 'status_transaksi' => 'disetujui'])->selectSum('jumlah')->get()->getRow()->jumlah ?? 0;
        return $setor - $tarik;
    }
}
