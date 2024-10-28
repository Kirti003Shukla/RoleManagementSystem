<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tasks extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Task_model');
        $this->load->library('session');
    }

    // Display all tasks
    public function index() {
        $data['tasks'] = $this->Task_model->get_all_tasks();
        $this->load->view('dashboard/admin_dashboard', $data); // Change view based on role
    }

    // Save or update a task
    public function save() {
        $config['upload_path'] = './assets/uploads/';
        $config['allowed_types'] = 'pdf|docx|jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
        $this->load->library('upload', $config);
    
        // Attempt file upload and set file path
        $file_path = null;
        if (!empty($_FILES['file']['name']) && $this->upload->do_upload('file')) {
            $fileData = $this->upload->data();
            $file_path = 'assets/uploads/' . $fileData['file_name'];
        } else if (!empty($_FILES['file']['name'])) {
            echo $this->upload->display_errors(); // Display error if file upload fails
            return;
        }
        $task_id = $this->input->post('task_id');
        $data = [
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'priority' => $this->input->post('priority'),
            'due_date' => $this->input->post('due_date'),
            'category' => $this->input->post('category'),
            'assigned_to' => $this->input->post('assigned_to'),
            'file_path' => $file_path, // Store file path
            'status' => 'Pending' // Default status
        ];
        log_message('debug', 'Data being saved: ' . print_r($data, true)); // Log data being saved
// Check if required fields are not null
if (empty($data['title']) || empty($data['description'])) {
    // Handle error for required fields
    show_error('Title and Description are required.', 400);
}
        if ($task_id) {
            // Update existing task
            $this->Task_model->update_task($task_id, $data);
        } else {
            // Create new task
            $this->Task_model->create_task($data);
        }
        redirect('tasks'); // Redirect to the tasks list
    }

    public function edit($task_id) {
        $data['task'] = $this->Task_model->get_task_by_id($task_id); // Fetch task data by ID
        if (!$data['task']) {
            // Handle the case where the task does not exist
            show_404(); // Show a 404 page or handle the error as needed
        }
        $this->load->view('tasks/edit_task', $data); // Load the edit view
    }


    // Delete a task
    public function delete($task_id) {
        $this->Task_model->delete_task($task_id);
        redirect('tasks'); // Redirect to the tasks list
    }

    // Update task status
public function update_status() {
    $task_id = $this->input->post('task_id');
    $status = $this->input->post('status');
    $role = $this->session->userdata('role'); // Get the user role from the session

    // Ensure all required values are received
    if ($task_id && $status && $role) {
        // Update status with any additional logic based on user role if needed
        $this->Task_model->update_task_status($task_id, $status, $role); // Pass role for additional logic if needed

        // Redirect based on the user's role
        if ($role === 'Admin') {
            redirect('dashboard/admin_dashboard');
        } elseif ($role === 'Manager') {
            redirect('dashboard/manager_dashboard');
        } else {
            redirect('dashboard/user_dashboard');
        }
    } else {
        // Handle errors if needed
        redirect('dashboard/user_dashboard');
    }
}

}
