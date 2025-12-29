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
            'id_sub' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai' => [
                'type'       => 'FLOAT',
                'constraint' => '10,4',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_penilaian', true);

        // ❗ Penting: 1 user hanya boleh menilai 1 sub untuk 1 batu
        $this->forge->addUniqueKey([
            'id_detail_pendaftaran',
            'id_sub',
            'id_user'
        ], 'unique_penilaian');

        $this->forge->createTable('t_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('t_penilaian');
    }
}
