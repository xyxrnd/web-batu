<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UbahBobotKeDecimal extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('t_bobot', [
            'bobot' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,6',
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('t_bobot', [
            'bobot' => [
                'type' => 'INT',
                'null' => false,
            ],
        ]);
    }
}
