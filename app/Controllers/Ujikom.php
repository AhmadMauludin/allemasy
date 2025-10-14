<?php

namespace App\Controllers;

use App\Models\UjikomModel;
use App\Models\KompetensiPesdikModel;
use CodeIgniter\Controller;

class Ujikom extends Controller
{
    protected $ujikomModel;
    protected $kompetensiPesdikModel;

    public function __construct()
    {
        $this->ujikomModel = new UjikomModel();
        $this->kompetensiPesdikModel = new KompetensiPesdikModel();
        helper(['form', 'url']);
    }

    public function index($id_kompetensi_pesdik)
    {
        $data['ujikom'] = $this->ujikomModel
            ->where('id_kompetensi_pesdik', $id_kompetensi_pesdik)
            ->findAll();

        $data['kompetensi_pesdik'] = $this->kompetensiPesdikModel->find($id_kompetensi_pesdik);
        $data['title'] = 'Data Ujikom';

        return view('ujikom/index', $data);
    }

    public function create($id_kompetensi_pesdik)
    {
        $data['id_kompetensi_pesdik'] = $id_kompetensi_pesdik;
        $data['title'] = 'Tambah Ujikom';

        return view('ujikom/create', $data);
    }

    public function store()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/ujikom/', $namaFoto);
        }

        $this->ujikomModel->save([
            'id_kompetensi_pesdik' => $this->request->getPost('id_kompetensi_pesdik'),
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
            'rincian' => $this->request->getPost('rincian'),
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('ujikom/index/' . $this->request->getPost('id_kompetensi_pesdik')))
            ->with('success', 'Data ujikom berhasil ditambahkan.');
    }

    public function edit($id_ujikom)
    {
        $data['ujikom'] = $this->ujikomModel->find($id_ujikom);
        $data['title'] = 'Edit Ujikom';

        return view('ujikom/edit', $data);
    }

    public function update($id_ujikom)
    {
        $ujikom = $this->ujikomModel->find($id_ujikom);
        $foto = $this->request->getFile('foto');
        $namaFoto = $ujikom['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/ujikom/', $namaFoto);
        }

        $this->ujikomModel->update($id_ujikom, [
            'waktu' => $this->request->getPost('waktu'),
            'status' => $this->request->getPost('status'),
            'rincian' => $this->request->getPost('rincian'),
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('ujikom/index/' . $ujikom['id_kompetensi_pesdik']))
            ->with('success', 'Data ujikom berhasil diperbarui.');
    }

    public function delete($id_ujikom)
    {
        $ujikom = $this->ujikomModel->find($id_ujikom);
        $this->ujikomModel->delete($id_ujikom);

        return redirect()->to(base_url('ujikom/index/' . $ujikom['id_kompetensi_pesdik']))
            ->with('success', 'Data ujikom berhasil dihapus.');
    }
}
