<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BatuModels;
use App\Models\KelasModels;

class BatuControllers extends BaseController
{
    protected $batu;
    protected $kelas;

    public function __construct()
    {
        $this->batu  = new BatuModels();
        $this->kelas = new KelasModels();
    }

    // =========================
    // READ
    // =========================
    public function index()
    {
        $data['batu'] = $this->batu->getBatuWithKelas();
        return view('PanitiaBatu', $data);
    }

    // =========================
    // CREATE (Form)
    // =========================
    public function create()
    {
        $data['kelas'] = $this->kelas->findAll();
        return view('TambahBatu', $data);
    }

    // =========================
    // CREATE (Simpan + Validasi)
    // =========================
    public function store()
    {
        $rules = [
            'jenis_batu' => 'required|min_length[3]',
            'id_kelas'   => 'required|numeric'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->batu->insert([
            'jenis_batu' => $this->request->getPost('jenis_batu'),
            'id_kelas'   => $this->request->getPost('id_kelas'),
            'id_bobot'   => null
        ]);

        return redirect()->to('/batu')
            ->with('success', 'Data batu berhasil ditambahkan');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id_batu)
    {
        $this->batu->delete($id_batu);

        return redirect()->to('/batu')
            ->with('success', 'Data batu berhasil dihapus');
    }
}
