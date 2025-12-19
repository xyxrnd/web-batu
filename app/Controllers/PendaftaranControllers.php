<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PendaftaranModels;
use App\Models\BatuModels;

class PendaftaranControllers extends BaseController
{
    protected $pendaftaran;
    protected $batu;

    public function __construct()
    {
        $this->pendaftaran = new PendaftaranModels();
        $this->batu = new BatuModels();
    }

    public function index()
    {
        $data['pendaftaran'] = $this->pendaftaran->getPendaftaranIndex();
        return view('PanitiaPendaftaran', $data);
    }


    public function create()
    {
        return view('TambahPendaftaran', [
            'batu' => $this->batu->findAll()
        ]);
    }

    public function store()
    {
        $idBatu = $this->request->getPost('id_batu');
        $jumlah = $this->request->getPost('jumlah_batu');

        if (!$idBatu || !$jumlah) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['Minimal 1 batu harus dipilih']);
        }

        foreach ($idBatu as $index => $batu) {
            $this->pendaftaran->insert([
                'id_user'            => session()->get('id_user'),
                'id_batu'            => $batu,
                'jumlah_batu'        => $jumlah[$index],
                'status_pembayaran'  => 'Belum Bayar',
                'status_pendaftaran' => 'Diterima'
            ]);
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
        $rules = [
            'jumlah_batu' => 'required|integer|greater_than[0]',
            'total_bayar' => 'required|decimal',
            'status_pembayaran' => 'required|in_list[Belum Bayar,DP,Lunas]',
            'status_pendaftaran' => 'permit_empty|in_list[Diterima,Ditolak]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        $this->pendaftaran->update($id, [
            'jumlah_batu'        => $this->request->getPost('jumlah_batu'),
            'total_bayar'        => $this->request->getPost('total_bayar'),
            'catatan'            => $this->request->getPost('catatan'),
            'status_pembayaran'  => $this->request->getPost('status_pembayaran'),
            'status_pendaftaran' => $this->request->getPost('status_pendaftaran'),
        ]);

        return redirect()->to('/pendaftaran')->with('success', 'Data berhasil diupdate');
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
}
