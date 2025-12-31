<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BatuModels;
use App\Models\KriteriaModels;
use App\Models\SubKriteriaModel;
use App\Models\AhpSubModel;
use App\Models\BobotSubModel;

class AhpSubController extends BaseController
{
    protected $batu;
    protected $kriteria;
    protected $sub;
    protected $ahpSub;
    protected $bobotSub;

    public function __construct()
    {
        $this->batu     = new BatuModels();
        $this->kriteria = new KriteriaModels();
        $this->sub      = new SubKriteriaModel();
        $this->ahpSub   = new AhpSubModel();
        $this->bobotSub   = new BobotSubModel();
    }

    // ===============================
    // FORM INPUT SUB KRITERIA AHP
    // ===============================
    public function tambahBobot()
    {
        return view('TambahBobotSub', [
            'batu'     => $this->batu->findAll(),
            'kriteria' => $this->kriteria->findAll(),
            'sub' => $this->sub->findAll()
        ]);
    }


    public function kriteriaByBatu($id_batu)
    {
        $data = $this->kriteria
            ->select('t_kriteria.id_kriteria, t_kriteria.kriteria')
            ->join(
                't_batu_kriteria',
                't_batu_kriteria.id_kriteria = t_kriteria.id_kriteria'
            )
            ->where('t_batu_kriteria.id_batu', $id_batu)
            ->groupBy('t_kriteria.id_kriteria')
            ->findAll();

        return $this->response->setJSON($data);
    }

    public function simpanBobot()
    {
        $id_user     = session()->get('id_user');
        $id_batu     = $this->request->getPost('id_batu');
        $id_kriteria = $this->request->getPost('id_kriteria');
        $pairs       = $this->request->getPost('pair');

        if (!$pairs || !$id_batu || !$id_kriteria) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak lengkap');
        }

        // ===============================
        // CEGAH INPUT GANDA (per user)
        // ===============================
        $cek = $this->ahpSub
            ->where('id_user', $id_user)
            ->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->countAllResults();

        if ($cek) {
            return redirect()->back()
                ->with('error', 'Anda sudah mengisi penilaian');
        }

        // ===============================
        // 1. AMBIL ID SUB KRITERIA
        // ===============================
        $ids = [];
        foreach ($pairs as $i => $row) {
            $ids[] = $i;
            foreach ($row as $j => $v) {
                $ids[] = $j;
            }
        }
        $ids = array_unique($ids);
        sort($ids);
        $n = count($ids);

        if ($n < 2) {
            return redirect()->back()
                ->with('error', 'Minimal 2 Sub Kriteria');
        }

        // ===============================
        // 2. MATRIX USER (UNTUK CR)
        // ===============================
        $matrix = [];
        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $matrix[$i][$j] = ($i == $j) ? 1 : 0;
            }
        }

        foreach ($pairs as $i => $row) {
            foreach ($row as $j => $nilai) {
                $matrix[$i][$j] = $nilai;
                $matrix[$j][$i] = 1 / $nilai;
            }
        }

        // ===============================
        // 3. NORMALISASI & CR (USER)
        // ===============================
        $colSum = [];
        foreach ($ids as $j) {
            $colSum[$j] = 0;
            foreach ($ids as $i) {
                $colSum[$j] += $matrix[$i][$j];
            }
        }

        $norm = [];
        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $norm[$i][$j] = $matrix[$i][$j] / $colSum[$j];
            }
        }

        $bobotUser = [];
        foreach ($ids as $i) {
            $bobotUser[$i] = array_sum($norm[$i]) / $n;
        }

        $lambda = 0;
        foreach ($ids as $i) {
            $sum = 0;
            foreach ($ids as $j) {
                $sum += $matrix[$i][$j] * $bobotUser[$j];
            }
            $lambda += $sum / $bobotUser[$i];
        }
        $lambda /= $n;

        $CI = ($lambda - $n) / ($n - 1);
        $RI = [1 => 0, 2 => 0, 3 => 0.58, 4 => 0.9, 5 => 1.12, 6 => 1.24, 7 => 1.32, 8 => 1.41, 9 => 1.45];
        $CR = ($RI[$n] == 0) ? 0 : $CI / $RI[$n];

        if ($CR > 0.1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Penilaian tidak konsisten (CR = ' . round($CR, 3) . ')');
        }

        // ===============================
        // 4. SIMPAN INPUT USER
        // ===============================
        foreach ($pairs as $i => $row) {
            foreach ($row as $j => $nilai) {
                $this->ahpSub->insert([
                    'id_user'     => $id_user,
                    'id_batu'     => $id_batu,
                    'id_kriteria' => $id_kriteria,
                    'id_sub1'     => $i,
                    'id_sub2'     => $j,
                    'nilai'       => $nilai
                ]);
            }
        }

        // ===============================
        // 5. GROUP AHP (SEMUA USER)
        // ===============================
        $data = $this->ahpSub
            ->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->findAll();

        $matrixGroup = [];
        foreach ($ids as $i) {
            foreach ($ids as $j) {
                $matrixGroup[$i][$j] = 1;
            }
        }

        $pairValues = [];
        foreach ($data as $d) {
            $pairValues[$d['id_sub1']][$d['id_sub2']][] = $d['nilai'];
        }

        foreach ($pairValues as $i => $rows) {
            foreach ($rows as $j => $values) {
                $gm = pow(array_product($values), 1 / count($values));
                $matrixGroup[$i][$j] = $gm;
                $matrixGroup[$j][$i] = 1 / $gm;
            }
        }

        // ===============================
        // 6. NORMALISASI GROUP
        // ===============================
        $colSum = [];
        foreach ($ids as $j) {
            $colSum[$j] = 0;
            foreach ($ids as $i) {
                $colSum[$j] += $matrixGroup[$i][$j];
            }
        }

        $bobotFinal = [];
        foreach ($ids as $i) {
            $sum = 0;
            foreach ($ids as $j) {
                $sum += $matrixGroup[$i][$j] / $colSum[$j];
            }
            $bobotFinal[$i] = $sum / $n;
        }

        // ===============================
        // 7. SIMPAN HASIL AKHIR
        // ===============================
        $this->bobotSub
            ->where('id_batu', $id_batu)
            ->where('id_kriteria', $id_kriteria)
            ->delete();

        foreach ($bobotFinal as $id_sub => $nilai) {
            $this->bobotSub->insert([
                'id_batu'         => $id_batu,
                'id_kriteria'     => $id_kriteria,
                'id_sub_kriteria' => $id_sub,
                'bobot'           => $nilai,
                'persen'      => round($nilai * 100, 2),
            ]);
        }

        return redirect()->to('/sub-kriteria')
            ->with('success', 'Penilaian & bobot akhir berhasil disimpan');
    }

    public function hasilBobot($id_batu, $id_kriteria)
    {
        return view('HasilBobotSubKriteria', [
            'id_batu'  => $id_batu,
            'hasil'    => $this->bobotSub->getHasilByBatuKriteria($id_batu, $id_kriteria),
            'kriteria' => $this->kriteria->find($id_kriteria)
        ]);
    }

    public function detailBobot($id_batu, $id_sub)
    {
        return view('DetailBobotSub', [
            'detail' => $this->ahpSub->getDetailBobotSub($id_batu, $id_sub),
            'total'  => $this->ahpSub->getTotalNilaiSub($id_batu, $id_sub),
            'sub'    => $this->sub->find($id_sub),
            'batu'   => $this->batu->find($id_batu)
        ]);
    }
}
