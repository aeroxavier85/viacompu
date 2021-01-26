<!-- Example row of columns -->
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?=$title?>
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


        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?=$title?> </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">

                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th><?php echo lang('index_action_th'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($groups as $group): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($group->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($group->description, ENT_QUOTES, 'UTF-8'); ?></td>


                            <td><?php echo anchor("autenticacion/edit_group/" . $group->id, '<span class="glyphicon glyphicon-edit"></span>','title="Editar"'); ?></td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <p><?php echo anchor('autenticacion/create_group', lang('index_create_group_link'))?></p>
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