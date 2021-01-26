<!-- Example row of columns -->
<!-- Right side column. Contains the navbar and content of the page -->
<!-- Example row of columns -->
<!-- Right side column. Contains the navbar and content of the page -->

<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $title ?>
            <!--small>it all starts here</small-->
        </h1>

        <?= $breadcrumbs ?>
    </section>

    <!-- Main content -->
    
 <section class="content">
      
<div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title" id='titulo_documento'>Registro de Ordenes</h3>

            </div>
            <div  class="box-body">

             <div class="col-sm-12">
              <div class="row">
                 <div class="col-sm-4">
                  <label>Empresa</label>
                  <select id="selEmpresaOrdenes" class="form-control">
                    <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($empresas as $valor): ?>
                          <option value='<?php echo ($valor['id_empresas']); ?>'><?php echo ($valor['nombre_comercial']); ?></option>  <?php endforeach; ?>
                  </select>
                </div>
                 <div class="col-sm-4">
                  <label>Producto</label>
                  <select id="selProductosOrdenes" class="form-control">                        
                  </select>
                </div>
                <div class="col-sm-4">
                  <br>
                  <button id="btnconsultar" class="btn btn-success" onclick="obtener_ordenes_por_criterios()">Consultar</button>
                </div>
              </div>
             </div>
             <br>
             <br>
             <br>
             <br>
                <table id="table_ordenes" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Producto</th>                         
                            <th>Codigo</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                           
                    </tbody>
                </table>
            </div>




       
       
    </section>

    <!-- /.content -->
</aside><!-- /.right-side -->

