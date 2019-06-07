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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($historial as $his) {
                        ?>
                        <tr>
                            <td><?php echo  $i; ?></td>
                            <td><b><?php echo 'US/'. $this->session->userdata('sec_nombre') .'/'.$his->sop_informe.'/'. $his->sop_gestion; ?></b></td>
                            <td><?php echo  $his->sop_tipo_sop; ?></td>
                            <td><?php echo  $his->sop_servicio; ?></td>
                            <td><span class="mif-user mif-2x"></span> <?php echo  $his->sop_funcionario_resp; ?></td>
                            <td><span class="mif-calendar mif-2x"></span> <?php echo  $his->sop_fecha_ingreso; ?></td>
                            <td><?php echo  $his->sop_descripcion; ?></td>
                            <td><?php echo  $his->sop_trab_realizado; ?></td>
                            <td><?php echo  $his->sop_observaciones; ?></td>
                            <td><a href="<?php echo site_url("Tec_control/reprint_pdf/".$his->sop_id);?>" target="_blank"><span class="mif-file-pdf fg-red mif-5x"></button></a></td>
                            <?php $i++; ?>
                        <?php } ?>

                    <tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
<script>
    $(document).ready(function() {
        $("#miTabla").tablesorter();
    });

    function reprintPDF(sop_id) {
       
    }
</script>

</html>