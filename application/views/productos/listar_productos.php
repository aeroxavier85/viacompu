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
          <h3 class="box-title" id='titulo_documento'>Productos Registrados</h3>
        </div>
    
        <div class="box-body">
  <button class="btn btn-primary" onclick="$('#crear_modal').modal('show');"><span class="glyphicon glyphicon-plus">Agregar producto </span></button>  
  
         <br><br>
            
            <div class="row">
           
            <div class="col-sm-12">
             <div class="box box-success"> 
                <div class="box-header"></div>
                 <div class="box-body">
                    <table id="example" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Id Producto</th>                                              
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Descripción</th>
                            <th>Costo de Compra</th>
                            <th>Stock</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                                                  
                           <?php foreach ($lista_productos as $valor): ?>
                            <tr>
                            <td>Prod-<?php echo htmlspecialchars($valor['id_producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['categoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['marca'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['modelo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['descripcion_producto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['precio'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['saldo_actual'], ENT_QUOTES, 'UTF-8'); ?></td> 
                            <td><img height='80' weight='80'src=<?php echo $valor["imagen"]; ?> >
                            </td>
                           <?php if( $valor['estado']=='I') {?>
                            <td><span class='label label-danger'>Inactivo</span></td>    
                            <?php } ?>
                             <?php if( $valor['estado']=='A') {?>
                            <td><span class='label label-success'>Activo </span></td>    
                            <?php } ?>
                            
                            <td align="center">                                                               
                                <a   onclick="modificar_producto('<?php echo $valor['id_producto']; ?>')" ><span class="glyphicon glyphicon-edit"> </span>  </a>    
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
       
    </section>

    <!-- /.content -->
</aside><!-- /.right-side -->


<!-- Modal Modificar-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title" id="exampleModalLabel" >Modificar Caracteristicas de Producto</h5>        
      </div>
      <div class="modal-body">
        <form id="form_producto_m">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Cod producto</label>
              <input type="text" id="cod_producto_m" name='cod_producto_m' class='form-control'  readonly="readonly">
              <label>Marca</label>
              <input type="text" id="marca_m" class='form-control'  readonly="readonly">
              <label>Modelo</label>
              <input type="text" id="modelo_m" class='form-control'  readonly="readonly">
              <label>Detalle</label>
             <textarea class="form-control"  id="detalle_m" name="detalle_m" ></textarea> 
              <label>Costo de Compra </label>
              <input type="number" id="precio_m" name="precio_m" class='form-control' >
            </div>
          </div>
          <div class="col-sm-6">
            <center><img height='100' weight='100' id='imagen_base_m'>
               <input id="imagen-adjunta_m" 
                                           class="btn btn-primary"
                                           type='file'
                                           data-id=""
                                           name='imagen-adjunta_m'
                                           multiple>
            </center>
          </div>
        </div>
        <div class="row">
           <div class="col-sm-3">
            <div class="form-group">
              <label>Precio Minimo</label>
              <input type="number" id="costo_minimo_m" name='costo_minimo_m' class='form-control'  >
            </div>
           </div>
            <div class="col-sm-3">
            <div class="form-group">
              <label>Precio Standar</label>
              <input type="number" id="costo_standar_m" name='costo_standar_m' class='form-control' >
            </div>
           </div>
            <div class="col-sm-3">
            <div class="form-group">
              <label>Precio Máximo</label>
              <input type="number" id="costo_maximo_m" name='costo_maximo_m' class='form-control'  >
            </div>
           </div>
        </div>

      </form>      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="actualizar_producto()">Actualizar Cambios</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal crear-->
<div class="modal fade" id="crear_modal" tabindex="-1" role="dialog" aria-labelledby="crear_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title"  > Caracteristicas de Producto</h5>        
      </div>
      <div class="modal-body">
        <form id="form_producto_nuevo">
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
        <button type="button" class="btn btn-primary" onclick="crear_producto_nuevo(0)">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>