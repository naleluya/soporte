<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Secretaria_model extends CI_Model
{
    var $table= 'secretaria_municipal';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_secretaria(){
        $data = array();
        $query = $this->db->get('secretaria_municipal');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row){
                    $data[] = $row;
                }
        }
        $query->free_result();
        return $data;
    }
    function update_sec($sec_nombre)
    {    
        /*$query = $this->db->query("UPDATE secretaria_municipal SET sec_informe = sec_informe + 1 WHERE sec_nombre = $sec_nombre");
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;*/
        $this->db->set('sec_informe', 'sec_informe+1',FALSE);
        $this->db->where('sec_nombre',$sec_nombre);
        $this->db->update('secretaria_municipal');
        
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }
    public function get_sec_informe($sec_nombre)
    {
        $this->db->from('secretaria_municipal');
        $this->db->where('sec_nombre', $sec_nombre);
        $query = $this->db->get();
        return $query->row();
    }
}