<?php

namespace App\Controllers;

use App\Models\KontrakJadwalModel;
use App\Models\MapelModel;
use App\Models\UserModel;
use App\Models\KelasModel;
use App\Models\TahunAjaranModel;

class KontrakJadwal extends BaseController
{
    protected $kontrakModel;
    protected $mapelModel;
    protected $userModel;
    protected $kelasModel;
    protected $tahunajaranModel;


    public function __construct()
    {
        $this->kontrakModel = new KontrakJadwalModel();
        $this->mapelModel = new MapelModel();
        $this->userModel = new UserModel();
        $this->kelasModel = new KelasModel();
        $this->tahunajaranModel = new TahunAjaranModel();
    }

    public function index()
    {
        $data['kontrak'] = $this->kontrakModel->getAllKontrak();

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
