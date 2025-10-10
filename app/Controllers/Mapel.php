<?php

namespace App\Controllers;

use App\Models\MapelModel;
use App\Models\BukuModel;

class Mapel extends BaseController
{
    protected $mapelModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->mapelModel = new MapelModel();
        $this->bukuModel = new BukuModel();
    }

    public function index()
    {
        $data['mapel'] = $this->mapelModel->getMapelWithBuku();
        return view('mapel/index', $data);
    }

    public function create()
    {
        $data['buku'] = $this->bukuModel->findAll();
        return view('mapel/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/mapel/', $namaFoto);
        }

        $this->mapelModel->save([
            'kode_mapel' => $this->request->getPost('kode_mapel'),
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'golongan'   => $this->request->getPost('golongan'),
            'tingkat'    => $this->request->getPost('tingkat'),
            'id_buku'    => $this->request->getPost('id_buku'),
            'status'     => $this->request->getPost('status'),
            'ket'        => $this->request->getPost('ket'),
            'foto'       => $namaFoto
        ]);

        return redirect()->to('/mapel')->with('success', 'Data mapel berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data['mapel'] = $this->mapelModel->find($id);
        $data['buku'] = $this->bukuModel->findAll();
        return view('mapel/edit', $data);
    }

    public function update($id)
    {
        $mapel = $this->mapelModel->find($id);
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/mapel/', $namaFoto);

            if (!empty($mapel['foto']) && file_exists('uploads/mapel/' . $mapel['foto'])) {
                unlink('uploads/mapel/' . $mapel['foto']);
            }
        } else {
            $namaFoto = $mapel['foto'];
        }

        $this->mapelModel->update($id, [
            'kode_mapel' => $this->request->getPost('kode_mapel'),
            'nama_mapel' => $this->request->getPost('nama_mapel'),
            'golongan'   => $this->request->getPost('golongan'),
            'tingkat'    => $this->request->getPost('tingkat'),
            'id_buku'    => $this->request->getPost('id_buku'),
            'status'     => $this->request->getPost('status'),
            'ket'        => $this->request->getPost('ket'),
            'foto'       => $namaFoto
        ]);

        return redirect()->to('/mapel')->with('success', 'Data mapel berhasil diperbarui.');
    }

    public function delete($id)
    {
        $mapel = $this->mapelModel->find($id);
        if ($mapel && $mapel['foto'] && file_exists('uploads/mapel/' . $mapel['foto'])) {
            unlink('uploads/mapel/' . $mapel['foto']);
        }
        $this->mapelModel->delete($id);
        return redirect()->to('/mapel')->with('success', 'Data mapel berhasil dihapus.');
    }
}
