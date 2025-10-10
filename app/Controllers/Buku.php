<?php

namespace App\Controllers;

use App\Models\BukuModel;
use CodeIgniter\Controller;

class Buku extends BaseController
{
    protected $bukuModel;

    public function __construct()
    {
        $this->bukuModel = new BukuModel();
    }

    // Daftar Buku
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $query = $this->bukuModel;

        if ($keyword) {
            $query = $query->search($keyword);
        }

        $data = [
            'title' => 'Data Buku',
            'buku'  => $query->paginate(10),
            'pager' => $this->bukuModel->pager,
            'keyword' => $keyword
        ];

        return view('buku/index', $data);
    }

    // Tambah Buku
    public function create()
    {
        return view('buku/create', ['title' => 'Tambah Buku']);
    }

    // Simpan Buku
    public function store()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = $foto->isValid() && !$foto->hasMoved()
            ? $foto->getRandomName()
            : null;

        if ($namaFoto) {
            $foto->move('uploads/buku/', $namaFoto);
        }

        $this->bukuModel->insert([
            'judul' => $this->request->getPost('judul'),
            'pengarang' => $this->request->getPost('pengarang'),
            'penerbit' => $this->request->getPost('penerbit'),
            'keilmuan' => $this->request->getPost('keilmuan'),
            'tahun' => $this->request->getPost('tahun'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $namaFoto
        ]);

        return redirect()->to('/buku')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Detail Buku
    public function show($id)
    {
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->bukuModel->find($id)
        ];

        return view('buku/detail', $data);
    }

    // Edit Buku
    public function edit($id)
    {
        $data = [
            'title' => 'Edit Buku',
            'buku' => $this->bukuModel->find($id)
        ];

        return view('buku/edit', $data);
    }

    // Update Buku
    public function update($id)
    {
        $bukuLama = $this->bukuModel->find($id);
        $foto = $this->request->getFile('foto');
        $namaFoto = $bukuLama['foto'];

        if ($foto->isValid() && !$foto->hasMoved()) {
            if ($namaFoto && file_exists('uploads/buku/' . $namaFoto)) {
                unlink('uploads/buku/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/buku/', $namaFoto);
        }

        $this->bukuModel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'pengarang' => $this->request->getPost('pengarang'),
            'penerbit' => $this->request->getPost('penerbit'),
            'keilmuan' => $this->request->getPost('keilmuan'),
            'tahun' => $this->request->getPost('tahun'),
            'status' => $this->request->getPost('status'),
            'ket' => $this->request->getPost('ket'),
            'foto' => $namaFoto
        ]);

        return redirect()->to('/buku')->with('success', 'Data buku berhasil diperbarui!');
    }

    // Hapus Buku
    public function delete($id)
    {
        $buku = $this->bukuModel->find($id);
        if ($buku['foto'] && file_exists('uploads/buku/' . $buku['foto'])) {
            unlink('uploads/buku/' . $buku['foto']);
        }

        $this->bukuModel->delete($id);
        return redirect()->to('/buku')->with('success', 'Buku berhasil dihapus!');
    }
}
