<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToTUser extends Migration
{
    public function up()
    {
        $fields = [
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['Panitia', 'Peserta', 'Juri'],
                'after'      => 'password'
            ],
        ];

        $this->forge->addColumn('t_user', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('t_user', 'role');
    }
}
