<?php

namespace App\Models; 

use CodeIgniter\Model; // Imports the base Model class from the CodeIgniter framework.

class UserModel extends Model // Defines a new class UserModel that extends CodeIgniter's Model class.
{
    protected $table = 'Users'; 
    protected $primaryKey = 'user_id'; 
    // Lists the fields that are allowed to be set using the model. This is for security and prevents mass assignment vulnerabilities.
    protected $allowedFields = ['username', 'email','status', "isAdmin"]; 
    protected $returnType = 'array'; 
}