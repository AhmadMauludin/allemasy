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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $users = $userModel->getUserByUsername($username);

        if ($users) {
            if (password_verify($password, $users['password'])) {
                $session->set([
                    'id_user' => $users['id_user'],
                    'username' => $users['username'],
                    'role' => $users['role'],
                    'foto' => $users['foto'],
                    'logged_in' => true
                ]);

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
