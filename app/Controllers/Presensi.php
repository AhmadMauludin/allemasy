<?php

namespace App\Controllers;

use App\Models\PresensiModel;
use CodeIgniter\Controller;

class Presensi extends Controller
{
    protected $presensiModel;

    public function __construct()
    {
        $this->presensiModel = new PresensiModel();
    }

    // ✅ Halaman edit presensi
    public function edit($id)
    {
        $data['presensi'] = $this->presensiModel->find($id);
        if (!$data['presensi']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data presensi tidak ditemukan.");
        }

        return view('presensi/edit', $data);
    }

    // ✅ Proses update data presensi
    public function update($id)
    {
        $presensi = $this->presensiModel->find($id);
        if (!$presensi) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan.");
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'ket'    => $this->request->getPost('ket'),
        ];

        // proses upload file jika ada
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/bukti', $newName);
            $data['foto'] = $newName;
        }

        $this->presensiModel->update($id, $data);

        // 🔁 arahkan kembali ke detail pertemuan yang sesuai
        return redirect()
            ->to(base_url('pertemuan/detail/' . $presensi['id_pertemuan']))
            ->with('success', 'Data presensi berhasil diperbarui.');
    }
}
