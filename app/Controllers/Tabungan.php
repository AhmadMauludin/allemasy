<?php

namespace App\Controllers;

use App\Models\TabunganModel;
use App\Models\PesdikModel;

class Tabungan extends BaseController
{
    protected $tabunganModel;
    protected $pesdikModel;

    public function __construct()
    {
        $this->tabunganModel = new TabunganModel();
        $this->pesdikModel   = new PesdikModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $id_pesdik = session()->get('id_pesdik');

        $keyword = $this->request->getGet('keyword');
        $tanggal = $this->request->getGet('tanggal');
        $jenis_transaksi = $this->request->getGet('jenis_transaksi');

        $builder = $this->tabunganModel->getAllData($role, $id_pesdik, $keyword, $tanggal, $jenis_transaksi);

        $data = [
            'tabungan'         => $builder->paginate(10), // 10 data per halaman
            'pager'            => $this->tabunganModel->pager,
            'title'            => 'Data Tabungan',
            'saldo'            => $this->tabunganModel->getSaldo($id_pesdik),
            'keyword'          => $keyword,
            'tanggal'          => $tanggal,
            'jenis_transaksi'  => $jenis_transaksi,
        ];

        return view('tabungan/index', $data);
    }

    public function create()
    {
        $role = session()->get('role');

        $data = [
            'title' => 'Tambah Transaksi Tabungan',
            'role'  => $role,
        ];

        // Jika admin, kirim daftar pesdik untuk pilihan
        if ($role === 'admin') {
            $data['pesdik'] = $this->pesdikModel->findAll();
        }

        return view('tabungan/create', $data);
    }

    public function store()
    {
        $role = session()->get('role');
        $id_user = session()->get('id_user');
        $id_pesdik_session = session()->get('id_pesdik');

        $validationRules = [
            'jenis_transaksi' => 'required|in_list[setor,tarik]',
            'jumlah'          => 'required|decimal',
            'keterangan'      => 'permit_empty|string|max_length[255]',
        ];

        if ($role === 'admin') {
            $validationRules['id_pesdik'] = 'required|integer';
        }

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('error', 'Validasi gagal. Periksa input Anda.');
        }

        // Tentukan nilai default berdasarkan role
        if ($role === 'admin') {
            $id_pesdik = $this->request->getPost('id_pesdik');
            $status_transaksi = 'disetujui';
            $verifikator = $id_user;
        } else {
            $id_pesdik = $id_pesdik_session;
            $status_transaksi = 'pending';
            $verifikator = null;
        }

