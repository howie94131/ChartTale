<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ChartDataSeeder extends Seeder
{
    public function run()
    {
        // Insert sample data into the Users table
        $user_data = [
            [
                'username' => 'User1',
                'email' => 'user1@example.com',
                'status' => 'Active',
                'is_admin' => false
            ],
            [
                'username' => 'User2',
                'email' => 'user2@example.com',
                'status' => 'Active',
                'is_admin' => false
            ],
        ];

        // Batch insert users
        $this->db->table('Users')->insertBatch($user_data);
        
        // Assume we know user IDs or fetch them
        $userIds = $this->db->insertID(); // This should be handled according to how IDs need to be used

        // Insert sample data into UploadedData table
        $uploaded_data = [
            [
                'user_id' => $userIds,
                'filename' => 'data1.csv',
                'created_at' => date('Y-m-d H:i:s'),
                'size' => 1.5
            ],
            [
                'user_id' => $userIds,
                'filename' => 'data2.csv',
                'created_at' => date('Y-m-d H:i:s'),
                'size' => 2.0
            ],
        ];

        $this->db->table('UploadedData')->insertBatch($uploaded_data);

        // Insert sample data into the Chart table
        $chart_data = [
            [
                'data_id' => 1,
                'chart_type' => 'Bar',
                'theme' => 'Dark',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'data_id' => 2,
                'chart_type' => 'Line',
                'theme' => 'Light',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Chart')->insertBatch($chart_data);

        // Insert sample data into the Stories table
        $stories_data = [
            [
                'chart_id' => 1,
                'content' => 'This is a bar chart representing the annual sales.',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'chart_id' => 2,
                'content' => 'This line chart shows the monthly temperature variations.',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('Stories')->insertBatch($stories_data);
    }
}
