<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        // Define the Users table
        $this->forge->addField([
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'isAdmin' => [
                'type' => 'BOOLEAN',
            ],
            
        ]);
        
        $this->forge->addKey('user_id', TRUE); // Set user_id as primary key
        $this->forge->createTable('Users'); // Create the Users table
    }

    public function down()
    {
        $this->forge->dropTable('Users', true);
    }
}
