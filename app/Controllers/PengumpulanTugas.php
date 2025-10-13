<?php

namespace App\Controllers;

use App\Models\PengumpulanTugasModel;
use App\Models\PesdikModel;
use App\Models\TugasModel;

class PengumpulanTugas extends BaseController
{
    protected $pengumpulanModel;
    protected $pesdikModel;
    protected $tugasModel;

    public function __construct()
    {
        $this->pengumpulanModel = new PengumpulanTugasModel();
        $this->pesdikModel = new PesdikModel();
        $this->tugasModel = new TugasModel();
    }

    // INDEX: daftar pengumpulan tugas
    public function index($id_tugas)
    {
        $user = session()->get();
        $role = $user['role'];

        if ($role === 'guru' || $role === 'admin') {
            // Guru: melihat semua pengumpulan untuk tugas tersebut
            $pengumpulan = $this->pengumpulanModel
                ->select('tb_pengumpulan_tugas.*, tb_pesdik.nama AS nama_pesdik,')
                ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_pengumpulan_tugas.id_pesdik', 'left')
                ->where('id_tugas', $id_tugas)
                ->findAll();
        } else {
            // Pesdik: hanya melihat pengumpulan miliknya
            $pengumpulan = $this->pengumpulanModel
                ->select('tb_pengumpulan_tugas.*, tb_pesdik.nama AS nama_pesdik')
                ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_pengumpulan_tugas.id_pesdik', 'left')
                ->where('id_tugas', $id_tugas)
                ->where('tb_pengumpulan_tugas.id_pesdik', $user['id_pesdik'])
                ->findAll();
        }

        return view('pengumpulan_tugas/index', [
            'pengumpulan' => $pengumpulan,
            'role' => $role,
            'id_tugas' => $id_tugas // ✅ ini penting agar tidak undefined
        ]);
    }

    // CREATE: Form tambah pengumpulan
    public function create($id_tugas)
    {
        return view('pengumpulan_tugas/create', ['id_tugas' => $id_tugas]);
    }

    // STORE: Simpan pengumpulan baru
    public function store()
    {
        $file = $this->request->getFile('lampiran');
        $lampiran = null;
        if ($file && $file->isValid()) {
            $lampiran = $file->getRandomName();
            $file->move('uploads/pengumpulan', $lampiran);
        }

        $userId = session()->get('id_user');
        $pesdik = (new \App\Models\PesdikModel())->where('id_user', $userId)->first();

        $this->pengumpulanModel->insert([
            'id_tugas' => $this->request->getPost('id_tugas'),
            'id_pesdik' => $pesdik['id_pesdik'],
            'lampiran' => $lampiran,
            'status' => 'dikirim',
            'intruksi' => $this->request->getPost('intruksi')
        ]);

        return redirect()->to(base_url('pengumpulan_tugas/' . $this->request->getPost('id_tugas')))
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }

    // EDIT: Form edit (misal untuk guru memberi nilai atau mengubah status)
    public function edit($id)
    {
        $data['pengumpulan'] = $this->pengumpulanModel->find($id);
        return view('pengumpulan_tugas/edit', $data);
    }

    // UPDATE: Simpan perubahan
    public function update($id)
    {
        $pengumpulan = $this->pengumpulanModel->find($id);
        if (!$pengumpulan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data pengumpulan tidak ditemukan");
        }

        $role = session()->get('role');
        $dataUpdate = [];

        // 🔹 Jika role guru → hanya ubah status, nilai, dan intruksi
        if ($role === 'guru') {
            $dataUpdate = [
                'status'   => $this->request->getPost('status'),
                'nilai'    => $this->request->getPost('nilai'),
                'intruksi' => $this->request->getPost('intruksi'),
            ];
        }

        // 🔹 Jika role pesdik → hanya ubah lampiran
        elseif ($role === 'pesdik') {
            $lampiran = $this->request->getFile('lampiran');
            if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
                $newName = $lampiran->getRandomName();
                $lampiran->move('uploads/pengumpulan/', $newName);
                $dataUpdate['lampiran'] = $newName;

                // hapus file lama jika ada
                if (!empty($pengumpulan['lampiran']) && file_exists('uploads/pengumpulan/' . $pengumpulan['lampiran'])) {
                    unlink('uploads/pengumpulan/' . $pengumpulan['lampiran']);
                }
            }
        }

        // ✅ Update hanya field yang relevan
        if (!empty($dataUpdate)) {
            $this->pengumpulanModel->update($id, $dataUpdate);
        }

        return redirect()
            ->to(base_url('pengumpulan_tugas/' . $pengumpulan['id_tugas']))
            ->with('success', 'Data pengumpulan berhasil diperbarui.');
    }
}
