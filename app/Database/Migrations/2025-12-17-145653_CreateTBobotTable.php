<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTBobotTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bobot' => [
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
                'type' => 'INT',
            ],
        ]);

        $this->forge->addKey('id_bobot', true);

        // Foreign Key
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria', 't_kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');

        $this->forge->createTable('t_bobot');
    }

    public function down()
    {
        $this->forge->dropTable('t_bobot');
    }
}
