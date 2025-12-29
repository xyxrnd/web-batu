<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropIdSubFromTBatuKriteria extends Migration
{
    public function up()
    {
        // Hapus kolom id_sub
        $this->forge->dropColumn('t_batu_kriteria', 'id_sub');
    }

    public function down()
    {
        // Kembalikan kolom id_sub jika rollback
        $this->forge->addColumn('t_batu_kriteria', [
            'id_sub' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}
