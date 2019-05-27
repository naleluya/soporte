<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/mif/favicon.ico">
    <!--    css metro-->

    <link href="<?php echo base_url();?>assets/css/metro.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/metro-colors.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/metro-rtl.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/metro-icons.min.css" rel="stylesheet">
    <!--    js jquery-->
    <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.min.js"></script>
    <!--    js metro-->
    <script src="<?php echo base_url();?>assets/js/metro.min.js"></script>
    <title>SOPORTE</title>

    <style>
        .login-form {
            width: 350px;
            height: auto;
            top: 50%;
            margin-top: -160px;
        }
    </style>
</head>
<body class="h-vh-100 bg-steel">
<form class="login-form p-6 mx-auto border bd-default win-shadow"
      data-role="validator" style="background-color: #e5e5e5;"
      action=""
      method="post"
      data-clear-invalid="2000"
      data-on-error-form="invalidForm"
      data-on-validate-form="validateForm" >
    <span class="mif-laptop mif-6x place-right" style="margin-top: -10px;"></span>
    <h2 class="text-light">Soporte</h2>
    <hr class="thin mt-4 mb-4 bg-black">
    <div class="form-group">
        <input type="text" name="hab_nombreusuario" data-role="input" data-prepend="<span class='mif-user fg-darkBlue mif-3x'>" placeholder="Ingrese Usuario" data-validate="required">
    </div>
    <div class="form-group">
        <input type="password" name="hab_password" data-role="input" data-prepend="<span class='mif-key fg-darkBlue mif-3x'>" placeholder="ingrese password" data-validate="required">
    </div>
    <div style="background-color: #c11e28;display:<?php echo $display;?>;margin-top: 2%;margin-bottom: 0%;padding-bottom: 0%;">
        <span style="color:white; font-size:small;">Usuario y/o Contraseña Incorrectos</span>
    </div>
    <div class="form-group mt-10">
        <button class="button alert outline large rounded drop-shadow"><span class="mif-lock"></span> INGRESAR</button>
    </div>
</form>
</div>

<script>
    function invalidForm(){
        var form  = $(this);
        form.addClass("ani-ring");
        setTimeout(function(){
            form.removeClass("ani-ring");
        }, 1000);
    }
    function validateForm(){
        $(".login-form").animate({
            opacity: 0
        });
    }
</script>

</body>
</html>