<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusFieldToUserTable extends Migration
{
    public function up()
    {
        // Adding a 'status' field to the 'User' table
        $fields = [
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'default' => 'active',
                'after' => 'is_admin' 
            ]
        ];
        $this->forge->addColumn('Users', $fields);
    }

    public function down()
    {
        // Removing the 'status' field from the 'User' table
        $this->forge->dropColumn('Users', 'status');
    }
}