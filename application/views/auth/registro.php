<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registro de Proveedores</title>

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
    <script src="<?= base_url('assets') ?>/js/webservice_xavier.js" type="text/javascript"></script>
    <script src="<?= base_url('assets') ?>/loading/src/js/HoldOn.js" type="text/javascript"></script>
       <?php
    $root = "http://".$_SERVER['HTTP_HOST'];
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    ?>

    <script type="text/javascript">
        var base_url="<?=$root?>";
    </script>

</head>

<body style=" background-position: center;  background-repeat: no-repeat;  background-size: cover; height: 100%; background-image: url(https://www.muralswallpaper.com/app/uploads/yellow-ombre-fade-design-plain-820x532.jpg);" >
    

<div class="container">
    
    <div class="row">
        <div class="col-md-12 text-center">
            <!-- Main content -->

            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                                    <img src="<?= base_url('assets'); ?>/images/iconos/koala.png" width="100px" height='100px'>

                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title"> Registro  </h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div id="infoMessage"></div>

                            <form id="registro_form" method="post" accept-charset="utf-8">
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Nombre Comercial:</label> <br>
                                            <input  type="text" id="n_comercial" class="form-control"
                                                   placeholder="La Delicia del Bolón">
                                        </div>
                                    </div>

                                   
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email:</label> <br>
                                            <input  type="text" id="correo" class="form-control"
                                                   placeholder="myservicio@gmail.gob.ec">
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
                                            <label for="company">Categoría:</label> <br>
                                            <select class="form-control"  id="cmb_categoria" onchange="combo_subcategoria_letswork()">
                                                <option value="0"> Seleccione Área</option>
                                                <?php foreach ($array_areas as $areas){?>
                                                    <option value="<?=$areas['id_categoria'] ?>"><?=$areas['nombre'] ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company">SubCategoria:</label> <br>
                                            <select class="form-control"  id="cmb_subcategoria">
                                                <option value="0"> Seleccione Subcategoria</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company">Detalle los servicios ofrecidos (Para poder ser categorizado/recategorizado ):</label> <br>
                                            <textarea class="form-control"  id="detalle" type"text" ></textarea>
                                        </div>
                                    </div>
                                    
<!--
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password">Logo/Imagen:</label> <br>
                                            <input type="password" maxlength="20" name="password" value="" id="password"
                                                   class="form-control" placeholder="Logo del Emprendimiento">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirm">Brochure (formato pdf):</label> <br>
                                            <input type="password" maxlength="20" name="password_confirm" value=""
                                                   id="password_confirm" class="form-control"
                                                   placeholder="Catalogo de Servicios (opcional)" >
                                        </div>
                                    </div>
                                </div>   -->
                                <br><br>
                                <div class="box-footer">
                                    <div class="col-md-2">
                                        <a id="btnGuardaUsuario" class="btn btn-success" onclick='registro_lets_work()'><i class="fa fa-save"></i> Registrarse</a>
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




<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="<?= base_url('assets'); ?>/js/ie10-viewport-bug-workaround.js"></script>
</body>


</html>
