<?php

namespace App\Controllers;

use App\Models\KontrakJadwalModel;
use App\Models\MapelModel;
use App\Models\UserModel;
use App\Models\KelasModel;
use App\Models\PesdikModel;
use App\Models\TahunAjaranModel;
use App\Models\KelasPesdikModel;

class KontrakJadwal extends BaseController
{
    protected $kontrakModel;
    protected $mapelModel;
    protected $userModel;
    protected $kelasModel;
    protected $pesdikModel;
    protected $tahunajaranModel;
    protected $kelasPesdikModel;

    public function __construct()
    {
        $this->kontrakModel = new KontrakJadwalModel();
        $this->mapelModel = new MapelModel();
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
        $this->pesdikModel = new PesdikModel();
        $this->tahunajaranModel = new TahunAjaranModel();
        $this->kelasPesdikModel = new KelasPesdikModel();
    }

    public function index()
    {
        $role = session()->get('role');
        $userId = session()->get('id_user');

        if ($role === 'admin') {
            // Admin: lihat semua kontrak
            $data['kontrak'] = $this->kontrakModel->getAllKontrak();
        } elseif ($role === 'guru') {
            // Guru: hanya kontrak miliknya
            $data['kontrak'] = $this->kontrakModel
                ->select('tb_kontrak_jadwal.*, tb_mapel.nama_mapel, tb_kelas.nama_kelas, tb_user.username AS nama_guru, tb_tahun_ajaran.*')
                ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                ->join('tb_tahun_ajaran', 'tb_tahun_ajaran.id_tahun_ajaran = tb_kontrak_jadwal.id_tahun_ajaran', 'left')
                ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
                ->where('tb_kontrak_jadwal.id_user', $userId)
                ->findAll();
        } elseif ($role === 'pesdik') {
            // Pesdik: ambil semua kelas yang ia ikuti dari tabel pivot
            $pesdik = $this->pesdikModel->where('id_user', $userId)->first();

            if ($pesdik) {
                // Ambil daftar id_kelas yang diikuti oleh pesdik ini
                $kelasList = $this->kelasPesdikModel
                    ->select('id_kelas')
                    ->where('id_pesdik', $pesdik['id_pesdik'])
                    ->findAll();

                $kelasIds = array_column($kelasList, 'id_kelas');

                if (!empty($kelasIds)) {
                    $data['kontrak'] = $this->kontrakModel
                        ->select('tb_kontrak_jadwal.*, tb_mapel.nama_mapel, tb_kelas.nama_kelas, tb_user.username AS nama_guru, tb_tahun_ajaran.*')
                        ->join('tb_mapel', 'tb_mapel.id_mapel = tb_kontrak_jadwal.id_mapel', 'left')
                        ->join('tb_tahun_ajaran', 'tb_tahun_ajaran.id_tahun_ajaran = tb_kontrak_jadwal.id_tahun_ajaran', 'left')
                        ->join('tb_kelas', 'tb_kelas.id_kelas = tb_kontrak_jadwal.id_kelas', 'left')
                        ->join('tb_user', 'tb_user.id_user = tb_kontrak_jadwal.id_user', 'left')
                        ->whereIn('tb_kontrak_jadwal.id_kelas', $kelasIds)
                        ->findAll();
                } else {
                    $data['kontrak'] = [];
                }
            } else {
                $data['kontrak'] = [];
            }
        } else {
            $data['kontrak'] = [];
        }

        return view('kontrak_jadwal/index', $data);
    }

    public function create()
    {
        $data['mapel'] = $this->mapelModel->findAll();
        $data['guru'] = $this->userModel->where('role', 'guru')->findAll();
        $data['kelas'] = $this->kelasModel->findAll();
        $data['tahun_ajaran'] = $this->tahunajaranModel->findAll();

        return view('kontrak_jadwal/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/kontrak/', $namaFoto);
        }

        $this->kontrakModel->save([
            'id_mapel' => $this->request->getPost('id_mapel'),
            'id_user' => $this->request->getPost('id_user'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'id_tahun_ajaran' => $this->request->getPost('id_tahun_ajaran'),
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $namaFoto
        ]);

        return redirect()->to('/kontrak')->with('success', 'Data kontrak jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['kontrak'] = $this->kontrakModel->find($id);
        $data['mapel'] = $this->mapelModel->findAll();
        $data['guru'] = $this->userModel->where('role', 'guru')->findAll();
        $data['kelas'] = $this->kelasModel->findAll();
        $data['tahun_ajaran'] = $this->tahunajaranModel->findAll();
        return view('kontrak_jadwal/edit', $data);
    }

    public function update($id)
    {
        $kontrak = $this->kontrakModel->find($id);
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/kontrak/', $namaFoto);

            if (!empty($kontrak['foto']) && file_exists('uploads/kontrak/' . $kontrak['foto'])) {
                unlink('uploads/kontrak/' . $kontrak['foto']);
            }
        } else {
            $namaFoto = $kontrak['foto'];
        }

        $this->kontrakModel->update($id, [
            'id_mapel' => $this->request->getPost('id_mapel'),
            'id_user' => $this->request->getPost('id_user'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'id_tahun_ajaran' => $this->request->getPost('id_tahun_ajaran'),
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $namaFoto
        ]);

        return redirect()->to('/kontrak')->with('success', 'Data kontrak jadwal berhasil diperbarui.');
    }

    public function delete($id)
    {
        $kontrak = $this->kontrakModel->find($id);
        if ($kontrak && $kontrak['foto'] && file_exists('uploads/kontrak/' . $kontrak['foto'])) {
            unlink('uploads/kontrak/' . $kontrak['foto']);
        }
        $this->kontrakModel->delete($id);
        return redirect()->to('/kontrak')->with('success', 'Data kontrak jadwal berhasil dihapus.');
    }
}
