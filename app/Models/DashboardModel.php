<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    // ===== TOTAL BATU =====
    public function totalBatuTerdaftar()
    {
        return $this->db->table('t_detail_pendaftaran')
            ->countAllResults();
    }

    public function totalBatuDiterima()
    {
        return $this->db->table('t_detail_pendaftaran')
            ->where('status_pendaftaran', 'diterima')
            ->countAllResults();
    }

    public function totalBatuDitolak()
    {
        return $this->db->table('t_detail_pendaftaran')
            ->where('status_pendaftaran', 'ditolak')
            ->countAllResults();
    }

    // ===== PEMBAYARAN =====
    public function totalPembayaran()
    {
        return $this->db->table('t_pendaftaran')
            ->countAllResults();
    }

    public function totalUangMasuk()
    {
        return $this->db->table('t_pendaftaran')
            ->selectSum('total_bayar')
            ->where('status_pembayaran', 'lunas')
            ->get()->getRow()->total_bayar ?? 0;
    }

    public function totalUangBelumMasuk()
    {
        return $this->db->table('t_pendaftaran')
            ->selectSum('total_bayar')
            ->where('status_pembayaran !=', 'lunas')
            ->get()->getRow()->total_bayar ?? 0;
    }
}
