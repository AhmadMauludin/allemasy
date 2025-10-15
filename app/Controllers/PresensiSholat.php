<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PresensiSholatModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PresensiSholat extends BaseController
{
    protected $presensiModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiSholatModel();
    }

    /**
     * Update status dan keterangan presensi sholat
     */
    public function update($id_presensi_sholat)
    {
        // Cek role user (hanya admin dan guru yang bisa)
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'guru'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengedit presensi.');
        }

        // Ambil data input
        $status_presensi = $this->request->getPost('status_presensi');
        $ket_presensi    = $this->request->getPost('ket_presensi');

        // Cek apakah data ada
        $presensi = $this->presensiModel->find($id_presensi_sholat);
        if (!$presensi) {
            throw PageNotFoundException::forPageNotFound('Presensi tidak ditemukan.');
        }

        // Update data presensi
        $this->presensiModel->update($id_presensi_sholat, [
            'status_presensi' => $status_presensi,
            'ket_presensi'    => $ket_presensi
        ]);

        return redirect()->back()->with('success', 'Presensi berhasil diperbarui.');
    }

    /**
     * Hapus data presensi sholat
     */
    public function delete($id_presensi_sholat)
    {
        // Cek role user (hanya admin dan guru yang bisa)
        $role = session()->get('role');
        if (!in_array($role, ['admin', 'guru'])) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus presensi.');
        }

        // Cek data
        $presensi = $this->presensiModel->find($id_presensi_sholat);
        if (!$presensi) {
            throw PageNotFoundException::forPageNotFound('Presensi tidak ditemukan.');
        }

        // Hapus data
        $this->presensiModel->delete($id_presensi_sholat);

        return redirect()->back()->with('success', 'Presensi berhasil dihapus.');
    }
}
