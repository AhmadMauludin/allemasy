<?php

namespace App\Controllers;

use App\Models\PembayaranModel;

class Pembayaran extends BaseController
{
    protected $pembayaranModel;

    public function __construct()
    {
        $this->pembayaranModel = new PembayaranModel();
    }

    // Edit pembayaran
    public function edit($id)
    {
        $data['pembayaran'] = $this->pembayaranModel->find($id);

        if (!$data['pembayaran']) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('pembayaran/edit', $data);
    }

    // Update pembayaran
    public function update($id)
    {
        $pembayaran = $this->pembayaranModel->find($id);
        if (!$pembayaran) return redirect()->back()->with('error', 'Data tidak ditemukan');

        $role = session('role');

        $data = [];
        if ($role === 'pesdik') {
            // Hanya update metode & bukti
            $data['metode'] = $this->request->getPost('metode');

            // Upload bukti
            $file = $this->request->getFile('bukti');
            if ($file && $file->isValid()) {
                $newName = $file->getRandomName();
                $file->move('uploads/pembayaran', $newName);
                $data['bukti'] = $newName;
            }
        } else {
            // Admin bisa update semua
            $data['status_pembayaran'] = $this->request->getPost('status_pembayaran');
            $data['metode'] = $this->request->getPost('metode');
            $data['keterangan_bayar'] = $this->request->getPost('keterangan_bayar');
            // Upload bukti
            $file = $this->request->getFile('bukti');
            if ($file && $file->isValid()) {
                $newName = $file->getRandomName();
                $file->move('uploads/pembayaran', $newName);
                $data['bukti'] = $newName;
            }
        }

        $this->pembayaranModel->update($id, $data);
        return redirect()->back()->with('success', 'Data pembayaran berhasil diupdate');
    }
}
