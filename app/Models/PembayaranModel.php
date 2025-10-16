<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table      = 'tb_pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $allowedFields = ['id_biaya', 'id_pesdik', 'status_pembayaran', 'metode', 'bukti', 'waktu_bayar', 'keterangan_bayar'];
}
