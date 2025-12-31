<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTPenilaian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penilaian' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_detail_pendaftaran' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_batu' => [
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
            'nilai_input' => [
                'type'       => 'FLOAT',
                'constraint' => '5,2',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_penilaian', true);

        // Cegah juri menilai sub kriteria yang sama dua kali
        $this->forge->addUniqueKey([
            'id_detail_pendaftaran',
            'id_user',
            'id_sub'
        ]);

        $this->forge->createTable('t_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('t_penilaian');
    }
}
