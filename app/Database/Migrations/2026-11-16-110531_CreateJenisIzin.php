<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisIzin extends Migration
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
        'nama' => [
            'type'       => 'VARCHAR',
            'constraint' => 100,
        ],
        'kode' => [
            'type'       => 'VARCHAR',
            'constraint' => 20,
        ],
        'urutan' => [
            'type'       => 'INT',
            'constraint' => 11,
            'default'    => 0,
        ],
        'punya_pencabutan' => [
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => 0,
        ],
        'aktif' => [
            'type'       => 'TINYINT',
            'constraint' => 1,
            'default'    => 1,
        ],
        'created_at' => ['type' => 'DATETIME', 'null' => true],
        'updated_at' => ['type' => 'DATETIME', 'null' => true],
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('nama');
    $this->forge->createTable('jenis_izin');
}

public function down()
{
    $this->forge->dropTable('jenis_izin');
}
}
