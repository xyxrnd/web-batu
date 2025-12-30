<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModels;

class KelasControllers extends BaseController
{
    protected $kelas;

    public function __construct()
    {
        $this->kelas = new KelasModels();
    }

    // =========================
    // READ (Daftar Kelas)
    // =========================
    public function index()
    {
        $data['kelas'] = $this->kelas->findAll();
        return view('PanitiaKelas', $data);
    }

    // =========================
    // CREATE (Form Tambah)
    // =========================
    public function create()
    {
        return view('TambahKelas');
    }

    // =========================
    // CREATE (Simpan + Validasi)
    // =========================
    public function store()
    {
        $rules = [
            'kelas' => 'required|min_length[2]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kelas->insert([
            'kelas' => $this->request->getPost('kelas')
        ]);

        return redirect()->to('/kelas')
            ->with('success', 'Data kelas berhasil ditambahkan');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id_kelas)
    {
        $this->kelas->delete($id_kelas);

        return redirect()->to('/kelas')
            ->with('success', 'Data kelas berhasil dihapus');
    }
}
