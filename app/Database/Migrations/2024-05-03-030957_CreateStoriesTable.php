<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'story_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ],
            'chart_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
        ]);
        $this->forge->addKey('story_id', TRUE);
        $this->forge->addForeignKey('chart_id', 'Chart', 'chart_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('Stories');
    }

    public function down()
    {
        $this->forge->dropTable('Stories');
    }
}