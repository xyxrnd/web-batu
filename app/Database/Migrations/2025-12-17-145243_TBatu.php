<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TBatu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_batu' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_batu' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_kelas' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_bobot' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id_batu', true);
        $this->forge->createTable('t_batu');
    }

    public function down()
    {
        $this->forge->dropTable('t_batu');
    }
}
