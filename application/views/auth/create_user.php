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
        <?=$breadcrumbs?>
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

                    <?php echo form_open("autenticacion/create_user"); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo lang('create_user_fname_label', 'first_name'); ?> <br/>
                            <?php echo form_input($first_name, false, 'class="form-control" placeholder="Nombres"'); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_lname_label', 'last_name'); ?> <br/>
                            <?php echo form_input($last_name, false, 'class="form-control" placeholder="Apellidos"'); ?>
                        </div>

                        <div class="form-group">

                        <?php
                        if ($identity_column !== 'email') {
                            echo '<p>';
                            echo lang('create_user_identity_label', 'identity');
                            echo '<br />';
                            echo form_error('identity');
                            echo form_input($identity, false, 'class="form-control" placeholder="Usuario"');
                            echo '</p>';
                        }
                        ?>

                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_company_label', 'company'); ?> <br/>
                            <?php echo form_input($company, false, 'class="form-control" placeholder="Empresa"'); ?>
                        </div>

                        <div class="form-group">
                            <!--     <?php echo lang('create_user_email_label', 'email'); ?> -->
                            <strong>Username:</strong><br/>
                            <?php echo form_input($email, false, 'class="form-control" placeholder="Nombre de Usuario del Sistema"'); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_phone_label', 'phone'); ?> <br/>
                            <?php echo form_input($phone, false, 'class="form-control" placeholder="Telefono"'); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_password_label', 'password'); ?> <br/>
                            <?php echo form_input($password, false, 'class="form-control" placeholder="Contraseña"'); ?>
                        </div>

                        <div class="form-group">
                            <?php echo lang('create_user_password_confirm_label', 'password_confirm'); ?> <br/>
                            <?php echo form_input($password_confirm, false, 'class="form-control" placeholder="Confirmar contraseña"'); ?>
                        </div>
                        <div class="form-group">

                           

                                <h4><?php echo lang('edit_user_groups_heading'); ?></h4>
                                <?php foreach ($groups as $group): ?>
                                    <label class="checkbox">
                                        <?php
                                        $gID = $group['id'];
                                        $checked = null;
                                        $item = null;
                                        /*foreach ($currentGroups as $grp) {
                                            if ($gID == $grp->id) {
                                                $checked = ' checked="checked"';
                                                break;
                                            }
                                        }*/
                                        ?>
                                        <input type="checkbox" name="groups[]"
                                               value="<?php echo $group['id']; ?>">
                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                                <?php endforeach ?>

                            
                        </div>

                    </div>
                    <div class="box-footer">
                        <p><?php echo form_submit('submit', lang('create_user_submit_btn'),
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