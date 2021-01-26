<!-- Example row of columns -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$title?>
        </h1>
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
                    </div><!-- /.box-header -->
                    <!-- form start -->

                    <div id="infoMessage"><?php echo $message; ?></div>

                    <?php echo form_open(uri_string()); ?>
                    <div class="box-body">
                        <div class="form-group">
                            <label>
                                <?php echo lang('edit_user_fname_label', 'first_name'); ?> <br/></label>
                            <?php echo form_input($first_name, '', 'class="form-control"'); ?>

                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_user_lname_label', 'last_name'); ?> <br/>
                            <?php echo form_input($last_name, '', 'class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_user_company_label', 'company'); ?> <br/>
                            <?php echo form_input($company, '', 'class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('create_user_email_label', 'email'); ?> <br/>
                            <?php echo form_input($email, false, 'class="form-control" placeholder="Email"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_user_phone_label', 'phone'); ?> <br/>
                            <?php echo form_input($phone, '', 'class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_user_password_label', 'password'); ?> <br/>
                            <?php echo form_input($password, '', 'class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_user_password_confirm_label', 'password_confirm'); ?><br/>
                            <?php echo form_input($password_confirm, '', 'class="form-control"'); ?>
                        </div>
                        <div class="form-group">

                          

                                <h3><?php echo lang('edit_user_groups_heading'); ?></h3>
                                <?php foreach ($groups as $group): ?>
                                    <label class="checkbox">
                                        <?php
                                        $gID = $group['id'];
                                        $checked = null;
                                        $item = null;
                                        foreach ($currentGroups as $grp) {
                                            if ($gID == $grp->id) {
                                                $checked = ' checked="checked"';
                                                break;
                                            }
                                        }
                                        ?>
                                        <input type="checkbox" name="groups[]"
                                               value="<?php echo $group['id']; ?>"<?php echo $checked; ?>>
                                        <?php echo htmlspecialchars($group['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </label>
                                <?php endforeach ?>

                          
                        </div>
                        <div class="form-group">
                            <?php echo form_hidden('id', $user->id); ?>
                            <?php echo form_hidden($csrf); ?>
                        </div>
                        <div class="box-footer">

                            <?php echo form_submit('submit', lang('edit_user_submit_btn'),'class="btn btn-primary"'); ?>
                        </div>


                        <?php echo form_close(); ?>


                    </div>
                </div>
            </div>
    </section>
    <!-- /.content -->
</aside><!-- /.right-side -->