<?php

namespace App\Models;

use CodeIgniter\Model;

class StoryModel extends Model
{
    protected $table = 'Stories'; // Set to your actual table name
    protected $primaryKey = 'story_id'; 
    protected $allowedFields = ['chart_id', 'content', 'created_at'];
    protected $returnType = 'array';
    protected $useTimestamps = true; // Set to true if you have created_at & updated_at fields
}