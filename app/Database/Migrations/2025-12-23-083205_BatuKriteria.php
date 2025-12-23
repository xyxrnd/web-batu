<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BatuKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_batu_kriteria' => [
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
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id_batu_kriteria', true);
        $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria', 't_kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_batu_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_batu_kriteria');
    }
}
