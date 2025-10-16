<?php

namespace App\Models;

use CodeIgniter\Model;

class TransferModel extends Model
{
    protected $table = 'tb_transfer';
    protected $primaryKey = 'id_transfer';
    protected $allowedFields = [
        'id_pesdik',
        'peruntukan',
        'jumlah',
        'bukti_transfer',
        'status_transfer',
        'waktu_transfer',
        'keterangan_transfer',
        'verifikator'
    ];
}
