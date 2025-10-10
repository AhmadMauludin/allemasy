<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\UserModel;
use App\Models\JabatanModel;

class Guru extends BaseController
{
    protected $guruModel;
    protected $userModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->guruModel = new GuruModel();
        $this->userModel = new UserModel();
        $this->jabatanModel = new JabatanModel();
    }

    public function index()
    {
        $data['guru'] = $this->guruModel
            ->select('tb_guru.*, tb_user.username')
            ->join('tb_user', 'tb_user.id_user = tb_guru.id_user', 'left')
            ->findAll();

        $data['title'] = 'Data Guru';
        return view('guru/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Guru';
        $data['users'] = $this->userModel->where('role', 'guru')->findAll();
        return view('guru/create', $data);
    }

    public function store()
    {
        $this->guruModel->save([
            'id_user' => $this->request->getPost('id_user'),
            'nama' => $this->request->getPost('nama'),
            'nip' => $this->request->getPost('nip'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status'),
            'foto' => $this->uploadFoto()
        ]);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['guru'] = $this->guruModel->find($id);
        $data['users'] = $this->userModel->where('role', 'guru')->findAll();
        $data['title'] = 'Edit Guru';
        return view('guru/edit', $data);
    }

    public function update($id)
    {
        $this->guruModel->update($id, [
            'id_user' => $this->request->getPost('id_user'),
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'status' => $this->request->getPost('status'),
            'foto' => $this->uploadFoto()
        ]);

        return redirect()->to('/guru')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->guruModel->delete($id);
        return redirect()->to('/guru')->with('success', 'Data guru berhasil dihapus.');
    }

    public function detail($id)
    {
        $data['guru'] = $this->guruModel
            ->select('tb_guru.*, tb_user.username')
            ->join('tb_user', 'tb_user.id_user = tb_guru.id_user', 'left')
            ->find($id);

        $data['jabatan'] = $this->jabatanModel
            ->where('id_user', $data['guru']['id_user'])
            ->findAll();

        $data['title'] = 'Detail Guru';
        return view('guru/detail', $data);
    }

    private function uploadFoto()
    {
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/guru', $newName);
            return $newName;
        }
        return null;
    }
}
