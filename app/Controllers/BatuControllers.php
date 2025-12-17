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
    public function DaftarBatu()
    {
        $data['batu'] = $this->batu->getBatuWithKelas();
        return view('PanitiaBatu', $data);
    }

    // =========================
    // CREATE (Form)
    // =========================
    public function TambahBatu()
    {
        $data['kelas'] = $this->kelas->findAll();
        return view('TambahBatu', $data);
    }

    // =========================
    // CREATE (Simpan + Validasi)
    // =========================
    public function SimpanBatu()
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
    // UPDATE (Form)
    // =========================
    public function EditBatu($id_batu)
    {
        $data['batu']  = $this->batu->find($id_batu);
        $data['kelas'] = $this->kelas->findAll();

        return view('EditBatu', $data);
    }

    // =========================
    // UPDATE (Proses + Validasi)
    // =========================
    public function UpdateBatu($id_batu)
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

        $this->batu->update($id_batu, [
            'jenis_batu' => $this->request->getPost('jenis_batu'),
            'id_kelas'   => $this->request->getPost('id_kelas'),
        ]);

        return redirect()->to('/batu')
            ->with('success', 'Data batu berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function HapusBatu($id_batu)
    {
        $this->batu->delete($id_batu);

        return redirect()->to('/batu')
            ->with('success', 'Data batu berhasil dihapus');
    }
}
