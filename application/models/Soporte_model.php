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
        $query = $this->db->get('gestion');
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
    
    public function search_queries($bus_name_file, $bus_nro_file, $bus_year_file)
    {

        $this->db->from($bus_name_file);
        $this->db->where($bus_name_file . '_nro', $bus_nro_file);
        $this->db->where($bus_name_file . '_gestion', $bus_year_file);
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
        $query = $this->db->get('soporte');

        return $query->result();
    }
    public function get_PDF($id)
    {
        $this->db->from('soporte');
        $this->db->where('sop_id', $id);
        $this->db->order_by("sop_informe", "desc");
        $query = $this->db->get();
        return $query->row();
    }
    function get_all_data_user()
    {
        $query = $this->db->query("SELECT *
                                    FROM usuario u
                                    
                                    INNER JOIN habilitar h
                                    ON (h.usu_id = u.usu_id)
                                    INNER JOIN roles r
                                    ON (h.rol_id = r.rol_id)
                                    WHERE h.rol_id=2
                                    ");
        return $query->result();
    }

    function list_tec($usu_id)
    {
        return $this->db
            ->where('usu_id', $usu_id)
            ->order_by("sop_cod", "desc")
            ->get()
            ->result();
    }
    function getReporte($id)
    {
        $this->db->from('soporte');
        $this->db->where('usu_id', $id);
        $query = $this->db->get();

        return $query;
    }

    function get_all()
    {
        $this->db->from('soporte');
        $query = $this->db->get();

        return $query->result();
    }

    function getSop($sop_id)
    {
        $this->db->from('soporte');
        $this->db->where('sop_id', $sop_id);
        $query = $this->db->get();
        return $query->row();
    }

    public function updateSop($sop_id, $data)
    {
        $this->db->where('sop_id', $sop_id);
        $this->db->update('soporte', $data);
        if ($this->db->affected_rows() > 0)
            return true;
        else
            return false;
    }
    function list_ultimo($usu_id)
    {
        $query = $this->db->query(
                                "SELECT sop_cod, sop_id, sop_informe
                                FROM soporte
                                WHERE usu_id = $usu_id
                                ORDER BY sop_cod desc
                                LIMIT 1"
                                );

        return $query->row();
    }

    /* Desarrollado por:
        Ing. Nelson Erwin Aleluya
        G.A.M.E.A.
        2018 */
}