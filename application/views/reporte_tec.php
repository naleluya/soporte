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
        <?php foreach($tecnicos as $tec) {?>
        <div class="frame">
            <div class="heading"><?php echo $tec->usu_nombres;?></div>
            <div class="content">
                <div class="p-2"><button class="button success drop-shadow rounded">Exportar a excel</button></div>
            </div>
        </div>
        <?php }?>
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