<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdUserToTSubKriteria extends Migration
{
    public function up()
    {
        $this->forge->addColumn('t_ahp_sub', [
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
                'after'      => 'id_kriteria', // sesuaikan posisi kolom
            ],
        ]);

        // Foreign key (opsional tapi direkomendasikan)
        $this->forge->addForeignKey(
            'id_user',
            't_user',      // nama tabel user
            'id_user',    // primary key di tabel users
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->forge->dropForeignKey('t_ahp_sub', 't_ahp_sub_id_user_foreign');
        $this->forge->dropColumn('t_ahp_sub', 'id_user');
    }
}
