<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BatuModels;
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
    protected $batu;

    public function __construct()
    {
        $this->penilaian          = new PenilaianModel();
        $this->bobotKriteria     = new BobotKriteriaModel();
        $this->bobotSub          = new BobotSubModel();
        $this->detailPendaftaran = new DetailPendaftaranModels();
        $this->batu              = new BatuModels();
    }

    /**
     * HALAMAN LIST PENILAIAN
     */
    public function index()
    {
        $kelasList = $this->penilaian->getKelasPenilaian();
        $dataKelas = [];

        foreach ($kelasList as $kelas) {
            $dataKelas[$kelas['id_kelas']] = [
                'nama_kelas' => $kelas['kelas'],
                'batu'       => $this->penilaian
                    ->getBatuPenilaianByKelas($kelas['id_kelas'])
            ];
        }

        return view('PenilaianBatu', [
            'dataKelas' => $dataKelas
        ]);
    }

    /**
     * FORM PENILAIAN + TAMPIL NILAI
     */
    public function nilaiBatu($id_batu)
    {
        $id_user = session()->get('id_user');

        // 1. Data batu
        $batu = $this->batu->getBatuById($id_batu);

        // 2. Kriteria + Sub + Bobot Global
        $kriteria = $this->bobotKriteria->getKriteriaByBatu($id_batu);

        foreach ($kriteria as &$k) {
            $bobot_kriteria = (float) $k['bobot'];

            $sub = $this->bobotSub->getSubByKriteria(
                $id_batu,
                $k['id_kriteria']
            );

            foreach ($sub as &$s) {
                $s['bobot_global']  = $bobot_kriteria * (float) $s['bobot'];
                $s['persen_global'] = $s['bobot_global'] * 100;
            }
            unset($s);

            $k['sub']    = $sub;
            $k['persen'] = $k['bobot'] * 100;
        }
        unset($k);

        // 3. Peserta
        $detail = $this->detailPendaftaran->getDetailByBatu($id_batu);

        // 4. Ambil nilai dari t_penilaian (KHUSUS USER LOGIN)
        $nilai = $this->penilaian->getNilaiByBatu($id_batu, $id_user);

        return view('FormPenilaian', [
            'id_batu'   => $id_batu,
            'nama_batu' => $batu['jenis_batu'],
            'detail'    => $detail,
            'kriteria'  => $kriteria,
            'nilai'     => $nilai,
            'id_user'   => $id_user,
        ]);
    }

    /**
     * SIMPAN NILAI (SUPPORT KOMA)
     */
    public function simpan()
    {
        $idDetail = (int) $this->request->getPost('simpanId');
        $idBatu   = (int) $this->request->getPost('id_batu');
        $idUser   = (int) session()->get('id_user');

        $nilai = $this->request->getPost('nilai');

        if (!$idDetail || !$idBatu || !$idUser || !isset($nilai[$idDetail])) {
            return redirect()->back()->with('error', 'Data tidak valid');
        }

        // DELETE (AMAN)
        $this->penilaian
            ->builder()
            ->where('id_detail_pendaftaran', $idDetail)
            ->where('id_batu', $idBatu)
            ->where('id_user', $idUser)
            ->delete();

        // RESET BUILDER (PENTING DI CI4)
        $this->penilaian->builder()->resetQuery();

        // SIMPAN NILAI BARU
        foreach ($nilai[$idDetail] as $idKriteria => $subs) {
            foreach ($subs as $idSub => $nilaiInput) {

                if ($nilaiInput === '' || $nilaiInput === null) {
                    continue;
                }

                // ✅ IZINKAN KOMA
                $nilaiInput = str_replace(',', '.', $nilaiInput);

                if (!is_numeric($nilaiInput)) {
                    continue;
                }

                $nilaiInput = (float) $nilaiInput;

                // validasi rentang nilai
                if ($nilaiInput < 0 || $nilaiInput > 100) {
                    continue;
                }

                $data = [
                    'id_detail_pendaftaran' => $idDetail,
                    'id_user'               => $idUser,
                    'id_batu'               => $idBatu,
                    'id_kriteria'           => (int) $idKriteria,
                    'id_sub'                => (int) $idSub,
                    'nilai_input'           => $nilaiInput,
                    'created_at'            => date('Y-m-d H:i:s')
                ];

                // INSERT PALING AMAN
                $this->penilaian
                    ->db
                    ->table('t_penilaian')
                    ->insert($data);
            }
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }
}
