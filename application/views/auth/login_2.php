<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets')?>/images/3485logo_header.ico">

    <title>Falixso Services</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets'); ?>/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= base_url('assets'); ?>/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets'); ?>/css/estilos.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="<?=base_url('assets'); ?>/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?= base_url('assets'); ?>/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<!-- <body  style=" background-image: url('https://images.alphacoders.com/572/572146.jpg'); background-size: auto">  -->
  
<body  style=" background-image: url('https://images.alphacoders.com/572/572721.jpg'); background-size: auto">  
<br>    <br><br><br><br><br><br>
<div class="container " >

<div  style="background-image: url('https://images6.alphacoders.com/376/376931.jpg')" >
    
     <div class="row">
        <div class="col-md-12">
            <div class="col-md-5"><br><br>
                <center><img  src="<?= base_url('assets'); ?>/images/iconos/falixso1.png"/></center>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <?php echo form_open("autenticacion/login"); ?>
            <div id="infoMessage"><?php echo $message; ?></div>
                <div class="col-md-5">
                    <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <?php echo form_input($identity,false,'style="width: 100%" class="form-control" placeholder="Ingrese su Usuario"' ); ?>
                </div></div>
        </div> 
    </div> <br>
     <div class="row">
        <div class="form-group col-md-12 text-center">
            <div class="col-lg-5">
                <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <?php echo form_input($password,false,'style="width: 100%" class="form-control" placeholder="Ingrese su Contraseña"'); ?>
            </div> </div>
        </div> 
    </div> <br>
    <div class="row">
        <div class="form-group col-md-12 text-center">
            <div class="col-md-5 ">
                 <?php echo form_submit('submit', lang('login_submit_btn'),'style="width: 100%" class="btn btn-lg bg-primary btn-block"'); ?>
            </div>
        </div>
            <?php echo form_close(); ?>
    </div>  
</div>
</div>    <br><br>
<!-- <div class="container">
    <div class="row">
        <div class="col-md-12">
        
            <img src="<?= base_url('assets'); ?>/images/iconos/falixso.png"/>
            
        </div>
    </div>
    <div class="row">
                
        <div class="col-md-12 text-center">
            <?php // echo form_open("autenticacion/login"); ?>
            <div id="infoMessage"><?php echo $message; ?></div>
                <div class="form-group-lg col-md-6">
                    <!--label for="inputEmail" class="sr-only">Email </label-->
                    <!--input type="email" id="inputEmail" class="form-control" style="width: 80%" placeholder="Email" required autofocus-->
                    <?php  //echo form_input($identity,false,'style="width: 80%" class="form-control" placeholder="Ej. Raul.Perez"'); ?>
  <!--              </div>
                <div class="form-group-lg col-md-6">
                    <!--label for="inputPassword" class="sr-only">COntraseña</label-->
                    <!--input type="password" id="inputPassword" style="width: 80%" class="form-control" placeholder="Contraseña" required-->
                    <?php //echo form_input($password,false,'style="width: 80%" class="form-control" placeholder="Contraseña"'); ?>
   <!--             </div>
                <br><br><br><br><br><br>
                <div class="form-group col-md-12 text-center">
                    <div class="col-md-4 ">
                    </div>
                    <div class="col-md-4 ">
                        <!--button class="btn btn-lg btn-primary btn-block" style="width: 100%" type="submit">Sign in
                        </button-->
                        <?php // echo form_submit('submit', lang('login_submit_btn'),'class="btn btn-lg bg-primary btn-block"'); ?>
  <!--                  </div>
                    <div class="col-md-4 ">
                    </div>
                </div>
            <?php //echo form_close(); ?>
        </div>
         <div class="alert alert-info col-md-12" role="alert">
            <div class="col-md-6">
                 <p>Si usted no tiene una cuenta de usuario haga clic <a class="btn btn-primary" href='<?php //base_url('autenticacion/crear_usuario'); ?>'>aquí</a></p>
             </div>
             <div class="col-md-6">
                 <p><a class="btn btn-primary" href='<?php //base_url('autenticacion/cambiar_password'); ?>'>Resetear contraseña</a></p>
             </div>

          
        </div>

    </div>

</div>  /container -->


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url('assets'); ?>/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
