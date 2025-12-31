<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTBobotKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bobot_kriteria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
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
            'bobot' => [
                'type'       => 'DOUBLE',
                'null'       => false,
            ],
            'persen' => [
                'type'       => 'DOUBLE',
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // ===============================
        // PRIMARY KEY
        // ===============================
        $this->forge->addKey('id_bobot_kriteria', true);

        // ===============================
        // INDEX (PERFORMA & KONSISTENSI)
        // ===============================
        $this->forge->addKey(['id_batu', 'id_kriteria'], false, true);
        // unique: 1 batu + 1 kriteria = 1 baris hasil

        $this->forge->addKey('id_kriteria');

        $this->forge->createTable('t_bobot_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_bobot_kriteria');
    }
}
