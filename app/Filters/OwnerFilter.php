<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class OwnerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $role = $session->get('role');
        $id_pesdik_session = $session->get('id_pesdik');

        // Jika role bukan pesdik, maka bebas (misalnya admin)
        if ($role !== 'pesdik') {
            return;
        }

        // Ambil ID dari URL, misal /tabungan/edit/5 → 5
        $id_url = service('uri')->getSegment(3);

        // Pastikan ada argumen nama tabel dan field id_pesdik
        if (empty($arguments) || count($arguments) < 2) {
            throw new \Exception('OwnerFilter membutuhkan 2 argumen: [nama_tabel, field_primary]');
        }

        [$table, $primaryField] = $arguments;

        // Ambil koneksi ke database
        $db = db_connect();
        $builder = $db->table($table)->select('id_pesdik')->where($primaryField, $id_url);
        $row = $builder->get()->getRow();

        // Jika data tidak ditemukan atau id_pesdik tidak cocok
        if (!$row || $row->id_pesdik != $id_pesdik_session) {
            return redirect()->to('/')->with('error', 'Anda tidak memiliki izin untuk mengakses data tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi setelah
    }
}
