<aside class="left-side sidebar-offcanvas">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo base_url($conectado['fotografia']) ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Hola,<?=$conectado['nombres'] ?> </p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

    <!-- /.sidebar -->
        <?php echo $this->multi_menu->render(array(
            'nav_tag_open'        => '<ul class="sidebar-menu">',
            'parentl1_tag_open'   => '<li class="treeview">',
            'parentl1_anchor'     => '<a tabindex="0" data-toggle="dropdown" href="%s">%s<span class="caret"></span></a>',
            'parent_tag_open'     => '<li class="treeview-menu">',
            'parent_anchor'       => '<a href="%s" data-toggle="dropdown">%s</a>',
            'children_tag_open'   => '<ul class="treeview-menu">'
        )); ?>
    </section>
</aside>