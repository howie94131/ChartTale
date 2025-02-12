<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUploadedDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'data_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
            'size' => [
                'type' => 'FLOAT',
            ],
        ]);
        $this->forge->addKey('data_id', TRUE);
        $this->forge->addForeignKey('user_id', 'Users', 'user_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('UploadedData');
    }

    public function down()
    {
        $this->forge->dropTable('UploadedData');
    }
}
