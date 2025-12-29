<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAhpKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_ahp_kriteria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kriteria_1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'kriteria_2' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
            ],
        ]);

        $this->forge->addKey('id_ahp_kriteria', true);
        $this->forge->createTable('t_ahp_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_ahp_kriteria');
    }
}
