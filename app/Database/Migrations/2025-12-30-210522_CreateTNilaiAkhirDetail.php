<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTNilaiAkhirDetail extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_nilai_akhir' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_kriteria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_sub' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai_rata_juri' => [
                'type'       => 'FLOAT',
                'constraint' => '5,2',
            ],
            'bobot_kriteria' => [
                'type'       => 'FLOAT',
                'constraint' => '5,4',
            ],
            'bobot_sub' => [
                'type'       => 'FLOAT',
                'constraint' => '5,4',
            ],
            'nilai_akhir' => [
                'type'       => 'FLOAT',
                'constraint' => '10,4',
            ],
        ]);

        $this->forge->addKey('id_detail', true);

        $this->forge->createTable('t_nilai_akhir_detail');
    }

    public function down()
    {
        $this->forge->dropTable('t_nilai_akhir_detail');
    }
}
