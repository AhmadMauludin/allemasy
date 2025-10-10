<?php

namespace App\Controllers;

use App\Models\RuanganModel;
use App\Models\UserModel;

class Ruangan extends BaseController
{
    protected $ruanganModel;
    protected $userModel;

    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['ruangan'] = $this->ruanganModel
            ->select('tb_ruangan.*, tb_user.username as penanggung_jawab')
            ->join('tb_user', 'tb_user.id_user = tb_ruangan.id_user', 'left')
            ->findAll();

        return view('ruangan/index', $data);
    }

    public function create()
    {
        $data['staf'] = $this->userModel->whereIn('role', ['admin', 'staf', 'guru'])->findAll();
        return view('ruangan/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/ruangan', $fotoName);
        }

        $this->ruanganModel->save([
            'id_user' => $this->request->getPost('id_user'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $fotoName
        ]);

        return redirect()->to('/ruangan')->with('success', 'Data ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['ruangan'] = $this->ruanganModel->find($id);
        $data['staf'] = $this->userModel->whereIn('role', ['admin', 'staf', 'guru'])->findAll();
        return view('ruangan/edit', $data);
    }

    public function update($id)
    {
        $foto = $this->request->getFile('foto');
        $fotoName = $this->request->getPost('foto_lama');

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/ruangan', $fotoName);
        }

        $this->ruanganModel->update($id, [
            'id_user' => $this->request->getPost('id_user'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'latitude' => $this->request->getPost('latitude'),
            'longitude' => $this->request->getPost('longitude'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $fotoName
        ]);

        return redirect()->to('/ruangan')->with('success', 'Data ruangan berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->ruanganModel->delete($id);
        return redirect()->to('/ruangan')->with('success', 'Data ruangan berhasil dihapus!');
    }
}
