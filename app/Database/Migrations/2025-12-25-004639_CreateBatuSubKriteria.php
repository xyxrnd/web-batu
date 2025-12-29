<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBatuSubKriteria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_batu_sub' => [
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
            'id_sub' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('id_batu_sub', true);
        $this->forge->addKey(['id_batu', 'id_kriteria', 'id_sub'], false);
        $this->forge->createTable('t_batu_sub_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_batu_sub_kriteria');
    }
}
