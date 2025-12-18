<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAhpInputTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_input' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_batu' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_kriteria_1' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_kriteria_2' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,3',
                'null'       => false,
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

        $this->forge->addKey('id_input', true);

        // (OPSIONAL tapi DISARANKAN)
        $this->forge->addKey(['id_user']);
        $this->forge->addKey(['id_batu']);
        $this->forge->addKey(['id_kriteria_1']);
        $this->forge->addKey(['id_kriteria_2']);

        // (OPSIONAL) Foreign Key – aktifkan jika tabel sudah siap
        /*
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_batu', 'batu', 'id_batu', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria_1', 'kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_kriteria_2', 'kriteria', 'id_kriteria', 'CASCADE', 'CASCADE');
        */

        $this->forge->createTable('t_ahp_input', true);
    }

    public function down()
    {
        $this->forge->dropTable('t_ahp_input', true);
    }
}
