<?php

namespace App\Controllers;

use App\Models\BiayaModel;
use App\Models\PembayaranModel;
use App\Models\KelasModel;
use App\Models\KelasPesdikModel;

class Biaya extends BaseController
{
    protected $biayaModel;
    protected $pembayaranModel;
    protected $kelasModel;
    protected $kelasPesdikModel;

    public function __construct()
    {
        $this->biayaModel = new BiayaModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->kelasModel = new KelasModel();
        $this->kelasPesdikModel = new KelasPesdikModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tb_biaya b');

        if (session('role') === 'pesdik') {
            // Hanya biaya yang dibebankan ke pesdik ini
            $id_pesdik = session('id_pesdik'); // sesuaikan dengan id_pesdik
            $builder->select('b.*, p.status_pembayaran, p.id_pembayaran')
                ->join('tb_pembayaran p', 'p.id_biaya = b.id_biaya')
                ->where('p.id_pesdik', $id_pesdik);
        } else {
            // Admin lihat semua biaya tanpa join pembayaran
            $builder->select('b.*');
        }

        $builder->orderBy('b.id_biaya', 'DESC');
        $data['biaya'] = $builder->get()->getResultArray();

        return view('biaya/index', $data);
    }


    public function create()
    {
        return view('biaya/create');
    }

    public function store()
    {
        $post = $this->request->getPost();

        // Simpan data biaya
        $id_biaya = $this->biayaModel->insert([
            'jenis_biaya' => $post['jenis_biaya'],
            'peruntukan' => $post['peruntukan'],
            'tingkat' => $post['tingkat'],
            'biaya' => $post['biaya'],
            'status_biaya' => $post['status_biaya'],
            'keterangan_biaya' => $post['keterangan_biaya'] ?? null
        ]);

        // Ambil kelas yang sesuai jenis_biaya
        $kelasQuery = $this->kelasModel->where('jenis_kelas', $post['jenis_biaya']);
        if ($post['tingkat'] !== 'Semua') {
            $kelasQuery->where('tingkat', $post['tingkat']);
        }
        $kelasList = $kelasQuery->findAll();

        // Ambil semua id_pesdik di kelas yang sesuai
        $pesdikIds = [];
        foreach ($kelasList as $kelas) {
            $kelasPesdik = $this->kelasPesdikModel->where('id_kelas', $kelas['id_kelas'])->findAll();
            foreach ($kelasPesdik as $kp) {
                $pesdikIds[] = $kp['id_pesdik'];
            }
        }

        // Insert ke tb_pembayaran
        foreach ($pesdikIds as $id_pesdik) {
            $this->pembayaranModel->insert([
                'id_biaya' => $id_biaya,
                'id_pesdik' => $id_pesdik,
                'status_pembayaran' => 'belum dibayar'
            ]);
        }

        return redirect()->to('/biaya')->with('success', 'Data biaya berhasil ditambahkan');
    }
    // Hapus data biaya beserta pembayaran terkait
    public function delete($id)
    {
        $biaya = $this->biayaModel->find($id);
        if (!$biaya) {
            return redirect()->to('/biaya')->with('error', 'Data biaya tidak ditemukan');
        }

        // Menghapus data biaya (ON DELETE CASCADE otomatis akan menghapus tb_pembayaran)
        $this->biayaModel->delete($id);

        return redirect()->to('/biaya')->with('success', 'Data biaya berhasil dihapus');
    }

    // Detail biaya dan list pembayaran
    public function detail($id)
    {
        $biaya = $this->biayaModel->find($id);
        if (!$biaya) {
            return redirect()->to('/biaya')->with('error', 'Data biaya tidak ditemukan');
        }

        // Ambil list pembayaran untuk biaya ini
        $db = \Config\Database::connect();
        $builder = $db->table('tb_pembayaran p');
        $builder->select('p.id_pembayaran, p.status_pembayaran, p.metode, u.nama as nama_pesdik, k.nama_kelas');
        $builder->join('tb_pesdik u', 'p.id_pesdik = u.id_pesdik');
        $builder->join('tb_kelas_pesdik kp', 'kp.id_pesdik = u.id_pesdik');
        $builder->join('tb_kelas k', 'kp.id_kelas = k.id_kelas');
        $builder->where('p.id_biaya', $id);
        $builder->where('k.jenis_kelas', $biaya['jenis_biaya']);
        $pembayaran = $builder->get()->getResultArray();


        return view('biaya/detail', [
            'biaya' => $biaya,
            'pembayaran' => $pembayaran
        ]);
    }
}
