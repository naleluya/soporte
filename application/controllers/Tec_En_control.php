<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tec_En_control extends CI_Controller{
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
        $this->load->library('ciqrcode');
        $this->load->library('Pdf');
        $this->load->library('Export_excel');
        
    }

    public function index()
    {
        $data_session = $this->session->all_userdata();
        if (isset($data_session)) {
            if ($data_session['rol_nombre'] == 'TECNICO_ENCARGADO' and $data_session['hab_estado'] == true) {
                $data['registro'] = $this->Soporte_model->list_ultimo($data_session['usu_id']);
                $this->load->view('head', $data_session);
                $this->load->view('menus/menu_tec_en');
                $this->load->view('soporte_en', $data);
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
            $sop_cod_gamea = strip_tags(trim($this->input->post('cod_gamea')));
            $sop_fecha_ingreso = strip_tags(trim($this->input->post('fecha_solicitud')));
            $sop_servicio = strip_tags(trim($this->input->post('servicio')));
            $sop_descripcion = strip_tags(trim(strtoupper($this->input->post('descripcion'))));
            $sop_trab_realizado = strip_tags(trim(strtoupper($this->input->post('trabajo_realizado'))));
            $sop_observaciones = strip_tags(trim(strtoupper($this->input->post('observaciones'))));
            $sop_observaciones = ('' == $sop_observaciones) ? 'NINGUNA' : $sop_observaciones;
            $sop_fun_res_ci = strip_tags(trim(strtoupper($this->input->post('ci_funcionario'))));
            $sop_fun_res_ci_emitido = strip_tags(trim(strtoupper($this->input->post('ci_emitido'))));
            $sop_fun_cargo = strip_tags(trim(strtoupper($this->input->post('cargo_fun'))));
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
                'usu_id' => $data_session['usu_id'],
                'sop_fun_res_ci' => $sop_fun_res_ci,
                'sop_fun_res_ci_emitido' => $sop_fun_res_ci_emitido,
                'sop_cargo_fun' => $sop_fun_cargo,
                'sop_cod' => 'US/'.$data_session['sec_nombre'].'/'.$sop_informe->sec_informe.'/'.$gestion,
                'sop_print' => true
            );
            $this->Soporte_model->saveSoporte($data_soporte);
            
            $sop_id=$this->db->insert_id();

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

            redirect("Tec_En_control/");
    }   

    ///////////HITORIAL/////////////
    public function historial_index()
    {
        $data_session = $this->session->all_userdata();
        if (isset($data_session)) {
            if ($data_session['rol_nombre'] == 'TECNICO_ENCARGADO' and $data_session['hab_estado'] == true) {
                $data['historial'] = $this->Soporte_model->list_Historial($data_session['usu_id']);
                $data['tecnicos']= $this->Soporte_model->get_all_data_user();
                $this->load->view('head', $data_session);
                $this->load->view('menus/menu_tec_en');
                $this->load->view('historial_en',$data);
            } else {
                redirect('/Login_control/close_session', 'refresh');
            }
        } else {
            redirect('/Login_control/close_session', 'refresh');
        }
    }
    public function get_pdf($sop_id)
    {
        $data = $this->Soporte_model->get_PDF($sop_id);
        echo json_encode($data);
    }

    public function reprint_pdf($sop_id)
    {
        $data = $this->Soporte_model->get_PDF($sop_id);
        $data_session = $this->session->all_userdata();
        
        $fecha = $data->sop_fecha_ingreso;
        $ano = substr($fecha, -10, 4);
        $mes = substr($fecha, -5, 2);
        $dia = substr($fecha, -2, 2);
        $gestion = date('Y');
        
        switch ($data->sop_fun_res_ci_emitido) {
            case '1':
                $sop_emitido = "LP";
                break;
            case '2':
                $sop_emitido = "CB";
                break;
            case '3':
                $sop_emitido = "SC";
                break;
            case '4':
                $sop_emitido = "OR";
                break;
            case '5':
                $sop_emitido = "CH";
                break;
            case '6':
                $sop_emitido = "BN";
                break;
            case '7':
                $sop_emitido = "PT";
                break;
                case '8':
                $sop_emitido = "TJ";
                break;
                case '9':
                $sop_emitido = "PN";
                break;
        }

        /////REPORT PDF PARA DOMINIO//////
        
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
        $pdf->SetMargins(25,40, PDF_MARGIN_RIGHT,60);
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
        if ($data->sop_tipo_sop == "DOMINIO"){
            
            $html_head='
                <table>
                  <tr>
                     <td rowspan="4" style="width: 50%; font-size:10px;">
                        <b>GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO<br></b>
                        <b>  UNIDAD DE SISTEMAS<br></b>
                     </td>
                     <td style="width: 10%;"></td>
                     <td style="width: 10%;"></td>
                     <td rowspan="4" style="width: 15%; font-size:8px;">
                       <img style="float:left;width:150px;height:150px;" src="' . base_url() . 'assets/qr/'.$sop_id.'.png">
                     </td>
                  </tr>
                </table>
                <div style="text-align:center;font-size:14pt; line-height:1;"><b>ACTA DE CONFORMIDAD<br>DEL SERVICIO DE MIGRACION DE USUARIO<br>A RED DE DOMINIO</b><br>
                <span style="font-size:9pt;"><b>NUMERO DE CONTROL:</b> US/'.$data_session['sec_nombre'].'/'.$data->sop_informe.'/'.$gestion.'</span>
                </div>';
            $pdf->writeHTML($html_head, true, false, true, false, '');
            $date =date("d/m/Y"); 
            
            $html_cabecera='
                <br>
                <p style="text-indent: 30px;text-align:justify;font-family:Verdana;">
                Por medio de la presente acta, los que suscriben, que a la fecha '.$dia.' de '.$mes.' de '.$ano.', 
                se ha dado por concluido <b>“LA MIGRACIÓN DE USUARIO A RED DE DOMINIO”</b> con todas las tareas 
                complementarias, los mismos que han sido desarrollados a satisfacción. Dejando constancia 
                que el personal de la <b>Unidad de Sistemas</b>, realizando las pruebas necesarias, deja en buen 
                funcionamiento el acceso del funcionario al sistema operativo con su usuario y contraseña 
                correspondiente al dominio lan.gamea.gob.bo, configuración de impresora (ya sea en red o local), 
                documentación y software que utilice el mismo para desarrollar sus funciones normalmente. 
                De no haber observaciones a los trabajos por parte del usuario final, se da por concluida la 
                ejecución del servicio de Migración de Usuario a Red de Dominio.</p><br>

                <p style="text-indent: 30px;text-align:justify;font-family:Verdana;">
                <b>Observacion:</b><br>
                '.$data->sop_observaciones.'<br><br>
                En señal de conformidad suscribimos la presente acta.
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
                      <tr>
                         <td></td>
                         <td></td>
                      </tr>
                    </thead>
                  <tbody>
                        <tr>
                            <th><b>TECNICO RESPONSABLE:</b></th>
                            <th><b>FUNCIONARIO:</b></th>
                        </tr>
                        <tr>
                            <th>' . $data_session['usu_nombres'] . ' ' . $data_session['usu_paterno'] . ' ' . $data_session['usu_materno'] . '</th>
                            <th>' . $data->sop_funcionario_resp . '</th>
                        </tr>
                        <tr>
                            <th><b>CARGO:  </b>TÉCNICO UNIDAD DE SISTEMAS</th>
                            <th><b>C:I.: </b>' . $data->sop_fun_res_ci . ' ' . $sop_emitido . '</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><b>CARGO: </b>' . $data->sop_cargo_fun . '</th>
                        </tr>                    
                  </tbody>
                </table>';
           
            // output the HTML content
            $pdf->writeHTML($html, true, false, true, false, '');
            //Close and output PDF document
            $pdf->Output('soporte.pdf', 'I');
        }else{
            $html_head='
                <table>
                  <tr>
                     <td rowspan="4" style="width: 45%; font-size:10px;">
                        <b>GOBIERNO AUTONOMO MUNICIPAL DE EL ALTO<br></b>
                        <b>  UNIDAD DE SISTEMAS<br></b>
                     </td>
                     <td style="width: 10%;"></td>
                     <td style="width: 15%;"></td>
                     <td rowspan="4" style="width: 15%; font-size:8px;">
                       <img style="float:left;width:150px;height:150px;" src="' . base_url() . 'assets/qr/'.$sop_id.'.png">
                     </td>
                  </tr>
                </table>
                <div style="text-align:center;font-size:14pt; line-height:1;"><b>SOPORTE TECNICO</b><br>
                <span style="font-size:9pt;"><b>NUMERO DE CONTROL:</b> US/'.$data_session['sec_nombre'].'/'.$data->sop_informe.'/'.$gestion.'</span>
                </div>';
            $pdf->writeHTML($html_head, true, false, true, false, '');
            $date =date("d/m/Y"); 

            $html_cabecera='
                <br>
                <p style="text-indent: 30px;text-align:justify;font-family:Verdana;font-style: italic;">
                    En la ciudad de El Alto, <b>'.$dia.' / '.$mes.' / '.$ano.'</b> se realizo el soporte técnico que se detalla a continuación:
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
                            padding-bottom: 10pt;
                            height: 130px;
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
                            <th><b>SOPORTE TECNICO:  </b>'. $data->sop_tipo_sop .'</th>
                            <th><b>CODIGO GAMEA: </b> '. $data->sop_cod_gamea.'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>SERVICIO:  </b>'. $data->sop_servicio .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>SOLICITANTE:  </b>'. $data->sop_funcionario_resp .'<br>&nbsp;&nbsp;&nbsp;&nbsp;'. $data->sop_cargo_fun.'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>DESCRIPCION DE LA SOLICITUD: <br></b>'.$data->sop_descripcion.'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>FECHA DE SOLICITUD:  </b>'.$dia.' / '.$mes.' / '.$ano.'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>TRABAJO REALIZADO.  </b><br>'. $data->sop_trab_realizado .'</th>
                        </tr>
                        <tr>
                            <th colspan="2"><b>OBSERVACIONES:  </b>'. $data->sop_observaciones .'</th>
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
    }
    public function get_sop($sop_id)
    {
        $data = $this->Soporte_model->getSop($sop_id);
        echo json_encode($data);
    }
    public function edit_Sop()
    {
        $sop_tipo_sop = strip_tags(trim($this->input->post('e_tipo_soporte')));
        $sop_funcionario_resp = strip_tags(trim(strtoupper($this->input->post('e_solicitante'))));
        $sop_fun_res_ci = strip_tags(trim($this->input->post('e_ci_funcionario')));
        $sop_fun_res_ci_emitido = strip_tags(trim($this->input->post('e_ci_emitido')));
        $sop_cod_gamea = strip_tags(trim($this->input->post('e_cod_gamea')));
        $sop_cargo_fun = strip_tags(trim(strtoupper($this->input->post('e_cargo_fun'))));
        $sop_servicio = strip_tags(trim($this->input->post('e_servicio')));
        $sop_descripcion = strip_tags(trim(strtoupper($this->input->post('e_descripcion'))));
        $sop_trab_realizado = strip_tags(trim(strtoupper($this->input->post('e_trabajo_realizado'))));
        $sop_observaciones = strip_tags(trim(strtoupper($this->input->post('e_observaciones'))));
        $sop_observaciones = ('' == $sop_observaciones) ? 'NINGUNA' : $sop_observaciones;
        $sop_id = $this->input->post('sop_id');

        $data = array(
            'sop_tipo_sop' => $sop_tipo_sop,
            'sop_funcionario_resp' => $sop_funcionario_resp,
            'sop_fun_res_ci' => $sop_fun_res_ci,
            'sop_fun_res_ci_emitido' => $sop_fun_res_ci_emitido,
            'sop_cod_gamea' => $sop_cod_gamea,
            'sop_cargo_fun' => $sop_cargo_fun,
            'sop_servicio' => $sop_servicio,
            'sop_descripcion' => $sop_descripcion,
            'sop_trab_realizado' => $sop_trab_realizado,
            'sop_observaciones' => $sop_observaciones,            
        );

        $this->Soporte_model->updateSop($sop_id, $data);

        redirect("Tec_En_control/historial_index");
    }

    //////////////////TECNICOS-REPORTE///////////////
    public function reporte_index()
    {
        $data_session = $this->session->all_userdata();
        if (isset($data_session)) {
            if ($data_session['rol_nombre'] == 'TECNICO_ENCARGADO' and $data_session['hab_estado'] == true) {
                $data['registro'] = $this->Soporte_model->get_all();
                $data['tecnicos']= $this->Soporte_model->get_all_data_user();
                $this->load->view('head', $data_session);
                $this->load->view('menus/menu_tec_en');
                $this->load->view('reporte_tec',$data);
            } else {
                redirect('/Login_control/close_session', 'refresh');
            }
        } else {
            redirect('/Login_control/close_session', 'refresh');
        }
    }
    public function dExcel($id)
    {
        $result = $this->Soporte_model->getReporte($id);
        $this->export_excel->to_excel($result, 'reporte de actividades');
    }
    
}