<div class="pt-16 border-bottom bd-default bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="cell-md-12 text-center-md text-left pt-2">
                <h4 class="display1">HISTORIAL DE REGISTROS</h4>
            </div>
        </div>
    </div>
    <div class="container">
        <div style="overflow-y: scroll; overflow: scroll; height: 560px;">
            <table class="table row-border table-border row-hover tablesorter" id="miTabla" style="font-size: 9pt;">
                <thead style="background-color: #d8d8d8; ">
                    <tr>
                        <th style="font-size: 15px;">#</th>
                        <th style="font-size: 15px;">CODIGO<br>INFORME</th>
                        <th style="font-size: 15px;">TIPO<br>MATTO.</th>
                        <th style="font-size: 15px;">SERVICIO</th>
                        <th style="font-size: 15px;">SOLICITANTE</th>
                        <th style="font-size: 15px;">FECHA<br>SOLICITUD</th>
                        <th style="font-size: 15px;">DESCRIPCION<br>SOLICITUD</th>
                        <th style="font-size: 15px;">TRABAJO<br>REALIZADO</th>
                        <th style="font-size: 15px;">OBSERVACIONES</th>
                        <th style="font-size: 15px;">PDF</th>
                        <th style="font-size: 15px;">ACCION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($historial as $his) {
                        ?>
                        <tr>
                            <td><?php echo  $i; ?></td>
                            <td><b><?php echo 'US/' . $this->session->userdata('sec_nombre') . '/' . $his->sop_informe . '/' . $his->sop_gestion; ?></b></td>
                            <td><?php echo  $his->sop_tipo_sop; ?></td>
                            <td><?php echo  $his->sop_servicio; ?></td>
                            <td><span class="mif-user mif-2x"></span> <?php echo  $his->sop_funcionario_resp; ?></td>
                            <td><span class="mif-calendar mif-2x"></span> <?php echo  $his->sop_fecha_ingreso; ?></td>
                            <td><?php echo  $his->sop_descripcion; ?></td>
                            <td><?php echo  $his->sop_trab_realizado; ?></td>
                            <td><?php echo  $his->sop_observaciones; ?></td>
                            <td><a href="<?php echo site_url("Tec_control/reprint_pdf/" . $his->sop_id); ?>" target="_blank"><span class="mif-file-pdf fg-red mif-5x"></button></a></td>
                            <td><button onclick="editReg(<?php echo $his->sop_id; ?>)" class="button success cycle drop-shadow"><span class="mif-pencil"></span></button></td>
                            <?php $i++; ?>
                        <?php } ?>
                    <tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal EDIT -->
