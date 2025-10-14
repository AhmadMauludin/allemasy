<?php

namespace App\Controllers;

use App\Models\KelasPesdikModel;
use App\Models\KelasModel;
use App\Models\PesdikModel;
use CodeIgniter\Controller;

class KelasPesdik extends BaseController
{
    protected $kelasPesdikModel;
    protected $kelasModel;
    protected $pesdikModel;

    public function __construct()
    {
        $this->kelasPesdikModel = new KelasPesdikModel();
        $this->kelasModel = new KelasModel();
        $this->pesdikModel = new PesdikModel();
    }

    /**
     * Simpan data enroll kelas untuk peserta didik
     */
    public function store()
    {
        $id_pesdik = $this->request->getPost('id_pesdik');
        $id_kelas  = $this->request->getPost('id_kelas');

        // Cegah duplikasi enroll
        $cek = $this->kelasPesdikModel
            ->where('id_pesdik', $id_pesdik)
            ->where('id_kelas', $id_kelas)
            ->first();

        if ($cek) {
            return redirect()->back()->with('error', 'Peserta didik sudah terdaftar di kelas ini.');
        }

        // Simpan enroll baru
        $this->kelasPesdikModel->insert([
            'id_pesdik' => $id_pesdik,
            'id_kelas'  => $id_kelas,
        ]);

        return redirect()->back()->with('success', 'Kelas berhasil ditambahkan untuk peserta didik.');
    }

    /**
     * Hapus kelas dari peserta didik (unenroll)
     */
    public function delete($id)
    {
        $data = $this->kelasPesdikModel->find($id);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $this->kelasPesdikModel->delete($id);

        return redirect()->back()->with('success', 'Kelas berhasil dihapus dari peserta didik.');
    }
}
