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
          <h3 class="box-title" id='titulo_documento'>Movimiento de Mercaderia entre Bodegas </h3>
        </div>
    
        <div class="box-body">
         
            <div class="row">                              
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Empresa:</label>
                         <select class="form-control select2" id="empresa_movimientos_interno" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($empresas as $valor): ?>
                          <option value='<?php echo ($valor['id_empresa']); ?>'><?php echo ($valor['nombre']); ?></option>  <?php endforeach; ?>
                        </select>
                      
                      </div>
                  </div>
                   <div class="col-sm-4">
                     <div class="form-group">
                        <label >Bodega Origen:</label>
                         <select class="form-control select2" id="bodega_origen" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($bodega as $valor): ?>
                          <option value='<?php echo ($valor['id_empresas']); ?>'><?php echo ($valor['nombre_comercial']); ?></option>  <?php endforeach; ?>
                        </select>
                      
                      </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Bodega Destino:</label>
                         <select class="form-control select2" id="bodega_destino" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($bodega as $valor): ?>
                          <option value='<?php echo ($valor['id_empresas']); ?>'><?php echo ($valor['nombre_comercial']); ?></option>  <?php endforeach; ?>
                        </select>
                      
                      </div>
                  </div>
                                           
            </div>
            <div class="modal-footer">
                  <button  class="btn btn-primary" id='abrir_guia_entre_bodegas' disabled onclick="abrir_guia_entre_bodegas()">Abrir Guía </button>
                  <a href="<?php echo site_url('control_ingresos/listar_movimientos_bodegas') ?>" class="btn btn-primary"> Regresar </a>
                </div>            
            <br>
            <div class="row">
            <div class="col-sm-5">
           
              <div class="box box-success"> 
             
                <div class="box-body">
                    <div class="row">
                      <div class="col-sm-6">
                              <label>Guía / Referencia*:</label>                             
                      </div>
                      <div class="col-sm-6">
                          <input type="text" readonly class="form-control" id='guia_movimiento_bodegas'>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                              <label >Código de Barras:</label>                             
                      </div>
                      <div class="col-sm-6">
                           <input type='text' class="form-control" id="cod_barras_busqueda"  placeholder="Ej:  0121547E8"> 
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-6">
                              <label >Tipo de Producto:</label>                             
                      </div>
                      <div class="col-sm-6">
                          <input type='text' readonly class="form-control" id="tipo_producto" > 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                              <label >Marca:</label>                             
                      </div>
                      <div class="col-sm-6">
                          <input type='text' readonly class="form-control" id="marca_producto" > 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                              <label >Modelo:</label>                             
                      </div>
                      <div class="col-sm-6">
                          <input type='text' readonly class="form-control" id="modelo_producto" > 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                              <label >Estado:</label>                             
                      </div>
                      <div class="col-sm-6">
                           <select class="form-control select2" id="estado" disabled="disabled">                              
                                    <option value='0'> -- seleccione --</option>                           
                                    <option value='B'>Buen Estado</option>
                                    <option value='M'>Dañado</option>
                            </select>
                      </div>
                    </div>
                    
                    <div class="row">                              
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label >Descripción / Observaciones:</label>
                               <textarea class="form-control" readonly id='descripcion'></textarea>
                            </div>
                        </div>
                                   
                    </div>
                </div>
                <div class="modal-footer">
                  <button  class="btn btn-success" id='enviar_guia_bodegas'  onclick="cerrar_guia_movimientos()" >Cerrar Guía y Enviar</button>
                  <button   class="btn btn-success" id='agregar_guia_bodegas' onclick="valida_codigos_repetidos_movimientos_internos()"  >Agregar a Guía</button>
                </div>
            
              </div>
           
            </div>
            <div class="col-sm-7">
             <div class="box box-success"> 
                <div class="box-header"></div>
                 <div class="box-body">
                    <table id="table_movimientos_internos_guia" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Estado</th>
                            <th>Producto</th> 
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Destino</th>
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
       
    </section>

    <!-- /.content -->
</aside><!-- /.right-side -->

