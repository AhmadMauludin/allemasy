<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GuruModel;
use App\Models\PesdikModel;
use App\Models\KelasModel;
use App\Models\RuanganModel;
use App\Models\KelasPesdikModel;
use App\Models\JadwalModel;
use App\Models\KompetensiModel;

class Home extends BaseController
{
    protected $userModel;
    protected $guruModel;
    protected $pesdikModel;
    protected $kelasModel;
    protected $ruanganModel;
    protected $kelasPesdikModel;
    protected $jadwalModel;
    protected $kompetensiModel;

    public function __construct()
    {
        $this->userModel       = new UserModel();
        $this->guruModel       = new GuruModel();
        $this->pesdikModel     = new PesdikModel();
        $this->kelasModel      = new KelasModel();
        $this->ruanganModel    = new RuanganModel();
        $this->kelasPesdikModel = new KelasPesdikModel();
        $this->jadwalModel     = new JadwalModel();
        $this->kompetensiModel = new KompetensiModel();
    }

    public function index()
    {
        $role   = session()->get('role');
        $idUser = session()->get('id_user');

        $data = [
            'title' => 'Dashboard',
            'role'  => $role,
        ];

        // =====================================================
        // DASHBOARD ADMIN
        // =====================================================
        if ($role === 'admin') {
            $data += [
                'userCount'       => $this->userModel->countAllResults(),
                'guruCount'       => $this->guruModel->countAllResults(),
                'pesdikCount'     => $this->pesdikModel->countAllResults(),
                'kelasCount'      => $this->kelasModel->countAllResults(),
                'ruanganCount'    => $this->ruanganModel->countAllResults(),
                'kompetensiCount' => $this->kompetensiModel->countAllResults(),
                'jadwalCount'     => $this->jadwalModel->countAllResults(),
                'recentPesdik'    => $this->pesdikModel->orderBy('nama', 'DESC')->limit(5)->findAll(),
            ];
        }

        // =====================================================
        // DASHBOARD GURU
        // =====================================================
        elseif ($role === 'guru') {
            // Ambil semua kelas yang diwalikan oleh guru
            $kelas = $this->kelasModel
                ->select('tb_kelas.*, COUNT(tb_kelas_pesdik.id_pesdik) AS jumlah_pesdik')
                ->join('tb_kelas_pesdik', 'tb_kelas_pesdik.id_kelas = tb_kelas.id_kelas', 'left')
                ->where('tb_kelas.id_user', $idUser) // ganti dengan id_wali_kelas jika nama kolomnya beda
                ->groupBy('tb_kelas.id_kelas')
                ->findAll();

            $pesanWali = empty($kelas) ? "Anda belum menjadi wali kelas." : null;

            // Ambil semua jadwal yang diampu oleh guru
            $jadwal = $this->jadwalModel
                ->select('tb_jadwal.*, tb_mapel.nama_mapel, tb_kelas.nama_kelas, tb_ruangan.nama_ruangan')
                ->join('tb_kontrak_jadwal', 'tb_kontrak_jadwal.id_kontrak_jadwal = tb_jadwal.id_kontrak_jadwal', 'left')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_jadwal.id_ruangan', 'left')
                ->where('tb_kontrak_jadwal.id_user', $idUser)
                ->orderBy('FIELD(tb_jadwal.hari, "Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu")', '', false)
                ->orderBy('tb_jadwal.waktu_mulai', 'ASC')
                ->findAll();

            $data += [
                'kelasAmpu' => $kelas,
                'pesanWali' => $pesanWali,
                'jadwalGuru' => $jadwal,
                'kompetensiGuru' => $this->kompetensiModel->where('id_mapel IS NOT NULL')->findAll()
            ];
        }



        // =====================================================
        // DASHBOARD PESDIK
        // =====================================================
        elseif ($role === 'pesdik') {
            // Ambil data peserta didik berdasarkan user (join ke tb_user agar ada nama jika diperlukan)
            $pesdik = $this->pesdikModel
                ->select('tb_pesdik.*, tb_user.username AS username, tb_user.foto AS user_foto')
                ->join('tb_user', 'tb_user.id_user = tb_pesdik.id_user', 'left')
                ->where('tb_pesdik.id_user', $idUser)
                ->first();

            // Jika pesdik tidak ditemukan, kembalikan data minimal
            if (!$pesdik) {
                $data += [
                    'pesdik' => null,
                    'kelasIkut' => [],
                    'kompetensiAktif' => []
                ];
            } else {
                // Ambil semua kelas yang diikuti pesdik dari pivot tb_kelas_pesdik
                $kelasIkut = $this->kelasPesdikModel
                    ->select('tb_kelas.id_kelas, tb_kelas.nama_kelas, tb_kelas.jenis_kelas, tb_kelas_pesdik.id_kelas_pesdik')
                    ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kelas_pesdik.id_kelas', 'left')
                    ->where('tb_kelas_pesdik.id_pesdik', $pesdik['id_pesdik'])
                    ->findAll();

                // Sediakan field nama_kelas agar view lama tetap aman (pakai kelas pertama jika ada)
                $firstClassName = !empty($kelasIkut) ? $kelasIkut[0]['nama_kelas'] : null;
                $pesdik['nama_kelas'] = $firstClassName;

                // Ambil kompetensi aktif (opsional)
                $kompetensi = $this->kompetensiModel
                    ->select('tb_kompetensi.*, tb_mapel.nama_mapel')
                    ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kompetensi.id_mapel', 'left')
                    ->where('tb_kompetensi.status', 'aktif')
                    ->findAll();

                $data += [
                    'pesdik' => $pesdik,
                    'kelasIkut' => $kelasIkut,
                    'kompetensiAktif' => $kompetensi,
                ];
            }
        }


        return view('layouts/dashboard', $data);
    }
}
