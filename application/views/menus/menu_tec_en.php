<div class="pos-fixed fixed-top app-bar-wrapper z-top">
    <header class="container pos-relative app-bar-expand-md" data-role="appbar">
        <a href="#" class="brand no-hover fg-white-hover order-1"><span class="mif-laptop fg-yellow mif-5x"></span></a>
        <div class="app-bar-item d-none d-flex-md order-2">
            <h2 style="color: #fdf9a8"><b>SOPORTE</b></h2>
        </div>
        <ul class="app-bar-menu order-4 order-md-3">
            <li><a href="<?php echo site_url('Tec_En_control/')?>" class="fg-yellow-hover"
                   data-role="hint"
                   data-hint-text="Registro de actividades"
                   data-hint-position="bottom"
                >REGISTRO</a></li>
            <li><a href="<?php echo site_url('Tec_En_control/historial_index')?>" class="fg-yellow-hover"
                   data-role="hint"
                   data-hint-text="Historial de registros"
                   data-hint-position="bottom"
                >HISTORIAL</a></li>
            <li><a href="<?php echo site_url('Tec_En_control/reporte_index')?>" class="fg-yellow-hover"
                   data-role="hint"
                   data-hint-text="Reportes por técnico"
                   data-hint-position="bottom"
                >TECNICOS</a></li>
        </ul>
        <div class="app-bar-container ml-auto order-3 order-md-4">
            <div class="app-bar-container">
                <a class="app-bar-item dropdown-toggle marker-light pl-1 pr-5" href="#">
                    <span class="mif-user mif-2x"></span>
                </a>
                <ul class="v-menu place-right" data-role="dropdown">
                    <li class="text-center"><b><?php echo $usu_nombres.' '.$usu_paterno;?></b></li>
                    <li class="divider"></li>
                    <li><a href="#" class="app-bar-item" onclick="Metro.dialog.open('#Dialog_Perfil')"><span class="mif-user  mif-lg"></span>&nbsp;&nbsp; Perfil de Usuario</a></li>
                    <li class="divider"></li>
                    <li><a class="app-bar-item" href="<?php echo base_url();?>index.php/Login_control/close_session"><span class="mif-switch  mif-lg"></span>&nbsp;&nbsp; Salir</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <div class="dialog" data-role="dialog" id="Dialog_Perfil"data-width="400">
        <div class="dialog-title"><b>DATOS DE USUARIO</b></div>
        <div class="dialog-content" style="overflow-y: scroll;height: 310px;">
            <div class="card" style="background-color: #dbdbdb">
                <div class="card-header">
                    <div class="avatar">
                        <?php
                            if ($this->session->userdata('usu_genero') == 'F')
                            {
                                echo '<img src="'.base_url().'assets/svg/mujer.svg">';
                            }else {
                                echo '<img src="'.base_url().'assets/svg/hombre.svg">';
                            }
                        ?>
                    </div>
                    <div class="name">
                        <b>USUARIO:</b> <?php echo $this->session->userdata('hab_nombreusuario');
                        ?><br>
                        <b>ROL: </b><?php echo $this->session->userdata('rol_nombre'); ?><br>
                    </div>
                </div>
                <div class="card-content p-2">
                    <b>NOMBRES:</b> <?php echo $this->session->userdata('usu_nombres');?><br>
                    <b>APELLIDO PATERNO: </b><?php echo $this->session->userdata('usu_paterno');?><br>
                    <b>APELLIDO MATERNO: </b><?php echo $this->session->userdata('usu_materno');?><br>
                    <b>C.I.: </b><?php echo $this->session->userdata('usu_ci');?>
                                <?php
                                if ($this->session->userdata('dep_id')==1)
                                    echo ('LP');
                                elseif ($this->session->userdata('dep_id')==2)
                                    echo ('CB');
                                elseif ($this->session->userdata('dep_id')==3)
                                    echo ('SC');
                                elseif ($this->session->userdata('dep_id')==4)
                                    echo ('OR');
                                elseif ($this->session->userdata('dep_id')==5)
                                    echo ('CH');
                                elseif ($this->session->userdata('dep_id')==6)
                                    echo ('BN');
                                elseif ($this->session->userdata('dep_id')==7)
                                    echo ('PT');
                                elseif ($this->session->userdata('dep_id')==8)
                                    echo ('TJ');
                                elseif ($this->session->userdata('dep_id')==9)
                                    echo ('PA');
                                else
                                    echo ('OTRO');
                                ?><br>
                    <b>SECRETARIA ASIGNADA: </b><?php echo $this->session->userdata('sec_nombre');?><br><br>
                    <b>ESTADO: </b><?php
                                        if($this->session->userdata('hab_estado') == true)
                                            echo ('HABILITADO');
                                        else
                                            echo ('DESHABILITADO');
                                    ?><br>
                    <b>FECHA DE HABILITACION: </b><?php
                                                    $pg_date = $this->session->userdata('hab_fecha');
                                                    $date_obj = date_create_from_format('Y-m-d', $pg_date);
                                                    $date = date_format($date_obj, 'd-m-Y');
                                                    echo $date;
                                                    ?>
                </div>
            </div>
        </div>
    </div>
</div>