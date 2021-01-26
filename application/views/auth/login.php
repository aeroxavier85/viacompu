<!DOCTYPE html>
<html lang="en">
<head><meta charset="euc-jp">
    
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets')?>/images/logo.png">

    <title>Viacompu</title>

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
  
<!-- <body  style=" background-image: url('https://images.alphacoders.com/572/572721.jpg'); background-size: auto">    -->
<body>  
<br>    <br><br>
<div class="container " >

<!--<div  style="background-image: url('https://images6.alphacoders.com/376/376931.jpg')" >  -->
    <div class="row">
         <div class="col-md-4"></div>
         
         <div class="col-md-4"><br>
                <div class="col-md-12">
                    <center><img  src="<?= base_url('assets'); ?>/images/logo.png"  width="100%" /></center><br>
                </div>
                <div class="form-group col-md-12 text-center">
                    <?php echo form_open("autenticacion/login"); ?>
                    <div id="infoMessage"><?php echo $message; ?></div>
                    
                        <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                <?php echo form_input($identity,false,'style="width: 100%" class="form-control" placeholder="Ingrese su Usuario"' ); ?>
                        </div>
                   
                </div> 
                <div class="form-group col-md-12 text-center">
            
                    <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                <?php echo form_input($password,false,'style="width: 100%" class="form-control" placeholder="Ingrese su Contraseña"'); ?>
                    </div>
                </div>
                
                <div class="form-group col-md-12 text-center">
                  <div class="input-group col-md-12"><center>
                        <?php echo form_submit('submit', lang('login_submit_btn'),' class="btn btn-primary col-md-12"'); ?></center>
                    </div>  
                     <!--   <div class="input-group">
                        <center><input class="btn btn-lg bg-primary btn-block" type="button" value="Login" onclick="alert('Estimado Usuario, su cuenta a Expirado . Pongase en contacto con el Webmaster')"></center>
                    </div>   --> 
                </div>
                    <?php echo form_close(); ?>
                
         </div> <br><br><br><br>
         
    </div>
 <!-- <div class="alert alert-danger" role="alert">
    <p>Estimado Cliente:<br>
    Le recordamos que su subscripci&oacuten anual aun no ha sido renovada, el servicio caducar&aacute el 13/06/2019.<br>
    Favor contactar al telefono No.0996807361 a fin de poder agilitar la renovaci&oacuten de los servicios.</p>
</div>
-->
</div>  



<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url('assets'); ?>/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
