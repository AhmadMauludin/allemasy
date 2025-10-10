<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\UserModel;
use App\Models\RuanganModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $userModel;
    protected $ruanganModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->userModel = new UserModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data['kelas'] = $this->kelasModel
            ->select('tb_kelas.*, tb_user.username as wali_kelas, tb_ruangan.nama_ruangan')
            ->join('tb_user', 'tb_user.id_user = tb_kelas.id_user', 'left')
            ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_kelas.id_ruangan', 'left')
            ->findAll();

        return view('kelas/index', $data);
    }

    public function create()
    {
        $data['guru'] = $this->userModel->where('role', 'guru')->findAll();
        $data['ruangan'] = $this->ruanganModel->findAll();
        return view('kelas/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/kelas', $fotoName);
        }

        $this->kelasModel->save([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'id_user' => $this->request->getPost('id_user'),
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'ket' => $this->request->getPost('ket'),
            'status' => $this->request->getPost('status'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/kelas')->with('success', 'Data kelas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['kelas'] = $this->kelasModel->find($id);
        $data['guru'] = $this->userModel->where('role', 'guru')->findAll();
        $data['ruangan'] = $this->ruanganModel->findAll();
        return view('kelas/edit', $data);
    }

    public function update($id)
    {
        $foto = $this->request->getFile('foto');
        $fotoName = $this->request->getPost('foto_lama');

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/kelas', $fotoName);
        }

        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'tingkat' => $this->request->getPost('tingkat'),
            'id_user' => $this->request->getPost('id_user'),
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'ket' => $this->request->getPost('ket'),
            'status' => $this->request->getPost('status'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/kelas')->with('success', 'Data kelas berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to('/kelas')->with('success', 'Data kelas berhasil dihapus!');
    }

    public function detail($id_kelas)
    {
        $kelasModel = new \App\Models\KelasModel();
        $pesdikModel = new \App\Models\PesdikModel();

        $kelas = $kelasModel
            ->select('tb_kelas.*, tb_ruangan.nama_ruangan, tb_guru.nama AS nama_guru')
            ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_kelas.id_ruangan', 'left')
            ->join('tb_user', 'tb_user.id_user = tb_kelas.id_user', 'left')
            ->join('tb_guru', 'tb_guru.id_user = tb_user.id_user', 'left')
            ->where('tb_kelas.id_kelas', $id_kelas)
            ->first();

        $pesdik = $pesdikModel
            ->where('id_kelas', $id_kelas)
            ->findAll();

        $data = [
            'title' => 'Detail Kelas',
            'kelas' => $kelas,
            'pesdik' => $pesdik
        ];

        return view('kelas/detail', $data);
    }
}
