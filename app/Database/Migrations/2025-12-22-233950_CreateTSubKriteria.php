<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTSubKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sub_kriteria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_kriteria' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_sub_kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'nilai' => [
                'type'       => 'DOUBLE',
                'null'       => true,
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

        $this->forge->addKey('id_sub_kriteria', true);

        // Foreign Key ke t_kriteria
        $this->forge->addForeignKey(
            'id_kriteria',
            't_kriteria',
            'id_kriteria',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('t_sub_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_sub_kriteria');
    }
}
