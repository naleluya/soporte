<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_control extends CI_Controller {


	public function __construct()
	{
		parent::__construct();

		$this->load->model('Login_model');
		$this->load->helper(array('html', 'url', 'form'));
		$this->load->library('session');
		$this->load->library('upload');
	}
	
	public function index()
	{
        if ($this->session->userdata('estado')==true)
		{   redirect('/Menu_control','refresh');

		}
		else
		{
			if(isset($_POST['hab_nombreusuario']) or isset($_POST['hab_password']))
			{
                if ($this->Login_model->login_user($_POST['hab_nombreusuario'], $_POST['hab_password']) && !empty($_POST['hab_nombreusuario']) && !empty($_POST['hab_password']))
				{
					$result= $this->Login_model->data_user($_POST['hab_nombreusuario'], $_POST['hab_password']);
					$this->session->set_userdata($result);
					redirect('/Menu_control','refresh');
				}
				else
				{
					$data['display']='block';
					$this->load->view('login/loginUser',$data);
				}
			}
			else
			{
                $data['display']='none';
				$this->load->view('login/loginUser',$data);
			}
		}
	}
	public function close_session()
	{
		$this->session->sess_destroy();
		redirect('/Login_control','refresh');
	}

    /* Desarrollado po:
        Lic. Mark Erik Copa
        Ing. Nelson Erwin Aleluya
        G.A.M.E.A.
        2018 */
}
