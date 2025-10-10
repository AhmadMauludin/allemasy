<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\PesdikModel;
use App\Models\KelasModel;
use App\Models\RuanganModel;

class Home extends BaseController
{
    protected $userModel;
    protected $guruModel;
    protected $pesdikModel;
    protected $kelasModel;
    protected $ruanganModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->guruModel   = new GuruModel();
        $this->pesdikModel = new PesdikModel();
        $this->kelasModel  = new KelasModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $idUser = session()->get('id_user');

        $data = [];

        if ($role === 'admin') {
            $data = [
                'title' => 'Dashboard Admin',
                'role'  => 'admin',
                'userCount'    => $this->userModel->countAllResults(),
                'guruCount'    => $this->guruModel->countAllResults(),
                'pesdikCount'  => $this->pesdikModel->countAllResults(),
                'kelasCount'   => $this->kelasModel->countAllResults(),
                'ruanganCount' => $this->ruanganModel->countAllResults(),
            ];
        } elseif ($role === 'guru') {
            // Cek kelas yang diampu oleh guru ini
            $kelas = $this->kelasModel
                ->select('tb_kelas.*, COUNT(tb_pesdik.id_pesdik) as jumlah_pesdik')
                ->join('tb_pesdik', 'tb_pesdik.id_kelas = tb_kelas.id_kelas', 'left')
                ->where('tb_kelas.id_user', $idUser)
                ->groupBy('tb_kelas.id_kelas')
                ->first();

            $data = [
                'title' => 'Dashboard Guru',
                'role'  => 'guru',
                'kelas' => $kelas
            ];
        } elseif ($role === 'pesdik') {
            // Ambil kelas di mana pesdik ini terdaftar
            $pesdik = $this->pesdikModel
                ->select('tb_pesdik.*, tb_kelas.nama_kelas')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_pesdik.id_kelas', 'left')
                ->where('tb_pesdik.id_user', $idUser)
                ->first();

            $data = [
                'title' => 'Dashboard Pesdik',
                'role'  => 'pesdik',
                'pesdik' => $pesdik
            ];
        }

        return view('layouts/dashboard', $data);
    }
}
