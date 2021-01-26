
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
                <h3 class="box-title" id='titulo_documento'>Movimientos Registrados</h3>

            </div>
            <div  class="box-body">

             <div class="col-sm-12">
              <div class="row">
                 <div class="col-sm-3">
                  <label>Empresa</label>
                  <select id="selEmpresa" class="form-control">
                    <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($empresas as $valor): ?>
                          <option value='<?php echo ($valor['id_empresa']); ?>'><?php echo ($valor['nombre']); ?></option>  <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-sm-3">
                  <label>Fecha Inicio</label>
                  <input type="date" id="fecha_ini" class="form-control">
                </div>
                <div class="col-sm-3">
                  <label>Fecha Final</label>
                  <input type="date" id="fecha_fin" class="form-control" >
                </div>
                <div class="col-sm-3">
                  <br>
                  <button id="btnconsultar" class="btn btn-success" onclick="obtener_transacciones_por_criterios()">Consultar</button>
                </div>
              </div>
             </div>
             <br>
             <br>
             <br>
             <br>
                <table id="table_transacciones" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                           
                            <th>Bodega</th>                         
                            <th>Guía</th> 
                            <th>Fecha</th> 
                            <th>Transacción</th> 
                            <th>Cod Barras</th>
                            <th>Tipo</th>
                            <th>Marca</th>
                            <th>Modelo</th>                           
                            <th>Estado</th> 
                            <th>Detalle</th> 
                            <th>Usuario</th>
                        </tr>
                    </thead>
                    <tbody>
                           
                    </tbody>
                </table>
            </div>
  
    </section>

</aside>

