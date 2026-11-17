<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTahapanAlur extends Migration
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
            'jenis_izin_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'urutan'        => ['type' => 'INT', 'constraint' => 11],
            'nama_tahap'    => ['type' => 'VARCHAR', 'constraint' => 150],
            'peran'         => ['type' => 'VARCHAR', 'constraint' => 30],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['jenis_izin_id', 'urutan']);
        $this->forge->addForeignKey('jenis_izin_id', 'jenis_izin', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('tahapan_alur');
    }

    public function down()
    {
        $this->forge->dropTable('tahapan_alur');
    }
}