<?php

namespace App\Controllers;

use App\Models\PesdikModel;
use App\Models\KelasModel;
use App\Models\KelasPesdikModel;
use App\Models\UserModel;
use App\Models\JabatanModel;

use App\Controllers\BaseController;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;

class Pesdik extends BaseController
{
    protected $pesdikModel;
    protected $kelasModel;
    protected $userModel;
    protected $jabatanModel;
    protected $kelasPesdikModel;

    public function __construct()
    {
        $this->pesdikModel = new PesdikModel();
        $this->kelasModel = new KelasModel();
        $this->userModel = new UserModel();
        $this->jabatanModel = new JabatanModel();
        $this->kelasPesdikModel = new KelasPesdikModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $perPage = 10;

        // Ambil data pesdik dan gabungkan kelas yang diikuti
        $builder = $this->pesdikModel
            ->select('tb_pesdik.*, GROUP_CONCAT(tb_kelas.nama_kelas SEPARATOR ", ") AS nama_kelas')
            ->join('tb_kelas_pesdik', 'tb_kelas_pesdik.id_pesdik = tb_pesdik.id_pesdik', 'left')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kelas_pesdik.id_kelas', 'left')
            ->groupBy('tb_pesdik.id_pesdik');

        if ($keyword) {
            $builder->groupStart()
                ->like('tb_pesdik.nama', $keyword)
                ->orLike('tb_pesdik.nis', $keyword)
                ->orLike('tb_pesdik.telp', $keyword)
                ->groupEnd();
        }

        $data = [
            'pesdik' => $builder->paginate($perPage),
            'pager'  => $this->pesdikModel->pager,
            'keyword' => $keyword,
        ];

        return view('pesdik/index', $data);
    }

    public function create()
    {
        $data['kelas'] = $this->kelasModel->findAll();
        return view('pesdik/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $fotoName = null;

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/pesdik', $fotoName);
        }

        $this->pesdikModel->save([
            'id_user' => $this->request->getPost('id_user'),
            'nisn' => $this->request->getPost('nisn'),
            'nis' => $this->request->getPost('nis'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => $this->request->getPost('status'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/pesdik')->with('success', 'Data Pesdik berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['pesdik'] = $this->pesdikModel->find($id);
        $data['kelas'] = $this->kelasModel->findAll();
        return view('pesdik/edit', $data);
    }

    public function update($id)
    {
        $foto = $this->request->getFile('foto');
        $fotoName = $this->request->getPost('foto_lama');

        if ($foto && $foto->isValid()) {
            $fotoName = $foto->getRandomName();
            $foto->move('uploads/pesdik', $fotoName);
        }

        $this->pesdikModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'jk' => $this->request->getPost('jk'),
            'nisn' => $this->request->getPost('nisn'),
            'nis' => $this->request->getPost('nis'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'alamat' => $this->request->getPost('alamat'),
            'status' => $this->request->getPost('status'),
            'foto' => $fotoName,
        ]);

        return redirect()->to('/pesdik')->with('success', 'Data Pesdik berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->pesdikModel->delete($id);
        return redirect()->to('/pesdik')->with('success', 'Data Pesdik berhasil dihapus!');
    }

    public function detail($id)
    {
        $pesdikModel    = new \App\Models\PesdikModel();
        $userModel      = new \App\Models\UserModel();
        $kelasModel     = new \App\Models\KelasModel();
        $kelasPesdikModel = new \App\Models\KelasPesdikModel();
        $jabatanModel   = new \App\Models\JabatanModel();

        // Ambil data pesdik
        $pesdik = $pesdikModel
            ->select('tb_pesdik.*, tb_user.username')
            ->join('tb_user', 'tb_user.id_user = tb_pesdik.id_user', 'left')
            ->find($id);

        if (!$pesdik) {
            return redirect()->to('/pesdik')->with('error', 'Data peserta didik tidak ditemukan.');
        }

        // Ambil daftar kelas yang diikuti
        $kelas_diikuti = $kelasPesdikModel
            ->select('tb_kelas_pesdik.*, tb_kelas.nama_kelas')
            ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kelas_pesdik.id_kelas', 'left')
            ->where('tb_kelas_pesdik.id_pesdik', $id)
            ->findAll();

        $kelas = $kelasModel->findAll();

        // Ambil semua kelas (untuk form enroll jika admin)
        $semuaKelas = $kelasModel->findAll();

        // Ambil jabatan aktif
        $jabatan = $jabatanModel
            ->where('id_user', $pesdik['id_user'])
            ->where('status', 'aktif')
            ->findAll();

        return view('pesdik/detail', [
            'title' => 'Detail Peserta Didik',
            'pesdik' => $pesdik,
            'jabatan' => $jabatan,
            'kelas_diikuti' => $kelas_diikuti,
            'kelas' => $kelas,
        ]);
    }


    public function kartu($id)
    {
        $pesdik = $this->pesdikModel->find($id);
        if (!$pesdik) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Peserta didik tidak ditemukan");
        }

        // Data untuk QR code
        $dataQr = (string)$pesdik['id_pesdik'];

        // ✅ Cara baru (v6) — semua properti lewat constructor
        $qrCode = new QrCode(
            data: $dataQr,
            encoding: new Encoding('UTF-8'),
            size: 200,
            margin: 10,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255)
        );

        // Writer untuk PNG
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Convert ke base64 agar bisa ditampilkan di <img>
        $qrImage = base64_encode($result->getString());

        return view('pesdik/kartu', [
            'pesdik' => $pesdik,
            'qrCode' => $qrImage
        ]);
    }
}
