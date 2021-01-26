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
          <h3 class="box-title" id='titulo_documento'>Ingreso </h3>
        </div>
    
        <div class="box-body">
         
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
                                           
            </div>
             <div class="modal-footer">
                  <button  class="btn btn-primary" onclick="abrir_egreso()">Abrir Guía de Egreso</button>
                  <a href="<?php echo site_url('control_egresos/listar_egreso_bodegas') ?>" class="btn btn-primary"> Regresar </a>
              </div> 
            <br>
            <div class="row">
              <div class="col-sm-5">
           
              <div class="box box-success"> 
             
                <div class="box-body">
                   <div class="row">
                      <div class="col-sm-4">
                              <label>Guía Automática:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <input type="text"  class="form-control" id='guia_egreso' readonly="readonly" >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label>Código de Barras:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <input type="text"  class="form-control" id='cod_barras_busqueda' readonly="readonly" >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Producto:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <input type='text' readonly class="form-control" id="tipo_producto" > 
                          <input type='hidden' readonly class="form-control" id="id_producto" > 
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Estado:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <select class="form-control select2" id="estado" disabled="disabled" >                              
                                    <option value='0'> -- seleccione --</option>                           
                                    <option value='B'>Buen Estado</option>
                                    <option value='M'>Dañado</option>
                            </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Precio Mínimo:</label>                             
                      </div>
                      <div class="col-sm-8">
                            <input type='text' readonly class="form-control" id="ppp" > 
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-4">
                              <label >Precio Sujerido:</label>                             
                      </div>
                      <div class="col-sm-8">
                            <input type='text' readonly class="form-control" id="psujerido" > 
                      </div>
                    </div>
                   
                   <div class="row">
                      <div class="col-sm-4">
                              <label >Precio de Venta:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <input type="number" class=' form-control' id="pvp">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Detalle:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <textarea readonly="readonly" class="form-control" id="detalle" rows="4" ></textarea> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Imagen:</label>                             
                      </div>
                      <div class="col-sm-8">
                         <center><img height='100' weight='100' id='imagen_base_ingreso' ></center>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button  class="btn btn-success" id='guardar_egreso' onclick="valida_codigos_repetidos_egresos()" disabled="disabled">Guardar</button>
                   <button   class="btn btn-success" id='cerrar_guia_egreso' onclick="$('#agregar_observaciones').modal('show');" disabled="disabled">Generar Orden</button>
                </div>
            
              </div>
          
              </div>
              <div class="col-sm-7">
             <div class="box box-success"> 
                <div class="box-header"></div>
                 <div class="box-body">
                  <div class="table-responsive">
                 
                    <table id="table_ingresos_guia" class="table table-bordered table-striped" >
                      <thead>
                        <tr>
                            <th>Código</th>
                            <th>Producto</th>                                                     
                            <th>Costo</th>                                                     
                            <th>Estado</th>                            
                            <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                          
                      </tbody>
                    </table>
                  </div>
                 </div>                
              </div>
             </div>
            </div>
          
        </div>
    </div>      
       
    </section>

    <!-- /.content -->
</aside><!-- /.right-side -->

<!-- Modal crear-->
<div class="modal fade" id="agregar_observaciones" tabindex="-1" role="dialog" aria-labelledby="agregar_observaciones" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title"  >Observaciones</h5>        
      </div>
      <div class="modal-body">
        <form id="form_producto_nuevo">
        <div class="row">
          <div class="col-sm-12">
            <div class="form-group">
             
              <textarea id='observaciones' class="form-control" rows="5"></textarea> 
           </div>  
            </div> 
        </div>
       
      </form>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id='cerrar_guia_egreso_final'>Generar Orden</button>
      </div>
    </div>
  </div>
</div>