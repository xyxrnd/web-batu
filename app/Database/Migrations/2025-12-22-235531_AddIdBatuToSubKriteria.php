<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdBatuToSubKriteria extends Migration
{
    public function up()
    {
        $this->forge->addColumn('t_sub_kriteria', [
            'id_batu' => [
                'type'       => 'BIGINT',
                'unsigned'   => true,
                'after'      => 'id_sub_kriteria'
            ]
        ]);

        // foreign key ke t_batu
        $this->forge->addForeignKey(
            'id_batu',
            't_batu',
            'id_batu',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        // hapus foreign key dulu
        $this->forge->dropForeignKey('t_sub_kriteria', 't_sub_kriteria_id_batu_foreign');

        // hapus kolom
        $this->forge->dropColumn('t_sub_kriteria', 'id_batu');
    }
}
