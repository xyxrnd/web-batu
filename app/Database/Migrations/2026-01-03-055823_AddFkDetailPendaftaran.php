<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkDetailPendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_pendaftaran', 't_pendaftaran', 'id_pendaftaran');
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->processIndexes('t_detail_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_detail_pendaftaran', 't_detail_pendaftaran_id_pendaftaran_foreign');
        $this->forge->dropForeignKey('t_detail_pendaftaran', 't_detail_pendaftaran_id_batu_foreign');
    }
}
