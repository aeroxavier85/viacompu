<aside class="right-side">

    <section class="content-header">
        <h1>
            <?= $title ?>
        </h1>
        <?= $breadcrumbs ?>
    </section>
    <section class="content">
        <div class="col-md-6">
            <div class="box box-primary">
                <form id="form_carga_imagen" method="post" accept-charset="utf-8">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="first_name">Cargar Imagen</label> <br>
                                        <input  type="file" name="img" id="img"
                                                class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <a id="btnCambiofoto" class="btn btn-success"><i class="fa fa-save"></i> Cargar foto</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

                <div class="col-md-6">
                    <div class="box box-primary">
                        <form id="crear_usuario_form" method="post" accept-charset="utf-8">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="first_name">Contraseña Antigua</label> <br>
                                                <input  type="password" maxlength="20" name="contraseñaActual" value="" id="contraseñaActual"
                                                        class="form-control" placeholder="**********" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="last_name">Contraseña Nueva</label> <br>
                                                <input  type="password" maxlength="20" name="nuevaContraseña" value="" id="nuevaContraseña"
                                                        class="form-control" placeholder="**********" >
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email">Repita Contraseña</label> <br>
                                                <input  type="password" maxlength="20" name="nuevaContraseña2" value="" id="nuevaContraseña2"
                                                        class="form-control" placeholder="**********" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a id="btnCambioContrasenia" class="btn btn-success"><i class="fa fa-save"></i> Cambiar Contraseña</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


    </section>
</aside>