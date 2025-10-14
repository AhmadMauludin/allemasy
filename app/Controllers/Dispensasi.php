<?php

namespace App\Controllers;

use App\Models\DispensasiModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Dispensasi extends Controller
{
    protected $dispensasiModel;
    protected $userModel;

    public function __construct()
    {
        $this->dispensasiModel = new DispensasiModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Dispensasi',
            'dispensasi' => $this->dispensasiModel->getAll()
        ];
        return view('dispensasi/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Dispensasi',
            'pesdik' => $this->userModel->where('role', 'pesdik')->findAll()
        ];
        return view('dispensasi/create', $data);
    }

    public function store()
    {
        $this->dispensasiModel->save([
            'id_user_pesdik' => $this->request->getPost('id_user_pesdik'),
            'tanggal' => $this->request->getPost('tanggal'),
            'alasan' => $this->request->getPost('alasan'),
            'id_user_guru' => session()->get('id_user'), // otomatis isi guru yang login
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket')
        ]);

        return redirect()->to(base_url('dispensasi'))->with('success', 'Data dispensasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Dispensasi',
            'dispensasi' => $this->dispensasiModel->getById($id),
            'pesdik' => $this->userModel->where('role', 'pesdik')->findAll()
        ];
        return view('dispensasi/edit', $data);
    }

    public function update($id)
    {
        $this->dispensasiModel->update($id, [
            'id_user_pesdik' => $this->request->getPost('id_user_pesdik'),
            'tanggal' => $this->request->getPost('tanggal'),
            'alasan' => $this->request->getPost('alasan'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket')
        ]);

        return redirect()->to(base_url('dispensasi'))->with('success', 'Data dispensasi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->dispensasiModel->delete($id);
        return redirect()->back()->with('success', 'Data dispensasi berhasil dihapus.');
    }
}
