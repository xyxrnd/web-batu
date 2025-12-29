<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PenilaianModel;
use App\Models\SubKriteriaModel;

class PenilaianController extends BaseController
{
    protected $penilaian;
    protected $sub;

    public function __construct()
    {
        $this->penilaian = new PenilaianModel();
        $this->sub       = new SubKriteriaModel();
    }

    /**
     * FORM PENILAIAN
     */
    public function form($id_detail_pendaftaran)
    {
        return view('FormPenilaian', [
            'subs' => $this->sub->findAll(),
            'id_detail_pendaftaran' => $id_detail_pendaftaran
        ]);
    }

    /**
     * SIMPAN NILAI
     */
    public function simpan()
    {
        $data = [
            'id_detail_pendaftaran' => $this->request->getPost('id_detail_pendaftaran'),
            'id_sub'                => $this->request->getPost('id_sub'),
            'id_user'               => session()->get('id_user'),
            'nilai'                 => $this->request->getPost('nilai'),
        ];

        // replace jika sudah pernah menilai
        $this->penilaian
            ->where([
                'id_detail_pendaftaran' => $data['id_detail_pendaftaran'],
                'id_sub' => $data['id_sub'],
                'id_user' => $data['id_user'],
            ])
            ->delete();

        $this->penilaian->insert($data);

        return redirect()->back()->with('success', 'Nilai berhasil disimpan');
    }
}
