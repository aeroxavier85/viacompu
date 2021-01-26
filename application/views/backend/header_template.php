<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>
    <div class="navbar-right">
        <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="glyphicon glyphicon-user"></i>
                    <span><?php if(isset($conectado)) {?><?=$conectado['nombres'] ?><?php }else{ ?>Usuario<?php } ?><i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header bg-light-blue">

                        <?php if(isset($conectado)) {?>
                            <img src="<?php echo base_url($conectado['fotografia']) ?>" class="img-circle" alt="User Image" />
                        <?php }else{ ?>
                            <img src="<?php echo base_url($conectado['fotografia']) ?>" class="img-circle" alt="User Image"/>
                        <?php } ?>
                        <p>
                            <?php if(isset($conectado)) {?><?=$conectado['nombres'] ?> <?=$conectado['apellidos'] ?> <br>
                            <!-- <small><?=$conectado['email'] ?></small>-->
                            <?php }else{ ?>Usuario<?php } ?>
                            <small>ViaCompu</small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    <!--li class="user-body">
                        <div class="col-xs-4 text-center">
                            <a href="#">Followers</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Sales</a>
                        </div>
                        <div class="col-xs-4 text-center">
                            <a href="#">Friends</a>
                        </div>
                    </li-->
                    <!-- Menu Footer-->
                    <?php if(isset($conectado)) {?>
                        <li class="user-footer">
                            <!--div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Perfil</a>
                            </div-->
                            <div class="pull-left">
                                <a href="<?=base_url('autenticacion/cambio_password') ?>" class="btn btn-primary btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?=base_url('autenticacion/logout') ?>" class="btn btn-success btn-flat">Cerrar sesión</a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </li>
        </ul>
    </div>
         <div class="navbar-right">
        <ul class="nav navbar-nav">

            <!-- User Account: style can be found in dropdown.less -->

            <li class="dropdown user user-menu">
                <a href="<?= base_url('autenticacion/cambio_password') ?>" style="cursor: pointer">
                    <i class="glyphicon glyphicon-pencil"></i>
                    Editar foto de Perfil
                </a>
            </li>
        </ul>
    </div>
</nav>