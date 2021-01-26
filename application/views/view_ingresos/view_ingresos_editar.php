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
                         <input type="text" id='empresa_' disabled="disabled" class="form-control" value="<?=isset($registro_parcial_cab[0]['empresa']) ? $registro_parcial_cab[0]['empresa'] : "" ?>">
                         <input type="hidden" id='empresa' disabled="disabled"   class="form-control" value="<?=$registro_parcial_cab[0]['id_empresa'] ?>">
                      </div>
                  </div>
                   <div class="col-sm-4">
                     <div class="form-group">
                        <label >Bodega:</label>
                         <input type="text" id='bodega_' disabled="disabled" class="form-control" value="<?=isset($registro_parcial_cab[0]['bodega']) ? $registro_parcial_cab[0]['bodega'] : "" ?>">
                          <input type="hidden" id='bodega' disabled="disabled" class="form-control" value="<?=$registro_parcial_cab[0]['id_bodega']?>">
                      </div>
                  </div>
                                           
            </div>
             <div class="modal-footer">
                  <button  class="btn btn-primary" onclick="abrir_guia()" disabled="disabled">Abrir Guía </button>
                  <a href="<?php echo site_url('control_ingresos/listar_ingreso_bodegas') ?>" class="btn btn-primary"> Regresar </a>
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
                          <input type="text"  class="form-control" id='guia' readonly="readonly" value="<?= isset($registro_parcial_cab[0]['id_ingresocab']) ? $registro_parcial_cab[0]['id_ingresocab'] : "" ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label>Referencia*:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <input type="text"  class="form-control" id='referencia'  value="<?= isset($registro_parcial_cab[0]['referencia']) ? $registro_parcial_cab[0]['referencia'] : "" ?>">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Producto:</label>                             
                      </div>
                      <div class="col-sm-8">
                          <select class="form-control select2" id="producto"  >                              
                                    <option value='0'> -- seleccione --</option>                           
                               <?php foreach ($productos as $valor): ?>
                                <option value='<?php echo ($valor['id_producto']); ?>'><?php echo ($valor['producto']); ?></option>  <?php endforeach; ?>
                          </select>  
                           <a  onclick="$('#crear_producto_directo_modal').modal('show');"> Agregar producto </a>
                      </div>
                    </div>
                   
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Estado:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <select class="form-control select2" id="estado"  >                              
                                    <option value='0'> -- seleccione --</option>                           
                                    <option value='B'>Buen Estado</option>
                                    <option value='M'>Dañado</option>
                            </select>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-sm-4">
                              <label >Código de Barras:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <input type='text' class="form-control" id="cod_barras" placeholder="Ej:  0121547E8" > 
                      </div>
                    </div>


                    <div class="row">
                      <div class="col-sm-4">
                              <label >Detalle:</label>                             
                      </div>
                      <div class="col-sm-8">
                           <textarea readonly="readonly" class="form-control" id="detalle"></textarea> 
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
                <?php if ($registro_parcial_cab[0]['tipo']!='IC'){ ?>
                  <div class="modal-footer">
                  <button  class="btn btn-success" id='guardar_ingreso' onclick="valida_codigos_repetidos()" >Guardar</button>
                  <button   class="btn btn-success" id='limpiar_ingreso_btt' >Limpiar</button>
                   <button   class="btn btn-success" id='cerrar_guia' >Cerrar Guía</button>
                </div>
               <?php } ?>
                            
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
                            <th>Estado</th>                           
                            <th>Opciones</th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php  if(isset($registro_parcial)){ ?>
                            <?php foreach ($registro_parcial as $valor): ?>
                            <tr>
                            <td><?php echo htmlspecialchars($valor['cod_barras'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['Estado_producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                        
                             <?php if ($registro_parcial_cab[0]['tipo']!='IC'){ ?>
                              <td><a onclick='eliminar_registro_ingreso(<?=$valor['id_ingresodet'] ?>)'><span class='label label-danger'>Eliminar</span></a></td>
                            <?php }else { ?>
                              <td>Sin Acciones</td>
                            <?php }endforeach; } ?>

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
<div class="modal fade" id="crear_producto_directo_modal" tabindex="-1" role="dialog" aria-labelledby="crear_producto_directo_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title"  > Caracteristicas de Producto</h5>        
      </div>
      <div class="modal-body">
        <form id="form_producto_nuevo_directo">
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
        <button type="button" class="btn btn-primary" onclick="crear_producto_nuevo(1)">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>