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
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"> <?= $title ?> </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div id="infoMessage"><?php echo $message; ?></div>

                    <?php echo form_open(current_url()); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo lang('edit_group_name_label', 'group_name'); ?> <br/>
                            <?php echo form_input($group_name, false, 'class="form-control" placeholder="Grupo"'); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('edit_group_desc_label', 'description'); ?> <br/>
                            <?php echo form_input($group_description, false, 'class="form-control" placeholder="Descripcion"'); ?>
                        </div>
                        <h3 class="box-title">Accesos</h3>
                        <ul>
                            <?php //var_dump($accesos[12]); var_dump($accesos_activos[12]);
                            foreach ($accesos as $acceso) {
                                $str_checked=is_null($accesos_activos[$acceso['id']])?"":"checked='checked'";
                                //var_dump($str_checked);
                                ?>

                                <li><input type="checkbox" <?=$str_checked ?>><label><?= $acceso['name']; ?></label></li>
                                <?php if (count($acceso['childs']) > 0) {?>
                                    <ul>
                                        <?php foreach ($acceso['childs'] as $child) {
                                            $str_checked_child=is_null($accesos_activos[$acceso['id']]['childs'][$child['id']])?"":"checked='checked'";

                                            ?>
                                            <li><input type="checkbox" <?=$str_checked_child ?> ><label><?= $child['name']; ?></label></li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>

                            <?php } ?>
                        </ul>
                    </div>
                    <div class="box-footer">
                        <p><?php echo form_submit('submit', lang('edit_group_submit_btn'),
                                'class="btn btn-primary"'); ?></p>
                    </div>



                    <?php echo form_close(); ?>
                </div>
                <!-- /.box -->
            </div>

            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</aside><!-- /.right-side -->
