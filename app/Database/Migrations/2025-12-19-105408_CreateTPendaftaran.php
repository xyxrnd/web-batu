<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTPendaftaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pendaftaran' => [
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
            'total_bayar' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'dp' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'status_pembayaran' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Bayar', 'Lunas', 'DP'],
                'default'    => 'Belum Bayar',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_pendaftaran', true);

        // Optional foreign key (aktifkan jika tabelnya sudah ada)
        // $this->forge->addForeignKey('id_user', 't_user', 'id_user', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('id_batu', 't_batu', 'id_batu', 'CASCADE', 'CASCADE');

        $this->forge->createTable('t_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('t_pendaftaran');
    }
}
