<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkBobotKriteria extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->addForeignKey('id_kriteria', 't_kriteria', 'id_kriteria');
        $this->forge->processIndexes('t_bobot_kriteria');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_bobot_kriteria', 't_bobot_kriteria_id_batu_foreign');
        $this->forge->dropForeignKey('t_bobot_kriteria', 't_bobot_kriteria_id_kriteria_foreign');
    }
}
