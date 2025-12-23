<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubKriteriaModel;
use App\Models\KriteriaModels;
use App\Models\BatuModels;

class SubKriteriaController extends BaseController
{
    protected $subKriteria;
    protected $kriteria;
    protected $batu;

    public function __construct()
    {
        $this->subKriteria = new SubKriteriaModel();
        $this->kriteria    = new KriteriaModels();
        $this->batu        = new BatuModels();
    }

    /**
     * =====================
     * LIST SUB KRITERIA PER BATU
     * =====================
     */
    public function index($id_batu)
    {
        $batu = $this->batu->find($id_batu);

        if (! $batu) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data batu tidak ditemukan');
        }

        $data = [
            'title'        => 'Sub Kriteria',
            'batu'         => $batu,
            'sub_kriteria' => $this->subKriteria->getByBatuGrouped($id_batu),
            'kriteria'     => $this->kriteria->findAll()
        ];

        return view('PanitiaSubKriteria', $data);
    }

    /**
     * =====================
     * SIMPAN DATA
     * =====================
     */
    public function store($id_batu)
    {
        $rules = [
            'id_kriteria'       => 'required',
            'nama_sub_kriteria' => 'required|min_length[3]',
            'nilai'             => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $this->subKriteria->insertSubKriteria([
            'id_batu'           => $id_batu,
            'id_kriteria'       => $this->request->getPost('id_kriteria'),
            'nama_sub_kriteria' => $this->request->getPost('nama_sub_kriteria'),
            'nilai'             => $this->request->getPost('nilai'),
        ]);

        return redirect()->to("/batu/$id_batu/sub-kriteria")
            ->with('success', 'Sub kriteria berhasil ditambahkan');
    }

    /**
     * =====================
     * FORM EDIT
     * =====================
     */
    public function edit($id_batu, $id)
    {
        $sub = $this->subKriteria->getByIdAndBatu($id, $id_batu);

        if (! $sub) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak valid');
        }

        $data = [
            'title'        => 'Edit Sub Kriteria',
            'batu'         => $this->batu->find($id_batu),
            'sub_kriteria' => $sub,
            'kriteria'     => $this->kriteria->findAll()
        ];

        return view('sub_kriteria/edit', $data);
    }

    /**
     * =====================
     * UPDATE DATA
     * =====================
     */
    public function update($id_batu, $id)
    {
        $rules = [
            'id_kriteria'       => 'required',
            'nama_sub_kriteria' => 'required|min_length[3]',
            'nilai'             => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $this->subKriteria->updateSubKriteria($id, [
            'id_kriteria'       => $this->request->getPost('id_kriteria'),
            'nama_sub_kriteria' => $this->request->getPost('nama_sub_kriteria'),
            'nilai'             => $this->request->getPost('nilai'),
        ]);

        return redirect()->to("/batu/$id_batu/sub-kriteria")
            ->with('success', 'Sub kriteria berhasil diupdate');
    }

    /**
     * =====================
     * HAPUS DATA
     * =====================
     */
    public function delete($id_batu, $id)
    {
        $sub = $this->subKriteria->getByIdAndBatu($id, $id_batu);

        if (! $sub) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak valid');
        }

        $this->subKriteria->deleteSubKriteria($id);

        return redirect()->to("/batu/$id_batu/sub-kriteria")
            ->with('success', 'Sub kriteria berhasil dihapus');
    }
}
