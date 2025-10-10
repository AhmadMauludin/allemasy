<?php

namespace App\Controllers;

use App\Models\PesdikModel;
use App\Models\KelasModel;
use App\Models\UserModel;
use App\Models\JabatanModel;

class Pesdik extends BaseController
{
    protected $pesdikModel;
    protected $kelasModel;
    protected $userModel;
    protected $jabatanModel;

    public function __construct()
    {
        $this->pesdikModel = new PesdikModel();
        $this->kelasModel = new KelasModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword'); // Ambil keyword dari form pencarian
        $perPage = 10; // Jumlah data per halaman

        $builder = $this->pesdikModel
            ->select('tb_pesdik.*, tb_kelas.nama_kelas')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_pesdik.id_kelas', 'left');

        // Jika ada pencarian
        if ($keyword) {
            $builder->groupStart()
                ->like('tb_pesdik.nama', $keyword)
                ->orLike('tb_pesdik.nis', $keyword)
                ->orLike('tb_pesdik.telp', $keyword)
                ->orLike('tb_kelas.nama_kelas', $keyword)
                ->groupEnd();
        }

        $data = [
            'pesdik' => $builder->paginate($perPage),
            'pager'  => $this->pesdikModel->pager,
            'keyword' => $keyword,
        ];

        return view('pesdik/index', $data);
    }


    public function create()
    {
        $data['kelas'] = $this->kelasModel->findAll();
        return view('pesdik/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/pesdik', $fotoName);
        }

        $this->pesdikModel->save([
            'id_user' => $this->request->getPost('id_user'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'nisn' => $this->request->getPost('nisn'),
            'nis' => $this->request->getPost('nis'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => $this->request->getPost('status'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/pesdik')->with('success', 'Data Pesdik berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['pesdik'] = $this->pesdikModel->find($id);
        $data['kelas'] = $this->kelasModel->findAll();
        return view('pesdik/edit', $data);
    }

    public function update($id)
    {
        $foto = $this->request->getFile('foto');
        $fotoName = $this->request->getPost('foto_lama');

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/pesdik', $fotoName);
        }

        $this->pesdikModel->update($id, [
            'id_kelas' => $this->request->getPost('id_kelas'),
            'nama' => $this->request->getPost('nama'),
            'jk' => $this->request->getPost('jk'),
            'nisn' => $this->request->getPost('nisn'),
            'nis' => $this->request->getPost('nis'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => $this->request->getPost('status'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/pesdik')->with('success', 'Data Pesdik berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->pesdikModel->delete($id);
        return redirect()->to('/pesdik')->with('success', 'Data Pesdik berhasil dihapus!');
    }

    public function detail($id)
    {
        $pesdikModel = new \App\Models\PesdikModel();
        $userModel   = new \App\Models\UserModel();
        $kelasModel  = new \App\Models\KelasModel();
        $jabatanModel = new \App\Models\JabatanModel();

        // Ambil data pesdik
        $pesdik = $pesdikModel
            ->select('tb_pesdik.*, tb_kelas.nama_kelas, tb_user.username')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_pesdik.id_kelas', 'left')
            ->join('tb_user', 'tb_user.id_user = tb_pesdik.id_user', 'left')
            ->find($id);

        if (!$pesdik) {
            return redirect()->to('/pesdik')->with('error', 'Data peserta didik tidak ditemukan.');
        }

        // Ambil jabatan dari tb_jabatan berdasarkan id_user
        $jabatan = $jabatanModel
            ->where('id_user', $pesdik['id_user'])
            ->where('status', 'aktif')
            ->findAll();

        return view('pesdik/detail', [
            'title' => 'Detail Peserta Didik',
            'pesdik' => $pesdik,
            'jabatan' => $jabatan
        ]);
    }
}
