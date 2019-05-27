<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tec_control extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Secretaria_model');
        $this->load->model('Soporte_model');
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
            if ($data_session['rol_nombre'] == 'TECNICO' and $data_session['hab_estado'] == true) {
                $this->load->view('head', $data_session);
                $this->load->view('menu_admin');
                $this->load->view('soporte');
            } else {
                redirect('/Login_control/close_session', 'refresh');
            }
        } else {
            redirect('/Login_control/close_session', 'refresh');
        }
    }
    ////////////REGISTRO Y DOC PDF//////////
    public function save_registro()
    {
        $data_session = $this->session->all_userdata();
        $fecha = date('Y-m-d');
        $gestion = date('Y');
        
            $sop_tipo_sop = strip_tags(trim($this->input->post('tipo_soporte')));
            $sop_solicitante = strip_tags(trim(strtoupper($this->input->post('solicitante'))));
            $sop_cod_gamea = strip_tags(trim(strtoupper($this->input->post('cod_gamea'))));
            $sop_fecha_ingreso = strip_tags(trim($this->input->post('fecha_solicitud')));
            $sop_servicio = strip_tags(trim($this->input->post('servicio')));
            $sop_descripcion = strip_tags(trim(strtoupper($this->input->post('descripcion'))));
            $sop_trab_realizado = strip_tags(trim(strtoupper($this->input->post('trabajo_realizado'))));
            $sop_observaciones = strip_tags(trim(strtoupper($this->input->post('observaciones'))));
            $sop_observaciones = ('' == $sop_observaciones) ? 'NINGUNA' : $sop_observaciones;
            if($this->Secretaria_model->update_sec($data_session['sec_nombre']))
            {
                $sop_informe=$this->Secretaria_model->get_sec_informe($data_session['sec_nombre']);
            }
            
            $data_soporte = array(
                'sop_cod_gamea' => $sop_cod_gamea,
                'sop_fecha_ingreso' => $sop_fecha_ingreso,
                'sec_nombre' => $data_session['sec_nombre'],
                'sop_funcionario_resp' => $sop_solicitante,
                'sop_tecnico' => $data_session['usu_nombres'].' '.$data_session['usu_paterno'].' '.$data_session['usu_materno'],
                'sop_tipo_sop'=> $sop_tipo_sop,
                'sop_descripcion' => $sop_descripcion,
                'sop_servicio'=>$sop_servicio,
                'sop_trab_realizado' => $sop_trab_realizado,
                'sop_observaciones' => $sop_observaciones,
                'sop_gestion' => $gestion,
                'sop_informe' => $sop_informe->sec_informe,
                'usu_id' => $data_session['usu_id']
            );
            $this->Soporte_model->saveSoporte($data_soporte);
            
            $sop_id=$this->db->insert_id();

            /////REPORT PDF//////
            $this->load->library('ciqrcode');
            $this->load->library('Pdf');
            $pdf = new Pdf('P', 'mm', 'LETTER', true, 'UTF-8', false);
            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('UNIDAD DE SISTEMAS');
            $pdf->SetTitle('REPORTE DE REGISTRO DE SOPORTE');
            $pdf->SetKeywords('reporte PDF, Reporte de registro de soporte');
            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT,40, PDF_MARGIN_RIGHT,60);
            $pdf->SetPrintHeader(false);
            $pdf->SetFooterMargin(20);
            // set font
            $pdf->SetFont('helvetica', '', 11);
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
            $pdf->AddPage();
            date_default_timezone_set('America/La_Paz');
            $time = time();
            $txt=$data_session['usu_nombres'].'|'.$data_session['usu_paterno'].'|'.$data_session['usu_materno'].' '.$data_session['usu_ci'].'|'
                .$data_session['rol_nombre'].'|'.$sop_tipo_sop.'|'.$sop_servicio;
            $txt.='|'.date("d-m-Y (H:i:s)", $time);
            $params['data'] = $txt;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = FCPATH.'assets/qr/'.$sop_id.'.png';
            $this->ciqrcode->generate($params);
            $html_head='
                <table>
                  <tr>
                     <td rowspan="4" style="width: 40%; font-size:10px;">
                        <b>GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO<br></b>
                        <b>  UNIDAD DE SISTEMAS<br></b>
                     </td>
                     <td style="width: 15%;"></td>
                     <td style="width: 15%;"></td>
                     <td rowspan="4" style="width: 15%; font-size:8px;">
                       <img style="float:left;width:150px;height:150px;" src="' . base_url() . 'assets/qr/'.$sop_id.'.png">
                     </td>
                  </tr>
                </table>
                <div style="text-align:center;font-size:14pt; line-height:1;"><b>SOPORTE TECNICO</b><br>
                <span style="font-size:9pt;"><b>NUMERO DE CONTROL:</b> US/'.$data_session['sec_nombre'].'/'.$sop_informe->sec_informe.'/'.$gestion.'</span>
                </div>';
            $pdf->writeHTML($html_head, true, false, true, false, '');
            $date =date("d/m/Y"); 

            $html_cabecera='
                <br>
                <p style="text-indent: 30px;text-align:justify;font-family:Verdana;font-style: italic;">
                    En la ciudad de El Alto, <b>'.$date.'</b> se realizo el soporte técnico que se detalla a continuación:
                </p><br>';
            $pdf->writeHTML($html_cabecera, true, false, true, false, '');

            $html = '<style>
                            table {
                                border-collapse: separate;
                                border-spacing:  3px 3px;                                
                            }
                            table, th{
                            border: 1px solid black;
                            font-size: 10pt;
                            
                            padding-top: 5pt;
                            padding-bottom: 5pt;
                            }
                            td{
                            border: 1px solid black;
                            font-size: 10pt;
                            
                            padding-top: 5pt;
                            padding-bottom: 5pt;
                            height: 100px;
                            }
                      </style>
                <table>
                  <thead>
                      <tr style="background-color:lightgrey;">
                         <th style="text-align: center;" colspan="2"><b>CONSTANCIA DE SERVICIO PRESTADO (CSP)</b></th>
                      </tr>
                    </thead>
                  <tbody>
                        <tr>
                            <th colspan="2"><b>MANTENIMIENTO:  </b>'. $sop_tipo_sop .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>SERVICIO:  </b>'. $sop_servicio .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>SOLICITANTE:  </b>'. $sop_solicitante .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>DESCRIPCION DE LA SOLICITUD: <br></b>'.$sop_descripcion.'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>FECHA DE SOLICITUD:  </b>'. $date .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>TRABAJO REALIZADO.  </b><br>'. $sop_trab_realizado .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>OBSERVACIONES:  </b>'. $sop_observaciones .'</th>
                        </tr>
                        <tr>
                            <th rowspan="3" style="text-align: center;">REALIZADO POR:<br><br>'.$data_session['usu_nombres'].' '.$data_session['usu_paterno'].' '. $data_session['usu_materno'] .'</th>
                            <th rowspan="2"></th>
                        </tr>
                        <tr>
                            <th></th>
                        </tr>
                        <tr>
                            <th style="text-align: center;">FIRMA</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th style="text-align: center;">SELLO DE LA DEPENDENCIA</th>
                            <th style="text-align: center;">FIRMA Y SELLO</th>
                        </tr>
                        
                        </tbody>
                        </table>';
           
            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
            //Close and output PDF document
            $pdf->Output('soporte.pdf', 'I');
    }

    ///////////HITORIAL/////////////
    public function historial_index()
    {
        $data_session = $this->session->all_userdata();
        if (isset($data_session)) {
            if ($data_session['rol_nombre'] == 'TECNICO' and $data_session['hab_estado'] == true) {
                $data['historial'] = $this->Soporte_model->list_Historial($data_session['usu_id']);
                $this->load->view('head', $data_session);
                $this->load->view('menu_admin');
                $this->load->view('historial',$data);
            } else {
                redirect('/Login_control/close_session', 'refresh');
            }
        } else {
            redirect('/Login_control/close_session', 'refresh');
        }
    }
}