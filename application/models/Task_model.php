<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task_model extends CI_Model {

    // Retrieve all tasks
    public function get_all_tasks() {
        return $this->db->get('tasks')->result_array();
    }

     // Update an existing task
     public function update_task($task_id, $data) {
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', $data);
    }

    // Retrieve tasks assigned to a specific manager
    public function get_tasks_by_manager($manager_id) {
        $this->db->where('assigned_to', $manager_id);
        return $this->db->get('tasks')->result_array();
    }

    // Retrieve tasks assigned to a specific user
    public function get_tasks_by_user($user_id) {
        $this->db->where('assigned_to', $user_id);
        return $this->db->get('tasks')->result_array();
    }

    // Create a new task
    public function create_task($data) {
        return $this->db->insert('tasks', $data);
    }


    // Update an existing task by ID
    public function update_task_status($task_id, $status, $role) {
        // Here you can implement role-specific logic if needed
        $this->db->where('id', $task_id);
        return $this->db->update('tasks', ['status' => $status]);
    }

    // Delete a task by ID
    public function delete_task($task_id) {
        $this->db->where('id', $task_id);
        return $this->db->delete('tasks');
    }

    // Get a specific task by ID
    public function get_task_by_id($task_id) {
        $this->db->where('id', $task_id);
        return $this->db->get('tasks')->row_array(); // Return a single row
    }
}
