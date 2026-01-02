<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UbahUniqueIndexPenilaian extends Migration
{
    public function up()
    {
        // HAPUS UNIQUE INDEX LAMA
        $this->db->query("
            ALTER TABLE t_penilaian
            DROP INDEX id_detail_pendaftaran_id_user_id_sub
        ");

        // TAMBAH UNIQUE INDEX BARU
        $this->db->query("
            ALTER TABLE t_penilaian
            ADD UNIQUE KEY uniq_penilaian (
                id_detail_pendaftaran,
                id_user,
                id_kriteria,
                id_sub
            )
        ");
    }

    public function down()
    {
        // HAPUS UNIQUE BARU
        $this->db->query("
            ALTER TABLE t_penilaian
            DROP INDEX uniq_penilaian
        ");

        // KEMBALIKAN UNIQUE LAMA
        $this->db->query("
            ALTER TABLE t_penilaian
            ADD UNIQUE KEY id_detail_pendaftaran_id_user_id_sub (
                id_detail_pendaftaran,
                id_user,
                id_sub
            )
        ");
    }
}
