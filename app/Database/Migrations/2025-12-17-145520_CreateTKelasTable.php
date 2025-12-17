<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTKelasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kelas' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kelas' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);

        $this->forge->addKey('id_kelas', true);
        $this->forge->createTable('t_kelas');
    }

    public function down()
    {
        $this->forge->dropTable('t_kelas');
    }
}
