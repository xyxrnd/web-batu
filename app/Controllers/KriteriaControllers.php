<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KriteriaModels;
use App\Models\BatuModels;

class KriteriaControllers extends BaseController
{
    protected $kriteria;
    protected $batu;

    public function __construct()
    {
        $this->kriteria = new KriteriaModels();
        $this->batu = new BatuModels();
    }

    // =========================
    // READ
    // =========================
    public function DaftarKriteria()
    {
        $data['kriteria'] = $this->kriteria->findAll();
        return view('PanitiaKriteria', $data);
    }

    // =========================
    // CREATE (Form)
    // =========================
    public function TambahKriteria()
    {
        return view('TambahKriteria');
    }

    // =========================
    // CREATE (Simpan + Validasi)
    // =========================
    public function SimpanKriteria()
    {
        $rules = [
            'kriteria' => 'required|min_length[3]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kriteria->insert([
            'kriteria' => $this->request->getPost('kriteria')
        ]);

        return redirect()->to('/kriteria')
            ->with('success', 'Data kriteria berhasil ditambahkan');
    }

    // =========================
    // UPDATE (Form Edit)
    // =========================
    public function EditKriteria($id_kriteria)
    {
        $data['kriteria'] = $this->kriteria->find($id_kriteria);
        return view('EditKriteria', $data);
    }

    // =========================
    // UPDATE (Proses + Validasi)
    // =========================
    public function UpdateKriteria($id_kriteria)
    {
        $rules = [
            'kriteria' => 'required|min_length[3]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->kriteria->update($id_kriteria, [
            'kriteria' => $this->request->getPost('kriteria')
        ]);

        return redirect()->to('/kriteria')
            ->with('success', 'Data kriteria berhasil diupdate');
    }

    // =========================
    // DELETE
    // =========================
    public function HapusKriteria($id_kriteria)
    {
        $this->kriteria->delete($id_kriteria);

        return redirect()->to('/kriteria')
            ->with('success', 'Data kriteria berhasil dihapus');
    }

    public function bobotAHP()
    {
        $data = [
            'batu'     => $this->batu->findAll(),
            'kriteria' => $this->kriteria->findAll()
        ];

        return view('TambahBobot', $data);
    }

    public function simpanBobot()
    {
        $id_batu   = $this->request->getPost('id_batu');
        $kriteria  = $this->request->getPost('kriteria'); // array id_kriteria
        $pair      = $this->request->getPost('pair');

        $n = count($kriteria);

        if ($n < 2) {
            return redirect()->back()->with('error', 'Minimal 2 kriteria');
        }

        // 1. Matriks awal
        $matrix = [];

        foreach ($kriteria as $i) {
            foreach ($kriteria as $j) {
                if ($i == $j) {
                    $matrix[$i][$j] = 1;
                } elseif (isset($pair[$i][$j])) {
                    $matrix[$i][$j] = $pair[$i][$j];
                    $matrix[$j][$i] = 1 / $pair[$i][$j];
                }
            }
        }

        // 2. Normalisasi
        $colSum = [];
        foreach ($kriteria as $j) {
            $colSum[$j] = array_sum(array_column($matrix, $j));
        }

        $norm = [];
        foreach ($kriteria as $i) {
            foreach ($kriteria as $j) {
                $norm[$i][$j] = $matrix[$i][$j] / $colSum[$j];
            }
        }

        // 3. Bobot prioritas
        $bobot = [];
        foreach ($kriteria as $i) {
            $bobot[$i] = array_sum($norm[$i]) / $n;
        }

        // 4. Hitung λ max
        $lambda = 0;
        foreach ($kriteria as $i) {
            $rowSum = 0;
            foreach ($kriteria as $j) {
                $rowSum += $matrix[$i][$j] * $bobot[$j];
            }
            $lambda += $rowSum / $bobot[$i];
        }
        $lambda /= $n;

        // 5. CI & CR
        $CI = ($lambda - $n) / ($n - 1);

        $RI = [0, 0, 0.58, 0.9, 1.12, 1.24, 1.32, 1.41, 1.45];
        $CR = $CI / $RI[$n];

        if ($CR > 0.1) {
            return redirect()->back()
                ->with('error', 'Perbandingan tidak konsisten (CR = ' . round($CR, 3) . ')');
        }

        // 6. Simpan ke database
        $bobotModel = new \App\Models\BobotModels();

        foreach ($bobot as $id_kriteria => $nilai) {
            $bobotModel->insert([
                'id_batu'     => $id_batu,
                'id_kriteria' => $id_kriteria,
                'bobot'       => $nilai
            ]);
        }

        return redirect()->to('/kriteria')
            ->with('success', 'Bobot berhasil disimpan (CR = ' . round($CR, 3) . ')');
    }
}
