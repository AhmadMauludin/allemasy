<?php

namespace App\Controllers;

use App\Models\KompetensiPesdikModel;
use App\Models\UserModel;
use App\Models\KompetensiModel;
use CodeIgniter\Controller;

class KompetensiPesdik extends Controller
{
    protected $kompetensiPesdikModel;
    protected $userModel;
    protected $kompetensiModel;

    public function __construct()
    {
        $this->kompetensiPesdikModel = new KompetensiPesdikModel();
        $this->userModel = new UserModel();
        $this->kompetensiModel = new KompetensiModel();
    }

    public function index($id_kompetensi)
    {
        $data = [
            'title' => 'Data Kompetensi Peserta Didik',
            'id_kompetensi' => $id_kompetensi,
            'kompetensi' => $this->kompetensiModel->find($id_kompetensi),
            'kompetensi_pesdik' => $this->kompetensiPesdikModel->getByKompetensi($id_kompetensi)
        ];

        return view('kompetensi_pesdik/index', $data);
    }

    public function create($id_kompetensi)
    {
        $data = [
            'title' => 'Tambah Kompetensi Pesdik',
            'id_kompetensi' => $id_kompetensi,
            'pesdik' => $this->userModel->where('role', 'pesdik')->findAll(),
            'guru' => $this->userModel->where('role', 'guru')->findAll(),
        ];

        return view('kompetensi_pesdik/create', $data);
    }

    public function store()
    {
        $this->kompetensiPesdikModel->save([
            'id_kompetensi' => $this->request->getPost('id_kompetensi'),
            'id_pesdik' => $this->request->getPost('id_pesdik'),
            'id_guru' => $this->request->getPost('id_guru'),
            'nomor_sk' => $this->request->getPost('nomor_sk'),
            'status' => $this->request->getPost('status'),
            'predikat' => $this->request->getPost('predikat'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai')
        ]);

        return redirect()->to('/kompetensi_pesdik/index/' . $this->request->getPost('id_kompetensi'))
            ->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kp = $this->kompetensiPesdikModel->find($id);

        $data = [
            'title' => 'Edit Kompetensi Pesdik',
            'kp' => $kp,
            'pesdik' => $this->userModel->where('role', 'pesdik')->findAll(),
            'guru' => $this->userModel->where('role', 'guru')->findAll(),
        ];

        return view('kompetensi_pesdik/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'id_pesdik' => $this->request->getPost('id_pesdik'),
            'id_guru' => $this->request->getPost('id_guru'),
            'nomor_sk' => $this->request->getPost('nomor_sk'),
            'status' => $this->request->getPost('status'),
            'predikat' => $this->request->getPost('predikat'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai')
        ];

        $this->kompetensiPesdikModel->update($id, $data);
        $kp = $this->kompetensiPesdikModel->find($id);

        return redirect()->to('/kompetensi_pesdik/index/' . $kp['id_kompetensi'])
            ->with('success', 'Data berhasil diperbarui.');
    }
    public function delete($id)
    {
        // Pastikan model sudah tersedia
        $kompetensiPesdik = $this->kompetensiPesdikModel->find($id);

        if (!$kompetensiPesdik) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }

        // Hapus data
        $this->kompetensiPesdikModel->delete($id);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data kompetensi peserta didik berhasil dihapus.');
    }
}
