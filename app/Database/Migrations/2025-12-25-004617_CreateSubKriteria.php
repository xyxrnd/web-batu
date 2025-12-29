<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sub' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_sub' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
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

        $this->forge->addKey('id_sub', true);
        $this->forge->createTable('t_sub_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_sub_kriteria');
    }
}
