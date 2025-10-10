<?php

namespace App\Controllers;

use App\Models\JabatanModel;
use App\Models\UserModel;

class Jabatan extends BaseController
{
    protected $jabatanModel;
    protected $userModel;

    public function __construct()
    {
        $this->jabatanModel = new JabatanModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['jabatan'] = $this->jabatanModel
            ->select('tb_jabatan.*, tb_user.nama')
            ->join('tb_user', 'tb_user.id_user = tb_jabatan.id_user', 'left')
            ->findAll();

        $data['title'] = 'Data Jabatan';
        return view('jabatan/index', $data);
    }

    public function create()
    {
        $data['users'] = $this->userModel->findAll();
        $data['title'] = 'Tambah Jabatan';
        return view('jabatan/create', $data);
    }

    public function store()
    {
        $jabatanModel = new \App\Models\JabatanModel();

        $data = [
            'id_user' => $this->request->getPost('id_user'),
            'jabatan' => $this->request->getPost('jabatan'),
            'status'  => $this->request->getPost('status'),
        ];

        $jabatanModel->insert($data);

        return redirect()->back()->with('success', 'Jabatan berhasil ditambahkan.');
    }


    public function edit($id)
    {
        $data['jabatan'] = $this->jabatanModel->find($id);
        $data['users'] = $this->userModel->findAll();
        $data['title'] = 'Edit Jabatan';
        return view('jabatan/edit', $data);
    }

    public function update($id)
    {
        $this->jabatanModel->update($id, [
            'id_user' => $this->request->getPost('id_user'),
            'jabatan' => $this->request->getPost('jabatan'),
            'status' => $this->request->getPost('status'),
        ]);
        return redirect()->to('/jabatan')->with('success', 'Jabatan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->jabatanModel->delete($id);
        return redirect()->back()->with('success', 'Jabatan berhasil dihapus.');
    }
}
