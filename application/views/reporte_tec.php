<div class="pt-16 border-bottom bd-default bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="cell-md-12 text-center-md text-left pt-2">
                <h4 class="display1">REPORTE DE TECNICOS</h4>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div data-role="accordion" data-one-frame="true" data-show-active="true">
        <?php foreach ($tecnicos as $tec) { ?>
            <div class="frame">
                <div class="heading"><b><?php echo $tec->sec_nombre; ?></b> - <?php echo $tec->usu_nombres; ?> <?php echo $tec->usu_paterno; ?></div>
                <div class="content">
                    <div class="p-2">
                        <div class="row mb-4">
                            <div class="cell-md-3">
                                <form action="<?php echo site_url("Tec_En_control/dExcel/" . $tec->usu_id); ?>">
                                    <button class="button success drop-shadow rounded">Exportar a excel</button>
                                </form>
                            </div>
                            <?php
                            $h = 0;
                            $s = 0;
                            $r = 0;
                            $d = 0;
                            $t = 0;
                            $hh = 0;
                            $ss = 0;
                            $rr = 0;
                            $dd = 0;
                            foreach ($registro as $reg) {
                                if ($reg->usu_id == $tec->usu_id) {
                                    if ($reg->sop_tipo_sop == "HARDWARE") {
                                        $h = $h + 1;
                                    } else {
                                        if ($reg->sop_tipo_sop == "SOFTWARE") {
                                            $s = $s + 1;
                                        } else {
                                            if ($reg->sop_tipo_sop == "RED") {
                                                $r = $r + 1;
                                            } else {
                                                if ($reg->sop_tipo_sop == "DOMINIO") {
                                                    $d = $d + 1;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $t = $h + $s + $r + $d;
                            if ($h == 0)
                                $hh = 0;
                            else
                                $hh = round(($h / $t) * 100);
                            if ($s == 0)
                                $ss = 0;
                            else
                                $ss = round(($s / $t) * 100);
                            if ($r == 0)
                                $rr = 0;
                            else
                                $rr = round(($r / $t) * 100);
                            if ($d == 0)
                                $dd = 0;
                            else
                                $dd = round(($d / $t) * 100);

                            ?>
                            <div class="cell-md-2">
                                <label><strong style="color : #49649f;">HARDWARE - <?php echo $h; ?></strong> </label>
                                <div id="donut1" data-role="donut" data-value="<?php echo $hh; ?>" data-hole=".6" data-stroke="#f5f5f5" data-animate="10"></div>
                            </div>
                            <div class="cell-md-2">
                                <label><strong style="color : #9C27B0">SOFTWARE - <?php echo $s; ?></strong> </label>
                                <div id="donut2" data-role="donut" data-value="<?php echo $ss; ?>" data-hole=".6" data-stroke="#f5f5f5" data-fill="#9C27B0" data-animate="10"></div>
                            </div>
                            <div class="cell-md-2">
                                <label><strong style="color : #ae4800">REDES- <?php echo $r; ?></strong> </label>
                                <div id="donut3" data-role="donut" data-value="<?php echo $rr; ?>" data-hole=".6" data-stroke="#f5f5f5" data-fill="#ae4800" data-animate="10"></div>
                            </div>
                            <div class="cell-md-2">
                                <label><strong style="color : #4CAF50">DOMINIO - <?php echo $d; ?></strong> </label>
                                <div id="donut4" data-role="donut" data-value="<?php echo $dd; ?>" data-hole=".6" data-stroke="#f5f5f5" data-fill="#4CAF50" data-animate="10"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

</body>
<script>

</script>

</html>