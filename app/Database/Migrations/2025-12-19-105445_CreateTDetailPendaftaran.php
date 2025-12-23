<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTDetailPendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_pendaftaran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_pendaftaran' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_batu' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nomor_batu' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status_pendaftaran' => [
                'type'       => 'ENUM',
                'constraint' => ['Pengecekan', 'Diterima', 'Ditolak'],
                'default'    => 'Pengecekan',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_detail_pendaftaran', true);

        // Optional Foreign Key
        // $this->forge->addForeignKey('id_pendaftaran', 't_pendaftaran', 'id_pendaftaran', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu', 'CASCADE', 'CASCADE');

        $this->forge->createTable('t_detail_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('t_detail_pendaftaran');
    }
}
