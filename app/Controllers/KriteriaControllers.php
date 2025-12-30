<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KriteriaModels;
use App\Models\BatuModels;

class KriteriaControllers extends BaseController
{
    protected $kriteria;
    protected $batu;

    public function __construct()
    {
        $this->kriteria = new KriteriaModels();
        $this->batu = new BatuModels();
    }

    // =========================
    // READ
    // =========================
    public function index()
    {
        $data['kriteria'] = $this->kriteria->findAll();
        return view('PanitiaKriteria', $data);
    }

    // =========================
    // CREATE (Form)
    // =========================
    public function create()
    {
        return view('TambahKriteria');
    }

    // =========================
    // CREATE (Simpan + Validasi)
    // =========================
    public function store()
    {
        $rules = [
            'kriteria' => 'required|min_length[3]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kriteria->insert([
            'kriteria' => $this->request->getPost('kriteria')
        ]);

        return redirect()->to('/kriteria')
            ->with('success', 'Data kriteria berhasil ditambahkan');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id_kriteria)
    {
        $this->kriteria->delete($id_kriteria);

        return redirect()->to('/kriteria')
            ->with('success', 'Data kriteria berhasil dihapus');
    }
}
