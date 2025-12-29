<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTNilaiAkhir extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_nilai_akhir' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_detail_pendaftaran' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nilai_akhir' => [
                'type'       => 'FLOAT',
                'constraint' => '10,6',
            ],
            'rangking' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'generated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_nilai_akhir', true);

        // ❗ 1 batu (detail pendaftaran) hanya punya 1 nilai akhir
        $this->forge->addUniqueKey(
            'id_detail_pendaftaran',
            'unique_nilai_akhir'
        );

        $this->forge->createTable('t_nilai_akhir');
    }

    public function down()
    {
        $this->forge->dropTable('t_nilai_akhir');
    }
}
