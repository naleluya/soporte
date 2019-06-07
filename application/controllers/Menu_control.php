<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Menu_control extends CI_Controller
{


    public function __construct()
    {

        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(array('html', 'url', 'form'));
        $this->load->model('Login_model');
    }

    public function index()
    {

        $data_session = $this->session->all_userdata();
        //Recuperar todos los Datos de Sessión

        switch (isset($data_session)) {
            case $data_session['rol_nombre'] == 'ADMINISTRADOR':
                if ($data_session['hab_estado'] == true)
                    redirect('/Admin_control/', 'refresh');
                else
                    redirect('/Login_control/close_session', 'refresh');
                break;
            case $data_session['rol_nombre'] == 'TECNICO_ENCARGADO':
                if ($data_session['hab_estado'] == true)
                    redirect('/Tec_En_control/', 'refresh');
                else
                    redirect('/Login_control/close_session', 'refresh');
                break;    
            case $data_session['rol_nombre'] == 'TECNICO':
                if ($data_session['hab_estado'] == true)
                    redirect('/Tec_control/', 'refresh');
                else
                    redirect('/Login_control/close_session', 'refresh');
                break;
            default:
                redirect('/Login_control/close_session', 'refresh');
                break;
        }
    }


    /* Desarrollado por:
    G.A.M.E.A.
    2018 */
}
