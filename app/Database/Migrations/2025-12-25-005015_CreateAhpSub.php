<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAhpSub extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ahp_sub' => [
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
            'id_sub1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_sub2' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
        ]);

        $this->forge->addKey('id_ahp_sub', true);
        $this->forge->addKey(['id_batu', 'id_kriteria'], false);
        $this->forge->createTable('t_ahp_sub');
    }

    public function down()
    {
        $this->forge->dropTable('t_ahp_sub');
    }
}
