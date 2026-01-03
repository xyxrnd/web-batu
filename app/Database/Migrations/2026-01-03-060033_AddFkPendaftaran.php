<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkPendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_user', 't_user', 'id_user');
        $this->forge->processIndexes('t_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_pendaftaran', 't_pendaftaran_id_user_foreign');
    }
}
