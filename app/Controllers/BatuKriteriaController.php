<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BatuModels;
use App\Models\KriteriaModels;
use App\Models\BatuKriteriaModel;
use App\Models\SubKriteriaModel;

class BatuKriteriaController extends BaseController
{
    protected $batu;
    protected $kriteria;
    protected $batuKriteria;
    protected $sub;

    public function __construct()
    {
        $this->batu         = new BatuModels();
        $this->kriteria     = new KriteriaModels();
        $this->batuKriteria = new BatuKriteriaModel();
        $this->sub          = new SubKriteriaModel();
    }

    /* =====================================================
     * INDEX
     * ===================================================== */
    public function index($id_batu)
    {
        $batu = $this->batu->find($id_batu);
        if (!$batu) {
            return redirect()->to('/batu')->with('error', 'Batu tidak ditemukan');
        }

        // AMBIL KRITERIA YANG SUDAH DIPILIH
        $relasi = $this->batuKriteria->getByBatu($id_batu);

        // Group per kriteria
        $kriteria = [];
        $sub_kriteria = [];

        foreach ($relasi as $r) {
            $kriteria[$r['id_kriteria']] = [
                'id_kriteria' => $r['id_kriteria'],
                'kriteria'    => $r['nama_kriteria']
            ];

            $sub_kriteria[$r['id_kriteria']][] = $r;
        }

        return view('PanitiaBatuKriteria', [
            'batu'         => $batu,
            'kriteria'     => $kriteria,      // ⬅️ BUKAN master kriteria
            'sub_kriteria' => $sub_kriteria
        ]);
    }


    /* =====================================================
     * SIMPAN SUB KRITERIA (UPDATE SAJA)
     * ===================================================== */
    public function simpan()
    {
        $id_batu_kriteria = $this->request->getPost('id_batu_kriteria');
        $id_sub           = $this->request->getPost('id_sub_kriteria');

        $this->batuKriteria->update($id_batu_kriteria, [
            'id_sub' => $id_sub
        ]);

        return redirect()->back()
            ->with('success', 'Sub kriteria berhasil disimpan');
    }

    /* =====================================================
     * HAPUS SUB KRITERIA (RESET)
     * ===================================================== */
    public function hapus($id_batu_kriteria)
    {
        $this->batuKriteria->update($id_batu_kriteria, [
            'id_sub_kriteria' => null
        ]);

        return redirect()->back()
            ->with('success', 'Sub kriteria berhasil dihapus');
    }
}
