<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'no_hp' => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('id_user', true);
        $this->forge->createTable('t_user');
    }

    public function down()
    {
        $this->forge->dropTable('t_user');
    }
}
