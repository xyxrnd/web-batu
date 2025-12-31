<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenilaianModel;
use App\Models\BobotKriteriaModel;
use App\Models\BobotSubModel;
use App\Models\DetailPendaftaranModels;

class PenilaianController extends BaseController
{
    protected $penilaian;
    protected $bobotKriteria;
    protected $bobotSub;
    protected $detailPendaftaran;

    public function __construct()
    {
        $this->penilaian          = new PenilaianModel();
        $this->bobotKriteria     = new BobotKriteriaModel();
        $this->bobotSub          = new BobotSubModel();
        $this->detailPendaftaran = new DetailPendaftaranModels();
    }

    public function index()
    {
        return view('PenilaianBatu', [
            'dataPenilaian' => $this->penilaian->getIndexPenilaian()
        ]);
    }

    public function nilaiBatu($id_batu)
    {
        // ambil kriteria + bobot
        $kriteria = $this->bobotKriteria->getByBatu($id_batu);

        // susun sub kriteria per kriteria
        foreach ($kriteria as &$k) {
            $k['sub'] = $this->bobotSub->getHasilByBatuKriteria(
                $id_batu,
                $k['id_kriteria']
            );
        }
        unset($k); // best practice PHP reference

        return view('FormPenilaian', [
            'peserta'  => $this->detailPendaftaran->getPesertaByBatu($id_batu),
            'kriteria' => $kriteria,
            'id_batu'  => $id_batu
        ]);
    }
}
