<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddParsedDataToUploadedDataTable extends Migration
{
    public function up()
    {
        $fields = [
            'parsed_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('UploadedData', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('UploadedData', 'parsed_data');
    }
}