<?php

namespace App\Controllers;

use App\Models\MateriModel;
use CodeIgniter\Controller;

class Materi extends Controller
{
    protected $materiModel;

    public function __construct()
    {
        $this->materiModel = new MateriModel();
    }

    public function store()
    {
        $idPertemuan = $this->request->getPost('id_pertemuan');
        $file = $this->request->getFile('file');
        $fileName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/materi', $fileName);
        }

        $data = [
            'id_pertemuan' => $idPertemuan,
            'judul'        => $this->request->getPost('judul'),
            'deskripsi'    => $this->request->getPost('deskripsi'),
            'file'         => $fileName,
            'link_video'   => $this->request->getPost('link_video'),
            'status'       => $this->request->getPost('status'),
        ];

        $this->materiModel->insert($data);

        return redirect()->to(base_url('pertemuan/detail/' . $idPertemuan))
            ->with('success', 'Materi berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $materi = $this->materiModel->find($id);
        if ($materi && $materi['file']) {
            $filePath = 'uploads/materi/' . $materi['file'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->materiModel->delete($id);

        return redirect()->back()->with('success', 'Materi berhasil dihapus.');
    }
}
