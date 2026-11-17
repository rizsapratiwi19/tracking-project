<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatTahapan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'permohonan_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tahapan_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'pengguna_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'tanggal'       => ['type' => 'DATETIME'],
            'catatan'       => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('permohonan_id', 'permohonan', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('tahapan_id', 'tahapan_alur', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('riwayat_tahapan');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_tahapan');
    }
}