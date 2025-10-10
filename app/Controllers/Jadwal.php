<?php

namespace App\Controllers;

use App\Models\JadwalModel;
use App\Models\KontrakJadwalModel;
use App\Models\RuanganModel;

class Jadwal extends BaseController
{
    protected $jadwalModel;
    protected $kontrakModel;
    protected $ruanganModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->kontrakModel = new KontrakJadwalModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data['jadwal'] = $this->jadwalModel->getAllJadwal();
        return view('jadwal/index', $data);
    }

    public function create()
    {
        $data['kontrak'] = $this->kontrakModel->getAllKontrak();
        $data['ruangan'] = $this->ruanganModel->findAll();
        return view('jadwal/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/jadwal/', $namaFoto);
        }

        $this->jadwalModel->save([
            'id_kontrak_jadwal' => $this->request->getPost('id_kontrak_jadwal'),
            'hari' => $this->request->getPost('hari'),
            'jampel' => $this->request->getPost('jampel'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $namaFoto
        ]);

        return redirect()->to('/jadwal')->with('success', 'Data jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['jadwal'] = $this->jadwalModel->find($id);
        $data['kontrak'] = $this->kontrakModel->getAllKontrak();
        $data['ruangan'] = $this->ruanganModel->findAll();
        return view('jadwal/edit', $data);
    }

    public function update($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/jadwal/', $namaFoto);

            if (!empty($jadwal['foto']) && file_exists('uploads/jadwal/' . $jadwal['foto'])) {
                unlink('uploads/jadwal/' . $jadwal['foto']);
            }
        } else {
            $namaFoto = $jadwal['foto'];
        }

        $this->jadwalModel->update($id, [
            'id_kontrak_jadwal' => $this->request->getPost('id_kontrak_jadwal'),
            'hari' => $this->request->getPost('hari'),
            'jampel' => $this->request->getPost('jampel'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $namaFoto
        ]);

        return redirect()->to('/jadwal')->with('success', 'Data jadwal berhasil diperbarui.');
    }

    public function delete($id)
    {
        $jadwal = $this->jadwalModel->find($id);
        if ($jadwal && $jadwal['foto'] && file_exists('uploads/jadwal/' . $jadwal['foto'])) {
            unlink('uploads/jadwal/' . $jadwal['foto']);
        }
        $this->jadwalModel->delete($id);
        return redirect()->to('/jadwal')->with('success', 'Data jadwal berhasil dihapus.');
    }
}
