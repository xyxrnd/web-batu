<?php

namespace App\Models;

use CodeIgniter\Model;

class KriteriaModels extends Model
{
    protected $table            = 't_kriteria';
    protected $primaryKey       = 'id_kriteria';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = ['kriteria', 'bobot'];

    public function getByBatuKriteria($id_batu)
    {
        return $this->select('t_kriteria.id_kriteria, t_kriteria.kriteria')
            ->join('t_batu_kriteria', 't_batu_kriteria.id_kriteria = t_kriteria.id_kriteria')
            ->where('t_batu_kriteria.id_batu', $id_batu)
            ->orderBy('t_kriteria.id_kriteria', 'ASC')
            ->findAll();
    }

    public function getKriteriaDenganSub()
    {
        // =========================
        // Kriteria + bobot kriteria
        // =========================
        $kriteria = $this->db->table('t_kriteria k')
            ->select('
            k.id_kriteria,
            k.kriteria,
            bk.persen AS persen_kriteria
        ')
            ->join('t_bobot_kriteria bk', 'bk.id_kriteria = k.id_kriteria')
            ->orderBy('k.id_kriteria')
            ->get()
            ->getResultArray();

        // =========================
        // Sub kriteria + bobot sub
        // =========================
        $sub = $this->db->table('t_sub_kriteria sk')
            ->select('
            sk.id_sub,
            sk.nama_sub,
            bs.id_kriteria,
            bs.persen AS persen_sub
        ')
            ->join('t_bobot_sub bs', 'bs.id_sub = sk.id_sub')
            ->orderBy('sk.id_sub')
            ->get()
            ->getResultArray();

        // =========================
        // Gabungkan + bobot global
        // =========================
        foreach ($kriteria as &$k) {
            $k['sub'] = [];

            foreach ($sub as $s) {
                if ($s['id_kriteria'] == $k['id_kriteria']) {

                    $bobotGlobal =
                        ($k['persen_kriteria'] / 100) *
                        ($s['persen_sub'] / 100);

                    $k['sub'][] = [
                        'id_sub'        => $s['id_sub'],
                        'nama_sub'      => $s['nama_sub'],
                        'persen_sub'    => $s['persen_sub'],
                        'persen_global' => $bobotGlobal * 100
                    ];
                }
            }
        }

        return $kriteria;
    }
}
