<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
    }

    public function register() { 
        // Set validation rules for each field
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
    
        if ($this->form_validation->run() == FALSE) {
            // Reload register view with validation errors if validation fails
            $this->load->view('auth/register');
        } else {
            // Hash the password using bcrypt
            $password = $this->input->post('password');
            $hash = password_hash($password, PASSWORD_BCRYPT);
    
            // Prepare data for database insertion
            $data = [
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $hash,
                'role' => $this->input->post('role')
            ];
            log_message('debug', 'User data: ' . print_r($data, true));

            // Call the register function from the Auth_model
            if ($this->Auth_model->register($data)) {
                // Redirect to login with success message
                $this->session->set_flashdata('success', 'Registration successful. Please log in.');
                redirect('auth/login');
            } else {
                // Show error message if registration fails
                $error = $this->db->error(); // Get the last error
                $this->session->set_flashdata('error', 'Registration failed: ' . $error['message']);
                redirect('auth/register');
            }
        }
    }


    // Login method
    public function login() {
        // Set validation rules for the login form
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            // Reload the login view with errors if validation fails
            $this->load->view('auth/login');
        } else {
            // Get email and password from POST data
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            // Fetch user data by email using Auth_model
            $user = $this->Auth_model->login($email);

            // Verify the password and check if the user exists
            if ($user && password_verify($password, $user->password)) {
                // Set session data for the logged-in user
                $this->session->set_userdata([
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'logged_in' => TRUE
                ]);

                // Redirect based on the user's role
                if ($user->role == 'Admin') {
                    redirect('dashboard');
                } elseif ($user->role == 'Manager') {
                    redirect('dashboard');
                } else {
                    redirect('dashboard');
                }
            } else {
                // Show error message if credentials are incorrect
                $this->session->set_flashdata('error', 'Invalid email or password');
                redirect('auth/login');
            }
        }
    }

    // Logout method
    public function logout() {
        // Destroy session data
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    // Check role methods
    public function is_admin() {
        return $this->session->userdata('role') === 'Admin';
    }

    public function is_manager() {
        return $this->session->userdata('role') === 'Manager';
    }

    public function is_user() {
        return $this->session->userdata('role') === 'User';
    }
}
