<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Task_model'); // Model to manage tasks
        $this->load->library('session');

        // Redirect to login if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index() {
        // Check user role and redirect accordingly
        if ($this->session->userdata('role') === 'Admin') {
            redirect('dashboard/admin_dashboard');
        } elseif ($this->session->userdata('role') === 'Manager') {
            redirect('dashboard/manager_dashboard');
        } else {
            redirect('dashboard/user_dashboard');
        }
    }

    public function admin_dashboard() {
        // Load view for admin dashboard
        $data['tasks'] = $this->Task_model->get_all_tasks();
        $this->load->view('dashboard/admin_dashboard', $data);
    }

    public function manager_dashboard() {
        // Load view for manager dashboard
        $data['tasks'] = $this->Task_model->get_tasks_by_manager($this->session->userdata('user_id'));
        $this->load->view('dashboard/manager_dashboard', $data);
    }

    public function user_dashboard() {
        // Load view for user dashboard
        $data['tasks'] = $this->Task_model->get_tasks_by_user($this->session->userdata('user_id'));
        $this->load->view('dashboard/user_dashboard', $data);
    }
}
