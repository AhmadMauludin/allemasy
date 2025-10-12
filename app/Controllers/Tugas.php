<?php

namespace App\Controllers;

use App\Models\TugasModel;
use CodeIgniter\Controller;

class Tugas extends Controller
{
    protected $tugasModel;

    public function __construct()
    {
        $this->tugasModel = new TugasModel();
    }

    public function store()
    {
        $idPertemuan = $this->request->getPost('id_pertemuan');
        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/tugas', $fileName);
        }

        $data = [
            'id_pertemuan' => $idPertemuan,
            'judul'        => $this->request->getPost('judul'),
            'instruksi'    => $this->request->getPost('instruksi'),
            'deadline'     => $this->request->getPost('deadline'),
            'status'       => $this->request->getPost('status'),
            'file'         => $fileName,
        ];

        $this->tugasModel->insert($data);

        return redirect()->to(base_url('pertemuan/detail/' . $idPertemuan))
            ->with('success', 'Tugas berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $tugas = $this->tugasModel->find($id);
        if ($tugas && $tugas['file']) {
            $filePath = 'uploads/tugas/' . $tugas['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->tugasModel->delete($id);

        return redirect()->back()->with('success', 'Tugas berhasil dihapus.');
    }
}
