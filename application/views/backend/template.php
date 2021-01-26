<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?=base_url('assets')?>/images/logo.png">
    <!-- <title><?= $title ?></title> -->
    <title>ViaCompu</title>


 <!-- ########## DATA TABLE PARA DESCARGAR########## -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css"/>





<!-- #################### -->


     <link rel="stylesheet" href="<?=base_url('assets'); ?>/js/plugins/select2/css/select2.min.css">
<!--     <link rel="stylesheet" href="<?=base_url('assets'); ?>/js/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">  -->
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/bootstrap.min.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/font-awesome.min.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/ionicons.min.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/morris/morris.css" type="text/css" >

    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/fullcalendar/fullcalendar.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/fullcalendar/fullcalendar.print.css" type="text/css" >

    <link rel="stylesheet" href="<?=base_url('assets'); ?>/js/plugins/DataTable_Nuevo/datatables.min.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/js/plugins/datepicker/css/bootstrap-datepicker.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/AdminLTE.css" type="text/css" >
    <link rel="stylesheet" href="<?=base_url('assets'); ?>/css/estilos.css" type="text/css" >

     <link rel="stylesheet" href="<?=base_url('assets'); ?>/loading/src/css/HoldOn.css" type="text/css" >



    <?= $_styles ?><!--cargamos los css-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <?php
    $root = "http://".$_SERVER['HTTP_HOST'];
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
    ?>




    <script type="text/javascript">
        var base_url="<?=$root?>";
    </script>
</head>


<body class="skin-blue">
<!-- header logo: style can be found in header.less -->
<header class="header">
    <a href="../" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <!--span style="font-family: Arial;">ARCSA</span-->
        <!--<span style="font-family: Arial;"><img src="<?=base_url('assets/images')?>/bs.jpg" style="width: 98%;"></span>  -->
        <span style="font-family: Arial;"><img src="<?=base_url('assets/images')?>/logo2.png" style="width: 98%;"></span> 
    </a>
    <!-- Header Navbar: style can be found in header.less -->

    <?= $header ?>
</header>

<div id="imgwait" style="display:none; z-index: 2500">
    <img src="<?=base_url('assets')?>/images/loading.gif"/>
</div>
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <?= $sidebar ?>

    <?= $content ?>
</div><!-- ./wrapper -->

<?php // echo $_scripts ?><!--cargamos los js-->


<!-- jQuery 2.0.2 -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!-- jQuery UI 1.10.3 -->
 
<script src="<?=base_url('assets')?>/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- ########## DATA TABLE PARA DESCARGAR########## -->

   <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<!-- JS xavier -->
<script src="<?=base_url('assets')?>/js/plugins/select2/js/select2.full.min.js"></script>

<script src="<?=base_url('assets')?>/js/script.js" type="text/javascript"></script>


<!-- #################### -->
<!-- Bootstrap -->
<script src="<?=base_url('assets')?>/js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?=base_url('assets')?>/js/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="<?=base_url('assets')?>/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="<?=base_url('assets')?>/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="<?=base_url('assets')?>/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- fullCalendar -->
<script src="<?=base_url('assets')?>/js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<!-- jQuery Knob Chart -->
<script src="<?=base_url('assets')?>/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
<!-- daterangepicker -->
<script src="<?=base_url('assets')?>/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=base_url('assets')?>/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="<?=base_url('assets')?>/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- AdminLTE App -->
<script src="<?=base_url('assets')?>/js/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?=base_url('assets')?>/js/AdminLTE/dashboard.js" type="text/javascript"></script>
<!-- Select2 -->


<script src="<?=base_url('assets')?>/loading/src/js/HoldOn.js" type="text/javascript"></script>

<script src="<?=base_url('assets')?>/js/plugins/datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>


<?= $_scripts ?><!--cargamos los js-->

</body>
</html>