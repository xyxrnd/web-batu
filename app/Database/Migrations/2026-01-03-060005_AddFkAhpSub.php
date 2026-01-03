<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFkAhpSub extends Migration
{
    public function up()
    {
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu');
        $this->forge->addForeignKey('id_kriteria', 't_kriteria', 'id_kriteria');
        $this->forge->addForeignKey('id_user', 't_user', 'id_user');
        $this->forge->addForeignKey('id_sub1', 't_sub_kriteria', 'id_sub');
        $this->forge->addForeignKey('id_sub2', 't_sub_kriteria', 'id_sub');
        $this->forge->processIndexes('t_ahp_sub');
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_ahp_sub', 't_ahp_sub_id_batu_foreign');
        $this->forge->dropForeignKey('t_ahp_sub', 't_ahp_sub_id_kriteria_foreign');
        $this->forge->dropForeignKey('t_ahp_sub', 't_ahp_sub_id_user_foreign');
        $this->forge->dropForeignKey('t_ahp_sub', 't_ahp_sub_id_sub1_foreign');
        $this->forge->dropForeignKey('t_ahp_sub', 't_ahp_sub_id_sub2_foreign');
    }
}
