<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBatuKriteriaAddSubKriteria extends Migration
{
    public function up()
    {
        // 1. Hapus kolom nilai
        if ($this->db->fieldExists('nilai', 't_batu_kriteria')) {
            $this->forge->dropColumn('t_batu_kriteria', 'nilai');
        }

        // 2. Tambah kolom id_sub_kriteria
        if (! $this->db->fieldExists('id_sub', 't_batu_kriteria')) {
            $this->forge->addColumn('t_batu_kriteria', [
                'id_sub' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'after'      => 'id_kriteria',
                ],
            ]);
        }

        // 3. Foreign key (opsional tapi disarankan)
        $this->forge->addForeignKey(
            'id_sub',
            't_sub_kriteria',
            'id_sub',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        // Rollback FK dulu
        $this->forge->dropForeignKey('t_batu_kriteria', 't_batu_kriteria_id_sub_foreign');

        // Hapus kolom id_sub_kriteria
        if ($this->db->fieldExists('id_sub', 't_batu_kriteria')) {
            $this->forge->dropColumn('t_batu_kriteria', 'id_sub');
        }

        // Tambahkan kembali kolom nilai
        if (! $this->db->fieldExists('nilai', 't_batu_kriteria')) {
            $this->forge->addColumn('t_batu_kriteria', [
                'nilai' => [
                    'type'       => 'DOUBLE',
                    'null'       => true,
                    'after'      => 'id_kriteria',
                ],
            ]);
        }
    }
}