        // Upload bukti jika ada
        $buktiFile = $this->request->getFile('bukti_transaksi');
        $buktiName = null;
        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            $buktiName = $buktiFile->getRandomName();
            $buktiFile->move('uploads/tabungan', $buktiName);
        }

        $this->tabunganModel->insert([
            'id_pesdik'        => $id_pesdik,
            'jenis_transaksi'  => $this->request->getPost('jenis_transaksi'),
            'jumlah'           => $this->request->getPost('jumlah'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'bukti_transaksi'  => $buktiName,
            'status_transaksi' => $status_transaksi,
            'verifikator'      => $verifikator,
        ]);

        return redirect()->to(base_url('tabungan'))
            ->with('success', 'Transaksi tabungan berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $role = session()->get('role');
        $id_pesdik = session()->get('id_pesdik');

        $tabungan = $this->tabunganModel->find($id);
        if (!$tabungan) {
            return redirect()->to(base_url('tabungan'))->with('error', 'Data transaksi tidak ditemukan.');
        }

        // Pesdik hanya boleh mengedit miliknya
        if ($role === 'pesdik' && $tabungan['id_pesdik'] != $id_pesdik) {
            return redirect()->to(base_url('tabungan'))->with('error', 'Anda tidak memiliki akses.');
        }

        $data = [
            'title' => 'Edit Transaksi Tabungan',
            'tabungan' => $tabungan,
            'role' => $role,
        ];

        // Jika admin, tampilkan daftar pesdik untuk dropdown
        if ($role === 'admin') {
            $data['pesdik'] = $this->pesdikModel->findAll();
        }

        return view('tabungan/edit', $data);
    }

    public function update($id = null)
    {
        $role = session()->get('role');
        $id_user = session()->get('id_user');
        $id_pesdik = session()->get('id_pesdik');

        $tabungan = $this->tabunganModel->find($id);
        if (!$tabungan) {
            return redirect()->to(base_url('tabungan'))->with('error', 'Data tidak ditemukan.');
        }

        // Pesdik hanya bisa mengubah miliknya sendiri
        if ($role === 'pesdik' && $tabungan['id_pesdik'] != $id_pesdik) {
            return redirect()->to(base_url('tabungan'))->with('error', 'Anda tidak memiliki izin untuk mengedit data ini.');
        }

        $dataUpdate = [];

        if ($role === 'admin') {
            // Admin bisa ubah semua
            $dataUpdate = [
                'jumlah'           => $this->request->getPost('jumlah'),
                'keterangan'       => $this->request->getPost('keterangan'),
                'status_transaksi' => $this->request->getPost('status_transaksi'),
                'verifikator'      => $id_user
            ];
        } else {
            // Pesdik hanya boleh ubah bukti dan keterangan
            $dataUpdate = [
                'keterangan' => $this->request->getPost('keterangan'),
            ];
        }

        // Upload bukti baru jika ada
        $buktiFile = $this->request->getFile('bukti_transaksi');
        if ($buktiFile && $buktiFile->isValid() && !$buktiFile->hasMoved()) {
            $buktiName = $buktiFile->getRandomName();
            $buktiFile->move('uploads/tabungan', $buktiName);
            $dataUpdate['bukti_transaksi'] = $buktiName;
        }

        $this->tabunganModel->update($id, $dataUpdate);

        return redirect()->to(base_url('tabungan'))->with('success', 'Data transaksi berhasil diperbarui.');
    }


    public function delete($id_tabungan)
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('tabungan'))->with('error', 'Akses ditolak.');
        }

        $data = $this->tabunganModel->find($id_tabungan);
        if ($data && !empty($data['bukti_transaksi']) && file_exists('uploads/tabungan/' . $data['bukti_transaksi'])) {
            unlink('uploads/tabungan/' . $data['bukti_transaksi']);
        }

        $this->tabunganModel->delete($id_tabungan);
        return redirect()->to(base_url('tabungan'))->with('success', 'Data tabungan berhasil dihapus.');
    }

    public function detail($id_pesdik = null)
    {
        $role = session()->get('role');
        $id_pesdik_session = session()->get('id_pesdik');

        // Jika role = pesdik, hanya boleh lihat datanya sendiri
        if ($role === 'pesdik') {
            $id_pesdik = $id_pesdik_session;
        } elseif ($id_pesdik === null) {
            return redirect()->to(base_url('tabungan'))->with('error', 'ID Pesdik tidak valid.');
        }

        $pesdik = $this->pesdikModel->find($id_pesdik);
        if (!$pesdik) {
            return redirect()->to(base_url('tabungan'))->with('error', 'Data pesdik tidak ditemukan.');
        }

        $data = [
            'title'      => 'Detail Tabungan - ' . $pesdik['nama'],
            'pesdik'     => $pesdik,
            'tabungan'   => $this->tabunganModel->getByPesdik($id_pesdik),
            'saldo'      => $this->tabunganModel->getSaldo($id_pesdik)
        ];

        return view('tabungan/detail', $data);
    }

    public function kirimNotif($id_tabungan)
    {
        // Ambil data tabungan beserta data pesdik dan verifikator
        $tabungan = $this->tabunganModel
            ->select('tb_tabungan.*, tb_pesdik.nama as nama_pesdik, tb_pesdik.telp, tb_user.username as nama_verifikator')
            ->join('tb_pesdik', 'tb_tabungan.id_pesdik = tb_pesdik.id_pesdik', 'left')
            ->join('tb_user', 'tb_user.id_user = tb_tabungan.verifikator', 'left')
            ->where('tb_tabungan.id_tabungan', $id_tabungan)
            ->first();

        if (!$tabungan) {
            return redirect()->back()->with('error', 'Data tabungan tidak ditemukan.');
        }

        // Format nomor telepon menjadi format internasional (misal +62)
        $telp = preg_replace('/^0/', '62', $tabungan['telp']);

        // Format pesan WhatsApp
        $pesan = "*Pemberitahuan Transaksi Tabungan Santri*\n\n"
            . "Nama: *{$tabungan['nama_pesdik']}*\n"
            . "Tanggal Transaksi: " . date('d/m/Y H:i', strtotime($tabungan['tanggal_transaksi'])) . "\n"
            . "Jenis Transaksi: *" . ucfirst($tabungan['jenis_transaksi']) . "*\n"
            . "Jumlah: *Rp " . number_format($tabungan['jumlah'], 0, ',', '.') . "*\n"
            . "Status: *" . ucfirst($tabungan['status_transaksi']) . "*\n"
            . "Verifikator: {$tabungan['nama_verifikator']}\n"
            . "\nTerima kasih telah menggunakan layanan tabungan santri.";

        // Encode pesan ke URL
        $pesan_encoded = urlencode($pesan);

        // Redirect ke WhatsApp
        return redirect()->to("https://wa.me/{$telp}?text={$pesan_encoded}");
    }
}
