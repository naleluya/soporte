<?php
class Login_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    ///////////////////////////////////////////////////////////
    public function login_user($username, $password)
    {
        $this->db->where('hab_nombreusuario',$username);
        $this->db->where('hab_password',$password);
        $this->db->where('hab_estado',true);
        $q=$this->db->get('habilitar');
        if($q->num_rows()>0){
            return true;
        }
        else{
            return false;
        }
    }

    ////////////////////////////////////////////////////////////
    public function data_user($user, $password)
    {
        $query = $this->db->query("SELECT * 
							FROM usuario
							INNER JOIN habilitar ON usuario.usu_id = habilitar.usu_id 
							INNER JOIN roles ON habilitar.rol_id = roles.rol_id
							WHERE habilitar.hab_password='$password' AND
							habilitar.hab_nombreusuario='$user'
							");
        $row = $query->row();
        $data_session=array(
            'hab_estado'=>true,
            'usu_id'=> $row->usu_id,
            'usu_nombres'=> $row->usu_nombres,
            'usu_paterno'=> $row->usu_paterno,
            'usu_materno'=> $row->usu_materno,
            'usu_ci'=> $row->usu_ci,
            'hab_nombreusuario' => $row->hab_nombreusuario,
            'rol_nombre' => $row->rol_nombre,
            'usu_genero' => $row->usu_genero,
            'dep_id' => $row->dep_id,
            'hab_fecha' => $row->hab_fecha,
            'usu_celular' => $row->usu_celular,
            'sec_nombre' => $row->sec_nombre
        );
        return $data_session;
    }
}