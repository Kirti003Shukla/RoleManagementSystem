<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Load the database

    }

    public function register($data) {
        return $this->db->insert('users', $data);
    }

    // Login function to get user by email
    public function login($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }
}
