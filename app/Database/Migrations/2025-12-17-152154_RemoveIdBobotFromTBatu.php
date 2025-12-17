<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveIdBobotFromTBatu extends Migration
{
    public function up()
    {
        // Hapus kolom id_bobot
        $this->forge->dropColumn('t_batu', 'id_bobot');
    }

    public function down()
    {
        // Kembalikan kolom id_bobot jika rollback
        $this->forge->addColumn('t_batu', [
            'id_bobot' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
        ]);
    }
}
