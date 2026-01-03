<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkNilaiAkhir extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_detail_pendaftaran', 't_detail_pendaftaran', 'id_detail_pendaftaran');
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->processIndexes('t_nilai_akhir');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_nilai_akhir', 't_nilai_akhir_id_detail_pendaftaran_foreign');
        $this->forge->dropForeignKey('t_nilai_akhir', 't_nilai_akhir_id_batu_foreign');
    }
}
