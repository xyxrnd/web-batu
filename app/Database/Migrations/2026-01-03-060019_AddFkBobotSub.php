<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkBobotSub extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->addForeignKey('id_kriteria', 't_kriteria', 'id_kriteria');
        $this->forge->addForeignKey('id_sub', 't_sub_kriteria', 'id_sub');
        $this->forge->processIndexes('t_bobot_sub');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_bobot_sub', 't_bobot_sub_id_batu_foreign');
        $this->forge->dropForeignKey('t_bobot_sub', 't_bobot_sub_id_kriteria_foreign');
        $this->forge->dropForeignKey('t_bobot_sub', 't_bobot_sub_id_sub_foreign');
    }
}
