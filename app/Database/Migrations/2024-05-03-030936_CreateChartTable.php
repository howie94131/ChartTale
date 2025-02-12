<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateChartTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'chart_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'data_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'chart_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'theme' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('chart_id', TRUE);
        $this->forge->addForeignKey('data_id', 'UploadedData', 'data_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Chart');
    }

    public function down()
    {
        $this->forge->dropTable('Chart');
    }
}
