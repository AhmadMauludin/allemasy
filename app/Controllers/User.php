<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class user extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10;

        // Query dasar
        $builder = $this->userModel
            ->select('tb_user.*, tb_guru.nama as nama_guru, tb_pesdik.nama as nama_pesdik')
            ->join('tb_guru', 'tb_guru.id_user = tb_user.id_user', 'left')
            ->join('tb_pesdik', 'tb_pesdik.id_user = tb_user.id_user', 'left');

        // Pencarian
        if ($keyword) {
            $builder->groupStart()
                ->like('tb_user.username', $keyword)
                ->orLike('tb_user.role', $keyword)
                ->orLike('tb_guru.nama', $keyword)
                ->orLike('tb_pesdik.nama', $keyword)
                ->groupEnd();
        }

        // Paginate
        $user = $builder->paginate($perPage);

        $data = [
            'title'   => 'Data User',
            'user'    => $user,
            'pager'   => $this->userModel->pager,
            'keyword' => $keyword
        ];

        return view('user/index', $data);
    }

    // Menampilkan halaman views/user/create (halaman daftar user)
    public function create()
    {
        $data = [
            'title'  => 'Tambah user',
        ];
        return view('user/create', $data);
    }

    public function store()
    {
        $userModel   = new \App\Models\UserModel();
        $pesdikModel = new \App\Models\PesdikModel();
        $guruModel   = new \App\Models\GuruModel();

        // Hash password
        $password = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        // Data user baru (tanpa kolom 'nama')
        $dataUser = [
            'username' => $this->request->getPost('username'),
            'role'     => $this->request->getPost('role'),
            'status'   => 'aktif',
            'password' => $password,
            'foto'     => $this->uploadFoto()
        ];

        // Simpan user baru
        $userModel->insert($dataUser);
        $idUserBaru = $userModel->getInsertID();

        // Ambil role
        $role = $this->request->getPost('role');

        // Jika role pesdik → masukkan ke tabel pesdik
        if ($role === 'pesdik') {
            $pesdikModel->insert([
                'id_user' => $idUserBaru,
                'nama'    => $this->request->getPost('nama'),
                'status'  => 'aktif'
            ]);
        }
        // Jika role guru → masukkan ke tabel guru
        elseif ($role === 'guru') {
            $guruModel->insert([
                'id_user' => $idUserBaru,
                'nama'    => $this->request->getPost('nama'),
                'status'  => 'aktif'
            ]);
        }

        return redirect()->to('/user')->with('success', 'User berhasil ditambahkan.');
    }

    // Menampilkan halaman views/user/edit (pengaturan)
    public function edit($id)
    {
        $data = [
            'title'  => 'Tambah user',
        ];

        $model = new UserModel();
        $data['user'] = $model->find($id);
        return view('user/edit', $data);
    }

    // Mengupdate data user yang diubah pada halaman edit (pengaturan)
    public function update($id)
    {
        $model = new UserModel();
        $user = $model->find($id);
        $password = $this->request->getPost('password') ? password_hash($this->request->getPost('password'), PASSWORD_DEFAULT) : $user['password'];

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
            'password' => $password
        ];

        if ($foto = $this->uploadFoto()) {
            $data['foto'] = $foto;
        }

        $model->update($id, $data);
        return redirect()->to('user')->with('success', 'Data user berhasil diperbarui.');
    }

    // Menghapus data user (Hanya dapat dilakukan oleh admin)
    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/user')->with('success', 'Data user berhasil dihapus.');
    }

    // Upload foto untuk tambah atau edit user
    private function uploadFoto()
    {
        $file = $this->request->getFile('foto');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/user/', $newName);
            return $newName;
        }
        return null;
    }
}
