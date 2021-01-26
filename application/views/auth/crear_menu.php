<!-- Example row of columns -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $title ?>
            <!--small>it all starts here</small-->
        </h1>
        <!--ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Examples</a></li>
            <li class="active">Blank page</li>
        </ol-->
        <?= $breadcrumbs ?>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <!-- left column -->


            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"> <?= $title ?> </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div id="infoMessage"><?php echo $message; ?></div>
                    <?php echo form_open("autenticacion/crear_menu");?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo "Padre";?> <br />
                            <?php echo form_input($parent, false, 'class="form-control" placeholder="Padre"');?>
                        </div>

                    </div>
                    <div class="box-footer">

                        <?php echo form_submit('submit', lang('create_group_submit_btn'),'class="btn btn-primary"'); ?>
                    </div>


                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</aside><!-- /.right-side -->