<?php

namespace App\Controllers;

use App\Models\SholatModel;
use App\Models\PresensiSholatModel;
use App\Models\PesdikModel;
use CodeIgniter\Controller;

class Sholat extends Controller
{
    protected $sholatModel;
    protected $presensiSholatModel;
    protected $pesdikModel;

    public function __construct()
    {
        $this->sholatModel = new SholatModel();
        $this->presensiSholatModel = new PresensiSholatModel();
        $this->pesdikModel = new PesdikModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $tanggal = $this->request->getGet('tanggal');
        $role = session()->get('role');
        $idPesdik = session()->get('id_pesdik'); // pastikan sudah tersimpan di session

        $builder = $this->sholatModel;

        // 🔍 Filter berdasarkan tanggal jika ada input
        if ($tanggal) {
            $builder = $builder->where('tanggal', $tanggal);
        }

        // 📄 Gunakan pagination (10 data per halaman)
        $sholat = $builder->orderBy('tanggal', 'DESC')->paginate(10);
        $pager = $this->sholatModel->pager;

        // 👤 Jika login sebagai pesdik, ambil status presensi-nya
        if ($role === 'pesdik' && $idPesdik) {
            foreach ($sholat as &$row) {
                $presensi = $this->presensiSholatModel
                    ->where('id_sholat', $row['id_sholat'])
                    ->where('id_pesdik', $idPesdik)
                    ->first();

                $row['status_presensi'] = $presensi['status_presensi'] ?? 'pending';
            }
        }

        // 📦 Kirim data ke view
        $data = [
            'sholat'  => $sholat,
            'tanggal' => $tanggal,
            'pager'   => $pager, // kirim pager ke view
        ];

        return view('sholat/index', $data);
    }

    public function create()
    {
        return view('sholat/create', ['title' => 'Tambah Sholat']);
    }

    public function store()
    {
        $this->sholatModel->save([
            'hari' => $this->request->getPost('hari'),
            'tanggal' => $this->request->getPost('tanggal'),
            'sholat' => $this->request->getPost('sholat'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'ket_sholat' => $this->request->getPost('ket_sholat')
        ]);

        $idSholat = $this->sholatModel->getInsertID();

        // Tambahkan presensi untuk semua pesdik
        $pesdikList = $this->pesdikModel->findAll();
        foreach ($pesdikList as $p) {
            $this->presensiSholatModel->insert([
                'id_sholat' => $idSholat,
                'id_pesdik' => $p['id_pesdik'],
                'status_presensi' => 'pending'
            ]);
        }

        return redirect()->to('/sholat')->with('success', 'Data sholat dan presensi berhasil dibuat.');
    }

    public function detail($id)
    {
        $sholat = $this->sholatModel->find($id);
        $presensi = $this->presensiSholatModel
            ->select('tb_presensi_sholat.*, tb_pesdik.nama')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_presensi_sholat.id_pesdik', 'left')
            ->where('tb_presensi_sholat.id_sholat', $id)
            ->findAll();

        // Ambil seluruh presensi sholat
        $presensiList = $this->presensiSholatModel
            ->where('id_sholat', $id)
            ->findAll();

        // Hitung rekap presensi
        $rekap = [
            'hadir' => 0,
            'telat' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alfa' => 0
        ];

        foreach ($presensiList as $p) {
            $status = strtolower($p['status_presensi']);
            if (isset($rekap[$status])) {
                $rekap[$status]++;
            }
        }
        $rekap['total'] = count($presensiList);


        $data = [
            'title' => 'Detail Sholat',
            'sholat' => $sholat,
            'presensi' => $presensi,
            'presensiList' => $presensiList,
            'rekap' => $rekap
        ];

        return view('sholat/detail', $data);
    }

    public function updateStatus($id)
    {
        $status = $this->request->getPost('status_sholat');
        $this->sholatModel->update($id, ['status_sholat' => $status]);

        if ($status == 'selesai') {
            // Semua yang masih pending jadi alfa
            $this->presensiSholatModel->where('id_sholat', $id)
                ->where('status_presensi', 'pending')
                ->set(['status_presensi' => 'alfa'])
                ->update();
        }

        return redirect()->back()->with('success', 'Status sholat berhasil diperbarui.');
    }

    // ----------------------------
    // SCAN PRESENSI SHOLAT
    // ----------------------------
    public function scan($idSholat)
    {
        $sholat = $this->sholatModel->find($idSholat);
        return view('sholat/scan', ['idSholat' => $idSholat, 'sholat' => $sholat]);
    }

    public function prosesScan()
    {
        // Ambil input dari request
        $idSholat = $this->request->getPost('id_sholat');
        $kode = trim($this->request->getPost('kode')); // QR berisi id_pesdik
        $waktuSekarang = date('H:i:s');

        // Pastikan id_sholat valid
        if (empty($idSholat)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID Sholat tidak ditemukan dalam request.'
            ]);
        }

        // Pastikan QR berisi angka
        if (!ctype_digit($kode)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Format QR tidak valid. Harus berupa angka (id_pesdik).'
            ]);
        }

        // Cari santri berdasarkan id_pesdik
        $pesdik = $this->pesdikModel->where('id_pesdik', (int)$kode)->first();
        if (!$pesdik) {
            return $this->response->setJSON([
                'success' => false,
                'message' => "QR tidak dikenali. Tidak ada santri dengan id_pesdik = {$kode}."
            ]);
        }

        // Ambil data sholat
        $sholat = $this->sholatModel->find($idSholat);
        if (!$sholat) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data sholat tidak ditemukan.'
            ]);
        }

        // Cek apakah presensi sudah dibuat
        $presensi = $this->presensiSholatModel
            ->where('id_sholat', $idSholat)
            ->where('id_pesdik', $pesdik['id_pesdik'])
            ->first();

        if (!$presensi) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data presensi untuk santri ini belum dibuat.'
            ]);
        }

        // Tentukan status hadir atau telat
        $statusPresensi = ($waktuSekarang >= $sholat['waktu_mulai'] && $waktuSekarang <= $sholat['waktu_selesai'])
            ? 'hadir'
            : 'telat';

        // Update presensi
        $this->presensiSholatModel->update($presensi['id_presensi_sholat'], [
            'status_presensi' => $statusPresensi,
            'waktu_presensi' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => "{$pesdik['nama']} berhasil diabsen sebagai {$statusPresensi}."
        ]);
    }

    public function delete($id)
    {
        // Pastikan data ada
        $sholat = $this->sholatModel->find($id);
        if (!$sholat) {
            return redirect()->back()->with('error', 'Data sholat tidak ditemukan.');
        }

        // Hapus semua presensi yang terkait
        $this->presensiSholatModel->where('id_sholat', $id)->delete();

        // Hapus data sholat utama
        $this->sholatModel->delete($id);

        return redirect()->back()->with('success', 'Data sholat dan presensinya berhasil dihapus.');
    }
}
