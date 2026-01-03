<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkAhpInput extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_user', 't_user', 'id_user');
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->addForeignKey('id_kriteria_1', 't_kriteria', 'id_kriteria');
        $this->forge->addForeignKey('id_kriteria_2', 't_kriteria', 'id_kriteria');
        $this->forge->processIndexes('t_ahp_input');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_ahp_input', 't_ahp_input_id_user_foreign');
        $this->forge->dropForeignKey('t_ahp_input', 't_ahp_input_id_batu_foreign');
        $this->forge->dropForeignKey('t_ahp_input', 't_ahp_input_id_kriteria_1_foreign');
        $this->forge->dropForeignKey('t_ahp_input', 't_ahp_input_id_kriteria_2_foreign');
    }
}
