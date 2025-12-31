<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTBobotSub extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bobot_sub' => [
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
            'id_sub_kriteria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'bobot' => [
                'type' => 'DOUBLE',
            ],
            'persen' => [
                'type' => 'DOUBLE',
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

        $this->forge->addKey('id_bobot_sub', true);

        // OPTIONAL: index untuk performa
        $this->forge->addKey(['id_batu', 'id_kriteria']);
        $this->forge->addKey('id_sub_kriteria');

        $this->forge->createTable('t_bobot_sub');
    }

    public function down()
    {
        $this->forge->dropTable('t_bobot_sub');
    }
}
