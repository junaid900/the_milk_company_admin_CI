<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Frontend extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->library('session');
        // $userData = ["directory" => "madmin"];
        // $this->session->set_userdata($userData);
        
    }

    /***** ADMIN INDEX *********/
    public function index()
    {
        $this->load->view('frontend/privacy_policy');
    }
    
    
}