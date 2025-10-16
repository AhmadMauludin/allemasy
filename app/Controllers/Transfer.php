<?php

namespace App\Controllers;

use App\Models\TransferModel;

class Transfer extends BaseController
{
    protected $transferModel;

    public function __construct()
    {
        $this->transferModel = new TransferModel();
    }

    // INDEX
    public function index()
    {
        $role = session('role');
        $id_pesdik = session('id_pesdik');

        // Ambil input pencarian
        $keyword = $this->request->getGet('keyword');
        $tanggal = $this->request->getGet('tanggal');
        $peruntukan = $this->request->getGet('peruntukan');

        // Pagination setup
        $perPage = 10;
        $page = (int)($this->request->getVar('page') ?? 1);

        $builder = $this->transferModel
            ->select('tb_transfer.*, tb_user.username AS nama_verifikator, tb_pesdik.nama as nama_pesdik')
            ->join('tb_pesdik', 'tb_transfer.id_pesdik = tb_pesdik.id_pesdik', 'left')
            ->join('tb_user', 'tb_transfer.verifikator = tb_user.id_user', 'left');

        if ($role === 'pesdik') {
            $builder->where('tb_transfer.id_pesdik', $id_pesdik);
        }

        // Filter pencarian
        if ($keyword) {
            $builder->like('tb_pesdik.nama', $keyword);
        }

        if ($tanggal) {
            $builder->like('DATE(tb_transfer.waktu_transfer)', $tanggal);
        }

        if ($peruntukan) {
            $builder->where('tb_transfer.peruntukan', $peruntukan);
        }

        $data['transfer'] = $builder
            ->orderBy('tb_transfer.id_transfer', 'DESC')
            ->paginate($perPage, 'transfer');

        $data['pager'] = $this->transferModel->pager;
        $data['keyword'] = $keyword;
        $data['tanggal'] = $tanggal;
        $data['peruntukan'] = $peruntukan;

        return view('transfer/index', $data);
    }


    // CREATE FORM (hanya pesdik)
    public function create()
    {
        if (session('role') !== 'pesdik') {
            return redirect()->to('transfer')->with('error', 'Akses ditolak');
        }
        return view('transfer/create');
    }

    // STORE
    public function store()
    {
        if (session('role') !== 'pesdik') {
            return redirect()->to('transfer')->with('error', 'Akses ditolak');
        }

        $validation = $this->validate([
            'peruntukan' => 'required',
            'jumlah' => 'required|numeric',
            'bukti_transfer' => 'uploaded[bukti_transfer]|max_size[bukti_transfer,2048]|is_image[bukti_transfer]'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', 'Periksa kembali input Anda.');
        }

        $file = $this->request->getFile('bukti_transfer');
        $newName = $file->getRandomName();
        $file->move('uploads/transfer', $newName);

        $this->transferModel->insert([
            'id_pesdik' => session('id_pesdik'),
            'peruntukan' => $this->request->getPost('peruntukan'),
            'jumlah' => $this->request->getPost('jumlah'),
            'bukti_transfer' => $newName,
            'status_transfer' => 'pending',
            'keterangan_transfer' => $this->request->getPost('keterangan_transfer') ?? null,
        ]);

        return redirect()->to('transfer')->with('success', 'Transfer berhasil dikirim, menunggu verifikasi admin.');
    }

    // EDIT (untuk admin)
    public function edit($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->to('transfer')->with('error', 'Akses ditolak');
        }

        $data['transfer'] = $this->transferModel->find($id);
        if (!$data['transfer']) {
            return redirect()->to('transfer')->with('error', 'Data tidak ditemukan');
        }

        return view('transfer/edit', $data);
    }

    // UPDATE (verifikasi oleh admin)
    public function update($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->to('transfer')->with('error', 'Akses ditolak');
        }

        $this->transferModel->update($id, [
            'status_transfer' => $this->request->getPost('status_transfer'),
            'keterangan_transfer' => $this->request->getPost('keterangan_transfer'),
            'verifikator' => session('id_user')
        ]);

        return redirect()->to('transfer')->with('success', 'Transfer berhasil diverifikasi.');
    }

    public function delete($id_transfer)
    {
        $transfer = $this->transferModel->find($id_transfer);

        if (!$transfer) {
            return redirect()->to(base_url('transfer'))->with('error', 'Data transfer tidak ditemukan.');
        }

        // Hanya admin yang boleh menghapus
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('transfer'))->with('error', 'Anda tidak memiliki akses untuk menghapus data ini.');
        }

        // Hapus file bukti transfer jika ada
        if (!empty($transfer['bukti_transfer']) && file_exists('uploads/transfer/' . $transfer['bukti_transfer'])) {
            unlink('uploads/transfer/' . $transfer['bukti_transfer']);
        }

        // Hapus data di database
        $this->transferModel->delete($id_transfer);

        return redirect()->to(base_url('transfer'))->with('success', 'Data transfer berhasil dihapus.');
    }

    public function kirimNotif($id_transfer)
    {
        $transfer = $this->transferModel
            ->select('tb_transfer.*, tb_pesdik.nama, tb_pesdik.telp')
            ->join('tb_pesdik', 'tb_pesdik.id_pesdik = tb_transfer.id_pesdik')
            ->find($id_transfer);

        if (!$transfer) {
            return redirect()->to(base_url('transfer'))->with('error', 'Data transfer tidak ditemukan.');
        }

        // Pastikan hanya admin yang bisa mengirim notifikasi
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('transfer'))->with('error', 'Anda tidak memiliki akses untuk fitur ini.');
        }

        // Format nomor telepon (hapus 0 di awal dan ganti dengan 62)
        $nomor = preg_replace('/^0/', '62', $transfer['telp']);

        // Format pesan WhatsApp
        $pesan = "*Pemberitahuan Transfer Diterima*\n\n"
            . "Halo *" . $transfer['nama'] . "*,\n"
            . "Transfer kamu telah *diverifikasi dan diterima* oleh admin.\n\n"
            . "*Detail Transfer:*\n"
            . "ID Transfer: " . $transfer['id_transfer'] . "\n"
            . "Peruntukan: " . ucfirst($transfer['peruntukan']) . "\n"
            . "Jumlah: Rp " . number_format($transfer['jumlah'], 0, ',', '.') . "\n"
            . "Status: " . ucfirst($transfer['status_transfer']) . "\n"
            . "Waktu Transfer: " . $transfer['waktu_transfer'] . "\n"
            . (!empty($transfer['keterangan_transfer']) ? "Keterangan: " . $transfer['keterangan_transfer'] . "\n" : "")
            . "\nTerima kasih telah melakukan transfer.";

        // Encode pesan agar bisa dikirim lewat URL
        $pesan_encoded = urlencode($pesan);

        // Buat URL WhatsApp
        $wa_url = "https://wa.me/{$nomor}?text={$pesan_encoded}";

        // Arahkan langsung ke WhatsApp
        return redirect()->to($wa_url);
    }
}
