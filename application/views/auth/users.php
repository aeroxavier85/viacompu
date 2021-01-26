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


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Usuarios Registrados</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">

                <table id="example" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><?php echo lang('index_fname_th'); ?></th>
                        <th><?php echo lang('index_lname_th'); ?></th>
                        <th><?php echo lang('index_email_th'); ?></th>
                        <th><?php echo lang('index_groups_th'); ?></th>
                        <th><?php echo lang('index_status_th'); ?></th>
                        <th><?php echo lang('index_action_th'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user->first_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->last_name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($user->email, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php foreach ($user->groups as $group): ?>
                                    <?php echo anchor("autenticacion/edit_group/" . $group->id,
                                        htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8')); ?><br/>
                                <?php endforeach ?>
                            </td>
                            <td><?php echo ( $user->active ) ? anchor("autenticacion/deactivate/" . $user->id,
                                    lang('index_active_link')) : anchor("autenticacion/activate/" . $user->id,
                                    lang('index_inactive_link')); ?></td>
                            <td><?php echo anchor("autenticacion/edit_user/" . $user->id, '<span class="glyphicon glyphicon-edit"></span>','title="Editar"'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <p><?php echo anchor('autenticacion/create_user', lang('index_create_user_link'))?> | <?php echo anchor('autenticacion/create_group', lang('index_create_group_link'))?></p>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <script type="text/javascript">
            $(function () {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo": true,
                    "bAutoWidth": false
                });
            });
        </script>
    </section>
    <!-- /.content -->
</aside><!-- /.right-side -->