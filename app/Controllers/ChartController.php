<?php namespace App\Controllers;

use CodeIgniter\Controller;

class ChartController extends BaseController
{
    public function __construct()
     {
         // Load the URL helper, it will be useful in the next steps
         // Adding this within the __construct() function will make it 
         // available to all views in the ResumeController
         helper('url'); 

         $this->session = session();
     }

    public function index()
    {
        return view('homepage');
    }

    public function denied()
    {
        return view('denied');
    }

    public function loginpls()
    {
        return view('loginpls');
    }

    public function admin()
    {
        // Create an instance of the UserModel
        $model = new \App\Models\UserModel();
        
        // Get the value of the 'search' query parameter from the request
        $search = $this->request->getGet('search');
        
        if (!empty($search)) {
            // If the search query is not empty
            
            // Initialize an empty array to store search conditions
            $conditions = [];
            
            // Loop through each allowed field in the UserModel
            foreach ($model->allowedFields as $field) {
                // Generate a search condition for each field using LIKE operator
                $conditions[] = "$field LIKE '%$search%'";
            }
            
            // Implode the conditions array with OR operator to create a single search clause
            $whereClause = implode(' OR ', $conditions);
            
            // Retrieve users matching the search conditions, order by name in ascending order
            $users = $model->where($whereClause)->orderBy('username', 'ASC')->findAll();
        } else {
            // If no search query is provided
            
            // Retrieve all users, order by name in ascending order
            $users = $model->orderBy('username', 'ASC')->findAll();
        }
        
        // Store the retrieved users in the $data array
        $data['users'] = $users;
        
        // Load the 'admin' view and pass the $data array to it
        return view('admin', $data);
    }

    public function addedit($id = null)
    {
        $model = new \App\Models\UserModel();

        // Check if the request is a POST request (form submission).
        if ($this->request->getMethod() === 'POST') {
            // Retrieve the submitted form data.
            $data = $this->request->getPost();

            // If no ID is provided, it's an add operation.
            if ($id === null) {
                if ($model->insert($data)) {
                    // If the user is successfully added, set a success message.
                    $this->session->setFlashdata('success', 'User added successfully.');
                } else {
                    // If the addition fails, set an error message.
                    $this->session->setFlashdata('error', 'Failed to add user. Please try again.');
                }
            } else {
                // If an ID is provided, it's an edit operation.
                if ($model->update($id, $data)) {
                    // If the user is successfully updated, set a success message.
                    $this->session->setFlashdata('success', 'User updated successfully.');
                } else {
                    // If the update fails, set an error message.
                    $this->session->setFlashdata('error', 'Failed to update user. Please try again.');
                }
            }

            // Redirect back to the admin page after the operation.
            return redirect()->to('/admin');
        }

        // If the request is a GET request, load the form with existing user data (for edit) or as blank (for add).
        $data['user'] = ($id === null) ? null : $model->find($id);

        // Display the add/edit form view, passing in the user data if available.
        return view('addedit', $data);
    }
    
    public function delete($id)
    {
        $model = new \App\Models\UserModel();

        if ($model->delete($id)) {
            $this->session->setFlashdata('success', 'User deleted successfully.');
        } else {
            $this->session->setFlashdata('error', 'Failed to delete user. Please try again.');
        }

        return redirect()->to('/admin');
    }
    
}