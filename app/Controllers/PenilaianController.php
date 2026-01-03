<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BatuModels;
use App\Models\PenilaianModel;
use App\Models\BobotKriteriaModel;
use App\Models\BobotSubModel;
use App\Models\DetailPendaftaranModels;
use App\Models\KriteriaModels;
use App\Models\NilaiAkhirModel;

class PenilaianController extends BaseController
{
    protected $penilaian;
    protected $bobotKriteria;
    protected $bobotSub;
    protected $detailPendaftaran;
    protected $batu;
    protected $nilaiAkhir;
    protected $kriteria;

    public function __construct()
    {
        $this->penilaian          = new PenilaianModel();
        $this->bobotKriteria     = new BobotKriteriaModel();
        $this->bobotSub          = new BobotSubModel();
        $this->detailPendaftaran = new DetailPendaftaranModels();
        $this->batu              = new BatuModels();
        $this->nilaiAkhir              = new NilaiAkhirModel();
        $this->kriteria              = new KriteriaModels();
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


    public function publish()
    {
        $idBatu = $this->request->getPost('id_batu');

        if (!$idBatu) {
            return redirect()->back()->with('error', 'ID batu tidak valid');
        }

        /* =====================================================
     * 1. AMBIL RATA-RATA NILAI JURI PER SUB KRITERIA
     * ===================================================== */
        $nilaiSK = $this->penilaian->getRataNilaiPerSK($idBatu);
        /*
        hasil contoh:
        [
            id_detail_pendaftaran,
            id_sub,
            rata_nilai
        ]
    */

        if (empty($nilaiSK)) {
            return redirect()->back()->with('error', 'Belum ada penilaian juri');
        }

        /* =====================================================
     * 2. AMBIL BOBOT GLOBAL SUB KRITERIA
     * ===================================================== */
        $kriteria = $this->kriteria->getKriteriaDenganSub();

        $bobotGlobal = [];
        foreach ($kriteria as $k) {
            foreach ($k['sub'] as $s) {
                $bobotGlobal[$s['id_sub']] =
                    ($k['persen_kriteria'] / 100) *
                    ($s['persen_sub'] / 100);
            }
        }

        /* =====================================================
     * 3. HITUNG NILAI AKHIR PER PESERTA
     * ===================================================== */
        $hasilAkhir = [];

        foreach ($nilaiSK as $row) {

            $idDetail = $row['id_detail_pendaftaran'];
            $idSub    = $row['id_sub'];

            if (!isset($bobotGlobal[$idSub])) {
                continue;
            }

            $nilaiTerbobot = $row['rata_nilai'] * $bobotGlobal[$idSub];

            $hasilAkhir[$idDetail] =
                ($hasilAkhir[$idDetail] ?? 0) + $nilaiTerbobot;
        }

        if (empty($hasilAkhir)) {
            return redirect()->back()->with('error', 'Gagal menghitung nilai akhir');
        }

        /* =====================================================
     * 4. URUTKAN & TENTUKAN PERINGKAT
     * ===================================================== */
        arsort($hasilAkhir);

        /* =====================================================
     * 5. HAPUS HASIL LAMA (REKAP ULANG TOTAL)
     * ===================================================== */
        $this->nilaiAkhir
            ->where('id_batu', $idBatu)
            ->delete();

        /* =====================================================
     * 6. SIMPAN HASIL BARU
     * ===================================================== */
        $rank = 1;
        foreach ($hasilAkhir as $idDetail => $nilai) {

            $this->nilaiAkhir->insert([
                'id_detail_pendaftaran' => $idDetail,
                'id_batu'               => $idBatu,
                'total_nilai'           => round($nilai, 4),
                'peringkat'             => $rank,
                'created_at'            => date('Y-m-d H:i:s')
            ]);

            $rank++;
        }

        return redirect()->back()
            ->with('success', 'Nilai akhir berhasil dipublish (rekap semua juri)');
    }


    // public function publish()
    // {
    //     $idBatu = $this->request->getPost('id_batu');

    //     $dataRata = $this->penilaian->getRataNilaiSub($idBatu);
    //     if (empty($dataRata)) {
    //         return redirect()->back()->with('error', 'Nilai belum lengkap');
    //     }

    //     $bobotKriteria = $this->bobotKriteria->getBobotKriteria($idBatu);
    //     $bobotSub      = $this->bobotSub->getBobotSub($idBatu);

    //     $this->nilaiAkhir->publishNilai(
    //         $idBatu,
    //         $dataRata,
    //         $bobotKriteria,
    //         $bobotSub
    //     );

    //     return redirect()->to(site_url('penilaian'))
    //         ->with('success', 'Nilai akhir berhasil dipublish');
    // }
}
