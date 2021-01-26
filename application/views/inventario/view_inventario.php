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
                <h3 class="box-title" id='titulo_documento'>Reporte de Inventario</h3>

            </div>
            <div  class="box-body">

             <div class="col-sm-12">
              <div class="row">                              
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Empresa:</label>
                         <select class="form-control select2" id="empresa" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($empresas as $valor): ?>
                          <option value='<?php echo ($valor['id_empresa']); ?>'><?php echo ($valor['nombre']); ?></option>  <?php endforeach; ?>
                        </select>
                      
                      </div>
                  </div>
                   <div class="col-sm-4">
                     <div class="form-group">
                        <label >Bodega:</label>
                         <select class="form-control select2" id="bodega" >                              
                              <option value='0'> -- seleccione --</option>                           
                        
                        </select>
                      
                      </div>
                  </div>
                  <div class="col-sm-4">
                     <br>
                    <button id="btnconsultar" class="btn btn-success" onclick="obtener_inventario_por_criterios()">Consultar</button>
                </div>
                                           
            </div>
              
             </div>
             <br>
             <br>
             <br>
             <br>
                <table id="table_inventario" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Empresa</th>
                            <th>Bodega</th>                         
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Caracteristicas</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                           
                    </tbody>
                </table>
            </div>




       
       
    </section>

    <!-- /.content -->
</aside><!-- /.right-side -->


