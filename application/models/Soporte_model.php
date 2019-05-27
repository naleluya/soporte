<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Soporte_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function list_gestion()
    {
        $query=$this->db->get('gestion');
        return $query->result();
    }
    function list_adminHab()
    {
        $query = $this->db->query("SELECT *
                        FROM usuario INNER JOIN habilitar ON (usuario.usu_id = habilitar.usu_id) 
                        INNER JOIN roles ON (habilitar.rol_id = roles.rol_id)
                        WHERE roles.rol_id=1 and habilitar.hab_estado='t'
                        ORDER by usuario.usu_paterno; 
        ");
        return $query->result();
    }
    function list_prestamos()
    {
        $this->db->order_by("pre_fecha_prestamo", "desc");
        $this->db->where('pre_estado',true );
        $query=$this->db->get('prestamo');

        return $query->result();
    }
    public function search_queries($bus_name_file,$bus_nro_file,$bus_year_file)
    {

        $this->db->from($bus_name_file);
        $this->db->where($bus_name_file.'_nro', $bus_nro_file);
        $this->db->where($bus_name_file.'_gestion', $bus_year_file);
        $query = $this->db->get();
        return $query->row();
    }
    public function saveSoporte($data)
    {
        $this->db->insert('soporte', $data);
    }
    public function saveDocumento($data)
    {
        $this->db->insert('documentos', $data);
    }

    function row_adminHab($usu_id)
    {
        $query = $this->db->query("SELECT *
                        FROM usuario INNER JOIN habilitar ON (usuario.usu_id = habilitar.usu_id) 
                        INNER JOIN roles ON (habilitar.rol_id = roles.rol_id)
                        WHERE roles.rol_id=1 and habilitar.hab_estado='t' and usuario.usu_id=$usu_id
                        ORDER by usuario.usu_paterno; 
        ");
        return $query->row();
    }

    function list_Historial($usu_id)
    {
        $this->db->select('*');
        $this->db->where('usu_id', $usu_id);
        $this->db->order_by("sop_fecha_ingreso", "desc");
        $query=$this->db->get('soporte');

        return $query->result();
    }

    /* Desarrollado por:
        Lic. Mark Erik Copa
        Ing. Nelson Erwin Aleluya
        G.A.M.E.A.
        2018 */
}