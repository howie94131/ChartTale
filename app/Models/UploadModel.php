<?php

namespace App\Models;

use CodeIgniter\Model;

class UploadModel extends Model
{
    protected $table = 'UploadedData'; // Set to your actual table name
    protected $primaryKey = 'data_id'; 
    protected $allowedFields = ['user_id','filename', 'created_at', 'size', 'parsed_data'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}