<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubKriteriaModel;

class SubKriteriaController extends BaseController
{
    protected $subKriteria;

    public function __construct()
    {
        $this->subKriteria = new SubKriteriaModel();
    }

    /* =====================================================
     * INDEX - LIST SUB KRITERIA
     * ===================================================== */
    public function index()
    {
        $data = [
            'sub'   => $this->subKriteria->getAll()
        ];

        return view('PanitiaSubKriteria', $data);
    }

    public function create()
    {
        return view('TambahSubKriteria');
    }


    /* =====================================================
     * STORE - SIMPAN SUB KRITERIA
     * ===================================================== */
    public function store()
    {
        $rules = [
            'nama_sub' => 'required|min_length[2]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nama = trim($this->request->getPost('nama_sub'));

        // Cegah duplikat
        if ($this->subKriteria->existsByName($nama)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sub kriteria sudah ada');
        }

        $this->subKriteria->insertSub([
            'nama_sub' => $nama
        ]);

        return redirect()->to(site_url('sub-kriteria'))
            ->with('success', 'Sub kriteria berhasil ditambahkan');
    }

    /* =====================================================
     * EDIT - FORM EDIT
     * ===================================================== */
    public function edit($id)
    {
        $sub = $this->subKriteria->getById($id);

        if (! $sub) {
            return redirect()->to(site_url('sub-kriteria'))
                ->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Sub Kriteria',
            'sub'   => $sub
        ];

        return view('sub_kriteria/edit', $data);
    }

    /* =====================================================
     * UPDATE
     * ===================================================== */
    public function update($id)
    {
        $rules = [
            'nama_sub' => 'required|min_length[2]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $nama = trim($this->request->getPost('nama_sub'));

        // Cegah duplikat (kecuali data sendiri)
        if ($this->subKriteria->existsByName($nama, $id)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sub kriteria sudah ada');
        }

        $this->subKriteria->updateSub($id, [
            'nama_sub' => $nama
        ]);

        return redirect()->to(site_url('sub-kriteria'))
            ->with('success', 'Sub kriteria berhasil diperbarui');
    }

    /* =====================================================
     * DELETE
     * ===================================================== */
    public function delete($id)
    {
        $sub = $this->subKriteria->getById($id);

        if (! $sub) {
            return redirect()->to(site_url('sub-kriteria'))
                ->with('error', 'Data tidak ditemukan');
        }

        $this->subKriteria->deleteSub($id);

        return redirect()->to(site_url('sub-kriteria'))
            ->with('success', 'Sub kriteria berhasil dihapus');
    }
}
