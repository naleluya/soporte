<div class="pt-16 border-bottom bd-default bg-ligth">
    <div class="container fluid">
        <div class="row">
            <div class="cell-md-6 text-center-md text-left pt-2">
                <h3 class="display1">REGISTRO DE SOPORTE</h3>
            </div>
        </div>
        <div class="example pb-0">
            <form data-role="validator" method="post" class="mb-2" action="<?php echo site_url('Tec_control/save_registro');?>" id="formSoporte">
                <p class="text-bold">SOPORTE</p>
                <div class="row mb-3">
                    <div class="cell-md-4">
                        <input type="radio" data-role="radio" data-caption="RED" name="tipo_soporte" value="RED">
                    </div>
                    <div class="cell-md-4">
                        <input type="radio" data-role="radio" data-caption="SOFTWARE" name="tipo_soporte" value="SOFTWARE">
                    </div>
                    <div class="cell-md-4">
                        <input type="radio" data-role="radio" data-caption="HARDWARE" name="tipo_soporte" value="HARDWARE" checked>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="cell-md-4">
                        <label><b>SOLICITANTE</b></label>
                        <input type="text" class="text-upper" name="solicitante" id="solicitante" data-validate="required" placeholder="Ingrese el nombre del funcionario solicitante">
                        <span class="invalid_feedback">
                            <span class="mif-warning"></span>Ingresar Solicitante
                        </span>
                    </div>
                    <div class="cell-md-2">
                        <label><b>COD GAMEA</b></label>
                        <input type="number" class="mb-1" name="cod_gamea" id="cod_gamea">
                        <span class="invalid_feedback">
                            <span class="mif-warning"></span>Cod Gamea
                        </span>
                    </div>
                    <div class="cell-md-3">
                        <label><b>SERVICIO</b></label>
                        <select name="servicio" id="servicio" data-role="select" data-validate="required">
                            <option value="0">--Seleccione--</option>
                            <option value="MANTENIMIENTO CORRECTIVO">MANTENIMIENTO CORRECTIVO</option>
                            <option value="MANTENIMIENTO PREVENTIVO">MANTENIMIENTO PREVENTIVO</option>
                            <option value="INSTALACION">INSTALACION</option>
                            <option value="REINSTALACION">REINSTALACION</option>
                        </select>
                        <span class="invalid_feedback">
                            <span class="mif-warning"></span>Ingresar servicio
                        </span>
                    </div>
                    <div class="cell-md-3">
                        <label><b>FECHA SOLICITUD</b></label>
                        <input name="fecha_solicitud" data-role="datepicker" data-locale="es-ES">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="cell-md-4">
                        <label><b>DESCRIPCION DE LA SOLICITUD</b></label>
                        <textarea class="text-upper" name="descripcion" data-validate="required"></textarea>
                        <span class="invalid_feedback">
                            <span class="mif-warning"></span>Ingresar descripcion
                        </span>
                    </div>
                    <div class="cell-md-4">
                        <label><b>TRABAJO REALIZADO</b></label>
                        <textarea class="text-upper" name="trabajo_realizado" data-validate="required"></textarea>
                        <span class="invalid_feedback">
                            <span class="mif-warning"></span>Ingresar Trabajo realizado
                        </span>
                    </div>
                    <div class="cell-md-4">
                        <label><b>OBSERVACIONES</b></label>
                        <textarea class="text-upper" name="observaciones" ></textarea>                        
                    </div>
                </div>
                <div class="form-group">
                    <button class="button success rounded drop-shadow">GUARDAR REGISTRO</button>
                    <input type="button" class="button rounded drop-shadow" value="CANCELAR" id="limpiar" onclick="resetform()">
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</body>
<script>
    function resetform() {
     $("form select").each(function() { this.selectedIndex = 0 });
     $("form input[type=text] , form textarea").each(function() { this.value = '' });
}
</script>
</html