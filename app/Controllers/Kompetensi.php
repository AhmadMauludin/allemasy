<?php

namespace App\Controllers;

use App\Models\KompetensiModel;
use App\Models\MapelModel;
use App\Models\BukuModel;
use CodeIgniter\Controller;

class Kompetensi extends Controller
{
    protected $kompetensiModel;
    protected $mapelModel;
    protected $bukuModel;

    public function __construct()
    {
        $this->kompetensiModel = new KompetensiModel();
        $this->mapelModel = new MapelModel();
        $this->bukuModel = new BukuModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kompetensi',
            'kompetensi' => $this->kompetensiModel->getAll()
        ];

        return view('kompetensi/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kompetensi',
            'mapel' => $this->mapelModel->findAll(),
            'buku' => $this->bukuModel->findAll(),
        ];

        return view('kompetensi/create', $data);
    }

    public function store()
    {
        $file = $this->request->getFile('foto');
        $namaFoto = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/kompetensi', $namaFoto);
        }

        $this->kompetensiModel->save([
            'jenis_kompetensi' => $this->request->getPost('jenis_kompetensi'),
            'id_mapel' => $this->request->getPost('id_mapel'),
            'id_buku' => $this->request->getPost('id_buku'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => $namaFoto,
        ]);

        return redirect()->to(base_url('kompetensi'))->with('success', 'Data kompetensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Kompetensi',
            'kompetensi' => $this->kompetensiModel->find($id),
            'mapel' => $this->mapelModel->findAll(),
            'buku' => $this->bukuModel->findAll(),
        ];

        return view('kompetensi/edit', $data);
    }

    public function update($id)
    {
        $kompetensi = $this->kompetensiModel->find($id);
        $file = $this->request->getFile('foto');

        $namaFoto = $kompetensi['foto'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/kompetensi', $namaFoto);
        }

        $this->kompetensiModel->update($id, [
            'jenis_kompetensi' => $this->request->getPost('jenis_kompetensi'),
            'id_mapel' => $this->request->getPost('id_mapel'),
            'id_buku' => $this->request->getPost('id_buku'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan'),
            'foto' => $namaFoto,
        ]);

        return redirect()->to(base_url('kompetensi'))->with('success', 'Data kompetensi berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kompetensiModel->delete($id);
        return redirect()->to(base_url('kompetensi'))->with('success', 'Data kompetensi berhasil dihapus.');
    }
}
