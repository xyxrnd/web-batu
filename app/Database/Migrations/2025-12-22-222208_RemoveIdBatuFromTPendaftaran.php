<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveIdBatuFromTPendaftaran extends Migration
{
    public function up()
    {
        // Pastikan kolom ada sebelum dihapus
        if ($this->db->fieldExists('id_batu', 't_pendaftaran')) {
            $this->forge->dropColumn('t_pendaftaran', 'id_batu');
        }
    }

    public function down()
    {
        // Kembalikan kolom id_batu jika rollback
        $this->forge->addColumn('t_pendaftaran', [
            'id_batu' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }
}
