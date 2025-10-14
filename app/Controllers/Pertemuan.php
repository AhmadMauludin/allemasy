<?php

namespace App\Controllers;

use App\Models\PertemuanModel;
use App\Models\JadwalModel;
use App\Models\PresensiModel;
use App\Models\PesdikModel;
use App\Models\MateriModel;
use App\Models\TugasModel;
use App\Models\KelasPesdikModel;
use App\Models\KontrakJadwalModel;
use CodeIgniter\Controller;

class Pertemuan extends Controller
{
    protected $pertemuanModel;
    protected $jadwalModel;
    protected $presensiModel;
    protected $pesdikModel;
    protected $materiModel;
    protected $tugasModel;
    protected $kelasPesdikModel;

    public function __construct()
    {
        $this->pertemuanModel = new PertemuanModel();
        $this->jadwalModel = new JadwalModel();
        $this->presensiModel = new PresensiModel();
        $this->pesdikModel = new PesdikModel();
        $this->materiModel = new MateriModel();
        $this->tugasModel = new TugasModel();
        $this->kelasPesdikModel = new KelasPesdikModel();

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

    public function create($id_jadwal = null)
    {
        // Ambil semua data jadwal untuk dropdown atau referensi
        $jadwal = $this->jadwalModel
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
            ->where('tb_jadwal.id_jadwal', $id_jadwal)
            ->first();

        // Siapkan data untuk view
        $data = [
            'title' => 'Tambah Pertemuan',
            'id_jadwal' => $id_jadwal,
            'jadwal' => $jadwal,
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

        // Simpan data pertemuan
        $this->pertemuanModel->save([
            'id_jadwal' => $this->request->getPost('id_jadwal'),
            'tanggal' => $this->request->getPost('tanggal'),
            'status' => $this->request->getPost('status'),
            'materi' => $this->request->getPost('materi'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $fotoName,
        ]);

        // Ambil ID pertemuan yang baru disimpan
        $idPertemuan = $this->pertemuanModel->getInsertID();

        // === Proses otomatis membuat data presensi ===
        $jadwalModel = new KontrakJadwalModel(); // kita butuh kontrak untuk mencari id_kelas nanti
        $kontrakModel = new KontrakJadwalModel(); // kompatibilitas naming (tetap menggunakan KontrakJadwalModel)
        $pesdikModel = $this->pesdikModel;
        $presensiModel = $this->presensiModel;

        // Ambil id_jadwal dari input
        $idJadwal = $this->request->getPost('id_jadwal');

        // Ambil data jadwal untuk dapat id_kontrak_jadwal
        $jadwal = $this->jadwalModel->find($idJadwal);
        if (!$jadwal) {
            return redirect()->back()->with('error', 'Data jadwal tidak ditemukan.');
        }

        // Ambil data kontrak_jadwal untuk dapat id_kelas
        $kontrak = $kontrakModel->find($jadwal['id_kontrak_jadwal']);
        if (!$kontrak) {
            return redirect()->back()->with('error', 'Data kontrak jadwal tidak ditemukan.');
        }

        // Ambil seluruh pesdik berdasarkan enroll di tb_kelas_pesdik
        $pesdikList = $this->kelasPesdikModel
            ->select('tb_pesdik.id_pesdik, tb_pesdik.nama, tb_pesdik.nisn, tb_pesdik.nis')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_kelas_pesdik.id_pesdik', 'left')
            ->where('tb_kelas_pesdik.id_kelas', $kontrak['id_kelas'])
            ->findAll();

        // Simpan ke tb_presensi untuk tiap pesdik (status = pending)
        foreach ($pesdikList as $pd) {
            $presensiModel->insert([
                'id_pertemuan' => $idPertemuan,
                'id_pesdik' => $pd['id_pesdik'],
                'status' => 'pending',
            ]);
        }

        return redirect()->to('/pertemuan')->with('success', 'Pertemuan dan presensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Pertemuan',
            'id_jadwal' => $this->pertemuanModel->find($id)['id_jadwal'],
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

    // Halaman detail pertemuan + presensi + materi + tugas
    public function detail($id)
    {
        // Ambil data pertemuan
        $p = $this->pertemuanModel->find($id);
        if (!$p) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pertemuan tidak ditemukan");
        }

        // Ambil data jadwal yang terkait
        $j = $this->jadwalModel->getDetailById($p['id_jadwal']);

        // Ambil data presensi untuk pertemuan ini
        $presensi = $this->presensiModel
            ->select('tb_presensi.*, tb_pesdik.nama as nama_pesdik')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_presensi.id_pesdik')
            ->where('tb_presensi.id_pertemuan', $id)
            ->findAll();

        // Ambil semua materi dari pertemuan ini
        $materiModel = new \App\Models\MateriModel();
        $materi = $materiModel
            ->where('id_pertemuan', $id)
            ->findAll();

        // Ambil semua tugas dari pertemuan ini
        $tugasModel = new \App\Models\TugasModel();
        $tugas = $tugasModel
            ->where('id_pertemuan', $id)
            ->findAll();

        // Kirim semua data ke view
        return view('pertemuan/detail', [
            'p' => $p,
            'j' => $j,
            'presensi' => $presensi,
            'materi' => $materi,
            'tugas' => $tugas
        ]);
    }

    // Update status kehadiran manual (Sakit/Izin/Alfa)
    public function updateStatus($id)
    {
        $status = $this->request->getPost('status');
        $this->presensiModel->update($id, ['status' => $status]);
        return redirect()->back()->with('success', 'Status kehadiran diperbarui.');
    }

    // Halaman scan barcode
    public function scan($idPertemuan)
    {
        return view('pertemuan/scan', ['idPertemuan' => $idPertemuan]);
    }

    // Proses hasil scan barcode (dikirim via AJAX)
    public function scanProcess()
    {
        $idPesdik = $this->request->getPost('id_pesdik');
        $idPertemuan = $this->request->getPost('id_pertemuan');

        $presensi = $this->presensiModel
            ->where('id_pertemuan', $idPertemuan)
            ->where('id_pesdik', $idPesdik)
            ->first();

        if ($presensi) {
            $this->presensiModel->update($presensi['id_presensi'], [
                'status' => 'hadir'
            ]);
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Data presensi tidak ditemukan']);
    }
}
