<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Home extends BaseController
{
    protected $dashboard;

    public function __construct()
    {
        $this->dashboard = new DashboardModel();
    }

    public function PanitiaDashboard()
    {
        return view('PanitiaDashboard', [
            'totalBatu'       => $this->dashboard->totalBatuTerdaftar(),
            'batuDiterima'    => $this->dashboard->totalBatuDiterima(),
            'batuDitolak'     => $this->dashboard->totalBatuDitolak(),
            'totalPembayaran' => $this->dashboard->totalPembayaran(),
            'uangMasuk'       => $this->dashboard->totalUangMasuk(),
            'uangBelumMasuk'  => $this->dashboard->totalUangBelumMasuk(),
        ]);
    }
}
