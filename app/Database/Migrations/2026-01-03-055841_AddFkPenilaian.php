<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkPenilaian extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_detail_pendaftaran', 't_detail_pendaftaran', 'id_detail_pendaftaran');
        $this->forge->addForeignKey('id_user', 't_user', 'id_user');
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->addForeignKey('id_kriteria', 't_kriteria', 'id_kriteria');
        $this->forge->addForeignKey('id_sub', 't_sub_kriteria', 'id_sub');
        $this->forge->processIndexes('t_penilaian');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_penilaian', 't_penilaian_id_detail_pendaftaran_foreign');
        $this->forge->dropForeignKey('t_penilaian', 't_penilaian_id_user_foreign');
        $this->forge->dropForeignKey('t_penilaian', 't_penilaian_id_batu_foreign');
        $this->forge->dropForeignKey('t_penilaian', 't_penilaian_id_kriteria_foreign');
        $this->forge->dropForeignKey('t_penilaian', 't_penilaian_id_sub_foreign');
    }
}
