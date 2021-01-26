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

    <title>Creación Usuarios</title>

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets'); ?>/css/bootstrap.min.css" rel="stylesheet">



    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="<?= base_url('assets'); ?>/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets'); ?>/css/estilos.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets'); ?>/loading/src/css/HoldOn.css" type="text/css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="<?=base_url('assets'); ?>/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?= base_url('assets'); ?>/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery 2.0.2 -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    <!-- jQuery UI 1.10.3 -->
    <script src="<?= base_url('assets') ?>/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>

    <!-- jQuery UI 1.10.3 -->
    <script src="<?=base_url('assets')?>/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?= base_url('assets') ?>/js/scriptGuardaUsuarios.js" type="text/javascript"></script>
    <script src="<?= base_url('assets') ?>/loading/src/js/HoldOn.js" type="text/javascript"></script>

</head>

<body>

<div class="container">
    <div class="row">
        <div class="col-md-12">
           <!-- <img src="<?= base_url('assets'); ?>/images/iconos/logo_arcsa.png">  -->
            <img src="<?= base_url('assets'); ?>/images/Banner-login.png"/>
        
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"> Crear Usuario </h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div id="infoMessage"></div>

                            <form id="crear_usuario_form" method="post" accept-charset="utf-8">
                                <div class="box-body">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="first_name">Nombres:</label> <br>
                                            <input onKeyPress="return sololetras(event)" type="text" maxlength="20" name="first_name" value="" id="first_name"
                                                   class="form-control" placeholder="Nombres">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="last_name">Apellidos:</label> <br>
                                            <input type="text" onKeyPress="return sololetras(event)" maxlength="20" name="last_name" value="" id="last_name"
                                                   class="form-control" placeholder="Apellidos">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Cédula:</label> <br>
                                            <input type="text" onKeyPress="return soloNumeros(event)" maxlength="10" name="cedula" value="" id="cedula" class="form-control"
                                                   placeholder="Cédula">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Usuario mail control sanitario:</label> <br>
                                            <input type="text" onKeyPress="return sololetras(event)" maxlength="30" name="email" value="" id="email" class="form-control"
                                                   placeholder="Ej. nombre.apellido">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="email">Email:</label> <br>
                                            <input readonly="readonly" type="text" maxlength="1" name="-" value="" id="-" class="form-control"
                                                   placeholder="@controlsanitario.gob.ec">
                                        </div>
                                    </div>

                                       <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company">Área:</label> <br>
                                            <select class="form-control" name="company" id="company">
                                                <option value=""> Seleccione Área</option>
                                                <?php foreach ($array_areas as $areas){?>
                                                    <option value="<?=$areas['id'] ?>"><?=$areas['description'] ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Teléfono:</label> <br>
                                            <input type="text" onKeyPress="return soloNumeros(event)" maxlength="10" name="phone" value="" id="phone" class="form-control"
                                                   placeholder="Telefono">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Password:</label> <br>
                                            <input type="password" maxlength="20" name="password" value="" id="password"
                                                   class="form-control" placeholder="Contraseña">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirm">Confirmar Password:</label> <br>
                                            <input type="password" maxlength="20" name="password_confirm" value=""
                                                   id="password_confirm" class="form-control"
                                                   placeholder="Confirmar contraseña">
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="col-md-2">
                                        <a id="btnGuardaUsuario" class="btn btn-success"><i class="fa fa-save"></i> Crear
                                            Usuario</a>
                                    </div>

                                    <div class="col-md-2"><a href='<?= base_url('autenticacion/login'); ?>' class="btn btn-primary"><i class="fa fa-save"></i> Regresar Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>

                    <!--/.col (right) -->
                </div>
                <!-- /.row -->


            </section>
            <!-- /.content -->
        </div>

    </div>

</div> <!-- /container -->


<div class="modal fade" style="z-index: 2500" id="modal-mensajes" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mensaje</h4>
            </div>
            <div class="modal-body" id="modal_body_mensaje">

            </div>
            <div class="modal-footer">

                <a type="button" class="btn btn-warning" id="btnCerrarModalMensaje" data-dismiss="modal"><i
                            class="fa fa-times-circle"></i> Cerrar</a>
            </div>
        </div>
    </div>
</div>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url('assets'); ?>/js/ie10-viewport-bug-workaround.js"></script>
</body>


</html>
