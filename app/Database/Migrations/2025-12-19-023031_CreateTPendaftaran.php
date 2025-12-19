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
            'jumlah_batu' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total_bayar' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_pembayaran' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Bayar', 'Lunas', 'DP'],
                'default'    => 'Belum Bayar',
            ],
            'status_pendaftaran' => [
                'type'       => 'ENUM',
                'constraint' => ['Diterima', 'Ditolak'],
                'null'       => true,
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id_pendaftaran', true);
        $this->forge->createTable('t_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('t_pendaftaran');
    }
}
