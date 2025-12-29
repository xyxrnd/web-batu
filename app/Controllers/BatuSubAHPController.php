<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SubKriteriaModel;
use App\Models\BatuKriteriaModel;
use App\Models\AhpSubModel;
use App\Models\BatuModels;
use App\Models\KriteriaModels;

class BatuSubAHPController extends BaseController
{
    protected $sub;
    protected $bk;
    protected $ahp;
    protected $batu;
    protected $kriteria;

    public function __construct()
    {
        $this->sub      = new SubKriteriaModel();
        $this->bk       = new BatuKriteriaModel();
        $this->ahp      = new AhpSubModel();
        $this->batu     = new BatuModels();
        $this->kriteria = new KriteriaModels();
    }

    // ============================
    // FORM AHP SUB KRITERIA
    // ============================
    public function index($id_batu, $id_kriteria)
    {
        $sub = $this->bk
            ->getSubForAHP($id_batu, $id_kriteria);

        // DEBUG PENTING (sementara)
        // dd($sub);

        $data = [
            'batu'        => $this->batu->find($id_batu),
            'kriteria'    => $this->kriteria->find($id_kriteria),
            'subKriteria' => $sub
        ];

        return view('TambahBobotSub', $data);
    }


    // ============================
    // SIMPAN SUB + AHP
    // ============================
    public function simpan()
    {
        $id_batu     = $this->request->getPost('id_batu');
        $id_kriteria = $this->request->getPost('id_kriteria');
        $subs        = $this->request->getPost('sub');
        $pair        = $this->request->getPost('pair');

        if (count($subs) < 2) {
            return redirect()->back()->with('error', 'Minimal 2 sub kriteria');
        }

        // HAPUS DATA LAMA
        $this->bk
            ->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->delete();

        $this->ahp
            ->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->delete();

        // SIMPAN RELASI BATU - SUB
        foreach ($subs as $id_sub) {
            $this->bk->insert([
                'id_batu'       => $id_batu,
                'id_kriteria'   => $id_kriteria,
                'id_sub_kriteria' => $id_sub
            ]);
        }

        // SIMPAN AHP
        foreach ($pair as $id1 => $rows) {
            foreach ($rows as $id2 => $nilai) {
                $this->ahp->insert([
                    'id_batu'     => $id_batu,
                    'id_kriteria' => $id_kriteria,
                    'id_sub_1'    => $id1,
                    'id_sub_2'    => $id2,
                    'nilai'       => $nilai
                ]);
            }
        }

        return redirect()->back()->with('success', 'Bobot sub kriteria berhasil disimpan');
    }
}
