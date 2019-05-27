<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_control extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Login_model');
        $this->load->model('User_model');
        $this->load->helper(array('html', 'url', 'form'));
        $this->load->library('session');
        $this->load->library('upload');
        
    }

    public function index()
    {
        $data_session = $this->session->all_userdata();
        if (isset($data_session)) {
            if ($data_session['rol_nombre'] == 'ADMINISTRADOR' and $data_session['hab_estado'] == true) {
                $this->load->view('head', $data_session);
                $data['usuario']=$data_session;
                $this->load->view('menu_admin');
                $this->load->view('soporte', $data);
            } else {
                redirect('/Login_control/close_session', 'refresh');
            }
        } else {
            redirect('/Login_control/close_session', 'refresh');
        }
    }
}