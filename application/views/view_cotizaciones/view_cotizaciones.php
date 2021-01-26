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
          <h3 class="box-title" id='titulo_documento'>Ingreso de datos de Cliente </h3>
        </div>
    
        <div class="box-body">
         
            <div class="row">                              
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Nombre Cliente:</label>
                         <input type="text" name="cliente" id='cliente' readonly="readonly" class="form-control" value="<?=isset($registro_cotizacion_parcial_cab[0]['cliente']) ? $registro_cotizacion_parcial_cab[0]['cliente'] : "" ?>">
                      
                      </div>
                  </div>
                   <div class="col-sm-4">
                     <div class="form-group">
                        <label >Email Cliente:</label>
                         <input type="text" name="email" id='email' class="form-control" value="<?=isset($registro_cotizacion_parcial_cab[0]['email']) ? $registro_cotizacion_parcial_cab[0]['email'] : "" ?>">
                      
                      </div>
                  </div>
                                           
            </div>
             <div class="modal-footer">
                 <!-- <button  class="btn btn-primary" onclick="abrir_cotizacion()">Abrir Cotización</button>  -->
                  <a href="<?php echo site_url('control_cotizaciones/listar_cotizaciones') ?>" class="btn btn-primary"> Regresar </a>
              </div> 
            <br>
            <div class="row">
              <div class="col-sm-5">
           
              <div class="box box-success"> 
             
                <div class="box-body">
                   <div class="row">
                      <div class="col-sm-4">
                              <label>Cotización No:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <input type="text"  class="form-control" id='guia_cotizacion' readonly="readonly" value="<?=isset($registro_cotizacion_parcial_cab[0]['id_cotizacionescab']) ? $registro_cotizacion_parcial_cab[0]['id_cotizacionescab'] : "" ?>" >
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Producto:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <select class="form-control select2" id="producto_cotizar"  >                              
                                    <option value='0'> -- seleccione --</option>                           
                               <?php foreach ($productos as $valor): ?>
                                <option value='<?php echo ($valor['id_producto']); ?>'><?php echo ($valor['producto']); ?></option>  <?php endforeach; ?>
                          </select>  
                            <a  onclick="$('#crear_producto_temporal_modal').modal('show');"> Agregar producto </a>
                      </div>
                    </div>

                  

                  
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Stock Real:</label>                             
                      </div>
                      <div class="col-sm-8">
                            <input type='text' readonly class="form-control" id="stock" > 
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
                              <label >Precio Cotizado :</label>                             
                      </div>
                      <div class="col-sm-8">
                           <input type="number" class=' form-control' id="pvp">
                      </div>
                    </div>

                     <div class="row">
                      <div class="col-sm-4">
                              <label >Cantidad :</label>                             
                      </div>
                      <div class="col-sm-8">
                           <input type="number" class=' form-control' id="cantidad">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Detalle:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <textarea readonly="readonly" class="form-control" id="detalle" rows="4" ></textarea> 
                      </div>
                    </div><br>
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
                  <button  class="btn btn-success" id='guardar_cotizacion' onclick="guardar_registro_cotizacion()" >Guardar</button>
                   <button   class="btn btn-success" id='cerrar_guia_cotizacion' onclick="$('#agregar_observaciones').modal('show');" >Generar Cotización</button>
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
                            <th>Producto</th>                                                     
                            <th>Costo</th>                                                     
                            <th>Cantidad</th>                            
                            <th>Subtotal</th>
                            <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                       
                            <?php foreach ($registro_cotizacion_parcial as $valor): ?>
                            <tr>
                            <td> <?php echo $valor['producto']; ?></td>
                             <td> <?php echo $valor['costo_cotizado']; ?></td>
                              <td> <?php echo $valor['cantidad']; ?></td>
                               <td> <?php echo $valor['subtotal']; ?></td>
                            <td align="center"> <a onclick='eliminar_registro_cotizacion(<?=$valor['id_cotizacionesdet'] ?>)'><span class='label label-danger'>Eliminar</span></a>                             
                             </td>  
                                          
                            </tr>
                            <?php endforeach; ?>
                  
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
        <button type="button" class="btn btn-primary" id='cerrar_guia_cotizacion_final'>Generar  y Enviar Cotizacion</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal crear-->
<div class="modal fade" id="crear_producto_temporal_modal" tabindex="-1" role="dialog" aria-labelledby="crear_producto_temporal_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title"  > Caracteristicas de Producto</h5>        
      </div>
      <div class="modal-body">
        <form id="form_producto_nuevo_cotizador">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Tipo Producto</label>
               <select class="form-control" id="cmb_tipo_producto" name="cmb_tipo_producto"  >                              
                                <option value='0'> -- seleccione --</option>                           
                               <?php foreach ($categorias as $valor): ?>
                                <option value='<?php echo ($valor['id_categoria']); ?>'><?php echo ($valor['descripcion']); ?></option>  <?php endforeach; ?>
                </select>              
              <label>Marca</label>
              <select class="form-control" id="cmb_tipo_marca"  name="cmb_tipo_marca"  >                              
                                <option value='0'> -- seleccione --</option>                           
                               <?php foreach ($marcas as $valor): ?>
                                <option value='<?php echo ($valor['id_marca']); ?>'><?php echo ($valor['descripcion']); ?></option>  <?php endforeach; ?>
                </select> 
              <label>Modelo</label>
              <input type="text" id="modelo" class='form-control' name='modelo'  >
              <label>Caracteristicas</label>
              <textarea type="text" id="detalle" name="detalle" class="form-control"></textarea>
              <label>Precio Referencial de Venta</label>
              <input type="number" id="precio" name="precio" class='form-control' >
            </div>
          </div>
          <div class="col-sm-6">
            <center><img height='100' weight='100' id='imagen_base'>
               <input id="imagen-adjunta"
                                           class="btn btn-primary"
                                           type='file'
                                           data-id=""
                                           name='imagen-adjunta'
                                           multiple>
            </center>
          </div>
        </div>
        <div class="row">
           <div class="col-sm-3">
            <div class="form-group">
              <label>Precio Minimo</label>
              <input type="number" id="costo_minimo" name='costo_minimo' class='form-control'  >
            </div>
           </div>
            <div class="col-sm-3">
            <div class="form-group">
              <label>Precio Standar</label>
              <input type="number" id="costo_standar" name='costo_standar' class='form-control' >
            </div>
           </div>
            <div class="col-sm-3">
            <div class="form-group">
              <label>Precio Máximo</label>
              <input type="number" id="costo_maximo" name='costo_maximo' class='form-control' >
            </div>
           </div>
        </div>
      </form>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="crear_producto_nuevo(2)">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>