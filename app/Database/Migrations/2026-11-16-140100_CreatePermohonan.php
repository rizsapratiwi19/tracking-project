<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermohonan extends Migration
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
            'nomor_register'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'jenis_izin_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jenis_proses'      => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'permohonan'],
            'uraian_permohonan' => ['type' => 'TEXT', 'null' => true],
            'nama_pemohon'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'nama_kuasa'        => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'lokasi'            => ['type' => 'TEXT', 'null' => true],
            'no_hp'             => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'kelengkapan'       => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'lengkap'],
            'tanggal_terima'    => ['type' => 'DATE'],
            'tahapan_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status'            => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'proses'],
            'dibuat_oleh'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nomor_register');
        $this->forge->addForeignKey('jenis_izin_id', 'jenis_izin', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('tahapan_id', 'tahapan_alur', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('permohonan');
    }

    public function down()
    {
        $this->forge->dropTable('permohonan');
    }
}