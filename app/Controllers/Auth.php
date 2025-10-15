<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    // Menampilkan halaman view/auth/login
    public function index()
    {
        return view('auth/login');
    }

    // Memproses data login yang diinput pada halaman login
    public function auth()
    {
        $session = session();
        $userModel = new UserModel();
        $pesdikModel = new \App\Models\PesdikModel(); // tambahkan ini
        $guruModel = new \App\Models\GuruModel(); // tambahkan ini

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $userModel->getUserByUsername($username);

        if ($users) {
            if (password_verify($password, $users['password'])) {

                // Default data session
                $dataSession = [
                    'id_user' => $users['id_user'],
                    'username' => $users['username'],
                    'role' => $users['role'],
                    'foto' => $users['foto'],
                    'logged_in' => true
                ];

                // 🔹 Jika yang login adalah PESDIK, ambil id_pesdik-nya
                if ($users['role'] === 'pesdik') {
                    $pesdik = $pesdikModel->where('id_user', $users['id_user'])->first();
                    if ($pesdik) {
                        $dataSession['id_pesdik'] = $pesdik['id_pesdik'];
                        $dataSession['nama_pesdik'] = $pesdik['nama']; // opsional
                    }
                }

                // 🔹 Jika yang login adalah PESDIK, ambil id_pesdik-nya
                if ($users['role'] === 'guru') {
                    $guru = $guruModel->where('id_user', $users['id_user'])->first();
                    if ($guru) {
                        $dataSession['id_guru'] = $guru['id_guru'];
                        $dataSession['nama_guru'] = $guru['nama']; // opsional
                    }
                }

                // Simpan ke session
                $session->set($dataSession);

                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('error', 'Password salah');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('error', 'Nama tidak ditemukan');
            return redirect()->to('/login');
        }
    }

    // Logout (keluar dari aplikasi)
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