<div data-role="dialog" id="regEdit" style="background-color: #f4eeb2" data-width="800">
    <div class="dialog-title" style="font-weight:900;">ACTUALIZAR DATOS</div>
    <div class="dialog-content">
        <form data-role="validator" method="post" action="<?php echo site_url('Tec_control/edit_Sop'); ?>">
            <input type="hidden" name="sop_id">
            <div class="row mb-4">
                <div class="cell-md-3">
                    <input type="radio" data-role="radio" data-caption="RED" name="e_tipo_soporte" value="RED">
                </div>
                <div class="cell-md-3">
                    <input type="radio" data-role="radio" data-caption="SOFTWARE" name="e_tipo_soporte" value="SOFTWARE">
                </div>
                <div class="cell-md-3">
                    <input type="radio" data-role="radio" data-caption="HARDWARE" name="e_tipo_soporte" value="HARDWARE">
                </div>
                <div class="cell-md-3">
                    <input type="radio" data-role="radio" data-caption="DOMINIO" name="e_tipo_soporte" value="DOMINIO">
                </div>
            </div>
            <div class="row mb-3">
                <div class="cell-md-5">
                    <label><b>SOLICITANTE</b></label>
                    <input type="text" class="text-upper" name="e_solicitante" id="solicitante" data-validate="required" placeholder="Ingrese el nombre del funcionario solicitante">
                    <span class="invalid_feedback">
                        <span class="mif-warning"></span>Ingresar Solicitante
                    </span>
                </div>
                <div class="cell-md-4">
                    <label><b>C.I.</b></label>
                    <input type="number" name="e_ci_funcionario" id="ci_funcionario">
                    <span class="invalid_feedback">
                        <span class="mif-warning"></span> Ingrese C.I.
                    </span>
                </div>
                <div class="cell-md-3">
                    <label><b>EMITIDO</b></label>
                    <select name="e_ci_emitido" id="e_ci_emitido">
                        <option value="1">LP</option>
                        <option value="2">CB</option>
                        <option value="3">SC</option>
                        <option value="4">OR</option>
                        <option value="5">CH</option>
                        <option value="6">BN</option>
                        <option value="7">PT</option>
                        <option value="8">TJ</option>
                        <option value="9">PN</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="cell-md-3">
                    <label><b>COD GAMEA</b></label>
                    <input type="number" class="mb-1" name="e_cod_gamea" id="cod_gamea" data-validate="required number">
                    <span class="invalid_feedback">
                        <span class="mif-warning"></span>Cod Gamea
                    </span>
                </div>
                <div class="cell-md-5">
                    <label><b>CARGO</b></label>
                    <input class="text-upper" type="text" name="e_cargo_fun" data-validate="required">
                </div>
                <span class="invalid_feedback">
                    <span class="mif-warning"></span>Ingresar cargo
                </span>
                <div class="cell-md-4">
                    <label><b>SERVICIO</b></label>
                    <select name="e_servicio" id="e_servicio" data-validate="required">
                        <option value="">--Seleccione--</option>
                            <option value="MANTENIMIENTO CORRECTIVO">MANTENIMIENTO CORRECTIVO</option>
                            <option value="MANTENIMIENTO PREVENTIVO">MANTENIMIENTO PREVENTIVO</option>
                            <option value="INSTALACION">INSTALACION</option>
                            <option value="REINSTALACION">REINSTALACION</option>
                            <option value="MIGRACION A DOMINIO">MIGRACION A DOMINIO</option>
                    </select>
                    <span class="invalid_feedback">
                        <span class="mif-warning"></span>Ingresar servicio
                    </span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="cell-md-4">
                    <label><b>DESCRIPCION DE LA SOLICITUD</b></label>
                    <input class="text-upper" name="e_descripcion" data-validate="required">
                    <span class="invalid_feedback">
                        <span class="mif-warning"></span>Ingresar descripcion
                    </span>
                </div>
                <div class="cell-md-4">
                    <label><b>TRABAJO REALIZADO</b></label>
                    <textarea class="text-upper" name="e_trabajo_realizado" data-validate="required"></textarea>
                    <span class="invalid_feedback">
                        <span class="mif-warning"></span>Ingresar Trabajo realizado
                    </span>
                </div>
                <div class="cell-md-4">
                    <label><b>OBSERVACIONES</b></label>
                    <textarea class="text-upper" name="e_observaciones"></textarea>
                </div>
            </div>
            
            <div class="dialog-actions">
        <button type="submit" class="button primary rounded drop-shadow">Aceptar</button>
        </form>

        <button class="button secondary js-dialog-close rounded drop-shadow">Cancelar</button>
    </div>
</div>

</body>
<script>
    $(document).ready(function() {
        $("#miTabla").tablesorter();
    });

    function reprintPDF(sop_id) {

    }
    function editReg(sop_id)
    {
        $.ajax({
            url: "<?php echo site_url('Tec_control/get_sop/'); ?>"+sop_id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $('[name="e_tipo_soporte"]:checked').val(data.sop_tipo_sop);
                $('[name="e_solicitante"]').val(data.sop_funcionario_resp);
                $('[name="e_ci_funcionario"]').val(data.sop_fun_res_ci);
                $('#e_ci_emitido').val(data.sop_fun_res_emitido);
                $('[name="e_cod_gamea"]').val(data.sop_cod_gamea);
                $('[name="e_cargo_fun"]').val(data.sop_cargo_fun);
                $('#e_servicio').val(data.sop_servicio).selectmenu('refresh', true);
                $('[name="e_descripcion"]').val(data.sop_descripcion);
                $('[name="e_trabajo_realizado"]').val(data.sop_trab_realizado);
                $('[name="e_observaciones"]').val(data.sop_observaciones);
                $('[name="sop_id"]').val(data.sop_id);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error al obtener datos de ajax');
            }
        });
        Metro.dialog.open('#regEdit');
    }
</script>

</html>