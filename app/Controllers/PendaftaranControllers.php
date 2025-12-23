<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendaftaranModels;
use App\Models\BatuModels;
use App\Models\DetailPendaftaranModel;
use App\Models\DetailPendaftaranModels;

class PendaftaranControllers extends BaseController
{
    protected $pendaftaran;
    protected $batu;
    protected $detail;

    public function __construct()
    {
        $this->pendaftaran = new PendaftaranModels();
        $this->batu = new BatuModels();
        $this->detail = new DetailPendaftaranModels();
    }

    public function index()
    {
        return view('PanitiaPendaftaran', [
            'pendaftaran' => $this->pendaftaran->getIndex()
        ]);
    }



    public function create()
    {
        return view('TambahPendaftaran', [
            'batu' => $this->batu->findAll()
        ]);
    }


    public function store()
    {
        $idUser = session()->get('id_user');

        $idBatu     = $this->request->getPost('id_batu');
        $jumlahBatu = $this->request->getPost('jumlah_batu');

        if (!$idBatu || !$jumlahBatu) {
            return redirect()->back()->with('error', 'Batu belum dipilih');
        }

        $totalBatu  = array_sum($jumlahBatu);
        $totalBayar = $totalBatu * 100000;

        $idPendaftaran = $this->pendaftaran->insert([
            'id_user'           => $idUser,
            'total_bayar'       => $totalBayar,
            'dp'                => null,
            'status_pembayaran' => 'Belum Bayar',
            'created_at'        => date('Y-m-d H:i:s')
        ], true);

        // =========================
        // INSERT DETAIL + NOMOR BATU
        // =========================
        foreach ($idBatu as $index => $batu) {
            for ($i = 0; $i < $jumlahBatu[$index]; $i++) {

                $nomorBatu = $this->detail->getNextNomorBatu($batu);

                $this->detail->insert([
                    'id_pendaftaran'     => $idPendaftaran,
                    'id_batu'            => $batu,
                    'nomor_batu'         => $nomorBatu,
                    'status_pendaftaran' => 'Pengecekan'
                ]);
            }
        }

        return redirect()->to('/pendaftaran')
            ->with('success', 'Pendaftaran berhasil disimpan');
    }






    public function edit($id)
    {
        $data['pendaftaran'] = $this->pendaftaran->find($id);
        return view('pendaftaran/edit', $data);
    }

    public function update($id)
    {
        $data = $this->pendaftaran->find($id);

        $statusBaru = $this->request->getPost('status_pendaftaran');

        $updateData = [
            'jumlah_batu'        => $this->request->getPost('jumlah_batu'),
            'total_bayar'        => $this->request->getPost('total_bayar'),
            'catatan'            => $this->request->getPost('catatan'),
            'status_pembayaran'  => $this->request->getPost('status_pembayaran'),
            'status_pendaftaran' => $statusBaru,
        ];

        // 🔥 JIKA BARU DITERIMA & BELUM PUNYA NOMOR
        if ($statusBaru === 'Diterima' && empty($data['nomor_batu'])) {

            $last = $this->pendaftaran->getLastNomorBatu($data['id_batu']);
            $updateData['nomor_batu'] = ($last['nomor_batu'] ?? 0) + 1;
        }

        $this->pendaftaran->update($id, $updateData);

        return redirect()->to('/pendaftaran')
            ->with('success', 'Data berhasil diupdate');
    }


    public function delete($id)
    {
        $this->pendaftaran->delete($id);
        return redirect()->to('/pendaftaran')->with('success', 'Data berhasil dihapus');
    }


    public function detail($id_user)
    {
        $user = $this->pendaftaran->getNamaUser($id_user);

        $data = [
            'nama' => $user->nama,
            'pendaftaran' => $this->pendaftaran->getDetail($id_user)
        ];

        return view('DetailPendaftaran', $data);
    }

    public function terima($id_detail)
    {
        $this->detail->update($id_detail, [
            'status_pendaftaran' => 'Diterima'
        ]);

        return redirect()->back()
            ->with('success', 'Status batu diterima');
    }

    public function prosesKeuangan()
    {
        $id = $this->request->getPost('id_pendaftaran');
        $status = $this->request->getPost('status_pembayaran');
        $dp = $this->request->getPost('dp') ?? 0;

        $this->pendaftaran->update($id, [
            'status_pembayaran' => $status,
            'dp' => ($status === 'DP') ? $dp : 0
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui');
    }
}
