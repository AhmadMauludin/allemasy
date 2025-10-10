<?php

namespace App\Controllers;

use App\Models\PertemuanModel;
use App\Models\JadwalModel;
use CodeIgniter\Controller;

class Pertemuan extends Controller
{
    protected $pertemuanModel;
    protected $jadwalModel;

    public function __construct()
    {
        $this->pertemuanModel = new PertemuanModel();
        $this->jadwalModel = new JadwalModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pertemuan',
            'pertemuan' => $this->pertemuanModel
                ->select('tb_pertemuan.*, tb_jadwal.hari, tb_jadwal.jampel, tb_jadwal.waktu_mulai, tb_jadwal.waktu_selesai, tb_kelas.nama_kelas, tb_mapel.nama_mapel, tb_user.username AS nama_guru')
                ->join('tb_jadwal', 'tb_jadwal.id_jadwal = tb_pertemuan.id_jadwal', 'left')
                ->join('tb_kontrak_jadwal', 'tb_kontrak_jadwal.id_kontrak_jadwal = tb_jadwal.id_kontrak_jadwal', 'left')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
                ->orderBy('tanggal', 'DESC')
                ->findAll()
        ];

        return view('pertemuan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pertemuan',
            'jadwal' => $this->jadwalModel
                ->select('tb_jadwal.*, 
                          tb_kontrak_jadwal.id_tahun_ajaran,
                          tb_kontrak_jadwal.jumlah_jam,
                          tb_mapel.nama_mapel,
                          tb_kelas.nama_kelas,
                          tb_user.username AS nama_guru,
                          tb_ruangan.nama_ruangan')
                ->join('tb_kontrak_jadwal', 'tb_kontrak_jadwal.id_kontrak_jadwal = tb_jadwal.id_kontrak_jadwal', 'left')
                ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
                ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_jadwal.id_ruangan', 'left')
                ->orderBy('FIELD(hari, "Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu")', '', false)
                ->orderBy('waktu_mulai', 'ASC')
                ->findAll()
        ];

        return view('pertemuan/create', $data);
    }

    public function store()
    {
        $file = $this->request->getFile('foto');
        $fotoName = $file && $file->isValid() ? $file->getRandomName() : null;

        if ($fotoName) {
            $file->move('uploads/pertemuan', $fotoName);
        }

        $this->pertemuanModel->save([
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status' => $this->request->getPost('status'),
            'materi' => $this->request->getPost('materi'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/pertemuan')->with('success', 'Pertemuan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pertemuan',
            'pertemuan' => $this->pertemuanModel->find($id),
            'jadwal' => $this->jadwalModel
                ->select('tb_jadwal.*, 
                          tb_kontrak_jadwal.id_tahun_ajaran,
                          tb_kontrak_jadwal.jumlah_jam,
                          tb_mapel.nama_mapel,
                          tb_kelas.nama_kelas,
                          tb_user.username AS nama_guru,
                          tb_ruangan.nama_ruangan')
                ->join('tb_kontrak_jadwal', 'tb_kontrak_jadwal.id_kontrak_jadwal = tb_jadwal.id_kontrak_jadwal', 'left')
                ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
                ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_jadwal.id_ruangan', 'left')
                ->orderBy('FIELD(hari, "Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu")', '', false)
                ->orderBy('waktu_mulai', 'ASC')
                ->findAll()
        ];

        return view('pertemuan/edit', $data);
    }

    public function update($id)
    {
        $file = $this->request->getFile('foto');
        $fotoName = $file && $file->isValid() ? $file->getRandomName() : $this->request->getPost('foto_lama');

        if ($file && $file->isValid()) {
            $file->move('uploads/pertemuan', $fotoName);
        }

        $this->pertemuanModel->update($id, [
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status' => $this->request->getPost('status'),
            'materi' => $this->request->getPost('materi'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/pertemuan')->with('success', 'Data pertemuan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->pertemuanModel->delete($id);
        return redirect()->to('/pertemuan')->with('success', 'Pertemuan berhasil dihapus.');
    }

    public function detail($id)
    {
        $data = [
            'title' => 'Edit Pertemuan',
            'p' => $this->pertemuanModel->find($id),
            'j' => $this->jadwalModel
                ->select('tb_jadwal.*, 
                          tb_kontrak_jadwal.id_tahun_ajaran,
                          tb_kontrak_jadwal.jumlah_jam,
                          tb_mapel.nama_mapel,
                          tb_kelas.nama_kelas,
                          tb_user.username AS nama_guru,
                          tb_ruangan.nama_ruangan')
                ->join('tb_kontrak_jadwal', 'tb_kontrak_jadwal.id_kontrak_jadwal = tb_jadwal.id_kontrak_jadwal', 'left')
                ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
                ->join('tb_ruangan', 'tb_ruangan.id_ruangan = tb_jadwal.id_ruangan', 'left')
                ->orderBy('FIELD(hari, "Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu")', '', false)
                ->orderBy('waktu_mulai', 'ASC')
                ->where('tb_jadwal.id_jadwal', $this->pertemuanModel->find($id)['id_jadwal'])
                ->first()
        ];

        return view('pertemuan/detail', $data);
    }
}
