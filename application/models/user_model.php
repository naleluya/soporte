<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_filtered_data()
    {
        $this->make_query();

        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_all_data_user()
    {
        $query = $this->db->query("SELECT *
                                    FROM usuario u
                                    INNER JOIN habilitar h
                                    ON (h.usu_id = u.usu_id)
                                    INNER JOIN roles r
                                    ON (h.rol_id = r.rol_id)
                                    ");
        return $query->result();
    }

    function Add_User($data_u)
    {
        $this->db->insert('usuario', $data_u);
        if ($this->db->affected_rows())
            return true;
        else
            return false;
    }

    function Add_User_H($data_h)
    {
        $this->db->insert('habilitar', $data_h);
        if ($this->db->affected_rows())
            return true;
        else
            return false;
    }

    function GetUser($usu_id)
    {
        $this->db->from('usuario');
        $this->db->where('usu_id', $usu_id);
        $query = $this->db->get();
        return $query->row();
    }

    function Update_User($usu_id,$data)
    {
        $this->db->where('usu_id', $usu_id);
        $this->db->update('habilitar', $data);
        if ($this->db->affected_rows() > 0 )
            return true;
        else
            return false;
    }
}