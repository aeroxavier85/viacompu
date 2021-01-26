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


            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"> Crear Grupo de Privilegios </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div id="infoMessage"><?php echo $message; ?></div>
                    <?php echo form_open("autenticacion/create_group");?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo lang('create_group_name_label', 'group_name');?> <br />
                            <?php echo form_input($group_name, false, 'class="form-control" placeholder="Grupo"');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_group_desc_label', 'description'); ?> <br/>
                            <?php echo form_input($group_description, false, 'class="form-control" placeholder="Descripcion"'); ?>
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