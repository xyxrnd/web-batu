<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTKriteriaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kriteria' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kriteria' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addKey('id_kriteria', true);
        $this->forge->createTable('t_kriteria');
    }

    public function down()
    {
        $this->forge->dropTable('t_kriteria');
    }
}
