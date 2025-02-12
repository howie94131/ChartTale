<?php

namespace App\Models;

use CodeIgniter\Model;

class ChartModel extends Model
{
    protected $table = 'Chart'; // Set to your actual table name
    protected $primaryKey = 'chart_id'; 
    protected $allowedFields = ['data_id', 'chart_type', 'theme', 'created_at', 'columns', 'story'];
    protected $returnType = 'array';
    protected $useTimestamps = false; // Set to true if you have created_at & updated_at fields
}