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
                <h3 class="box-title" id='titulo_documento'>Empresas Registradas</h3>

            </div>
            <div  class="box-body">
             <button type="button" class="btn btn-success " onclick="$('#nueva_bodega').modal('show'); " >Registrar Nueva Empresa</button><br><br>
                <table id="example" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nombre Comercial</th>
                            <th>Contacto</th>
                            
                            <th>Correo</th>
                            <th>Teléfono</th>
                           <th>Dirección</th>
                            <th>Ciudad</th>
                           
                            <th>Opciones</th>
                          
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($empresas as $valor): ?>
                            <tr>
                            <td><?php echo htmlspecialchars($valor['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['contacto'], ENT_QUOTES, 'UTF-8'); ?></td>
                            
                            <td><?php echo htmlspecialchars($valor['correo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['telefono'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['direccion'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['nombre_ciudad'], ENT_QUOTES, 'UTF-8'); ?></td>
                         

                            <td align="center">                                
                                <a   onclick="eliminar_empresa('<?php echo $valor['id_empresa']; ?>')" ><span class="glyphicon glyphicon-remove"> </span>   </a> 
                                <a   onclick="modal_modificar_empresa('<?php echo $valor['id_empresa']; ?>')" ><span class="glyphicon glyphicon-edit"> </span>  </a>    
                            </td>
                         
                            
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>


<div id="nueva_bodega" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        
        <h4 class="modal-title ">Registro de Empresa Nueva</h4>
      </div>
      <div class="modal-body">
         <form method="post"  id="form_ficha_registro">  
            <div class="row">                              
                 <div class="col-sm-4">
                     <div class="form-group">
                        <label >Nombre Comercial:</label>
                        <input type="text" class="form-control" id="nombre_comercial">                
                      </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Nombre Contacto:</label>
                        <input type="text" class="form-control" id="contacto" >                        
                      </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Telefono:</label>
                        <input type="number" maxlength="10"  class="form-control" id="telefono">                        
                      </div>
                  </div>                             
            </div>
            
            <div class="row">                              
                  
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Correo:</label>
                        <input type="text" class="form-control" id="correo">                        
                      </div>
                  </div> 
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Dirección:</label>
                        <input type="text" class="form-control" id="direccion">                        
                      </div>
                  </div> 
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Ciudad:</label>
                            <select class="form-control" id="ciudad" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($ciudades as $valor): ?>
                          <option value='<?php echo ($valor['id_ciudad']); ?>'><?php echo ($valor['nombre']); ?></option>                           
                            <?php endforeach; ?>
                        </select>
                      </div>
                  </div>                                          
            </div>
            <div class="row">                              
                 <div class="col-sm-12">
                     <div class="form-group">
                        <label >Observaciones:</label>                            
                            <textarea class="form-control" rows="3" id="detalles">  </textarea>                      
                      </div>
                  </div>                                          
            </div>
           
        </form>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-success"  onclick="guardar_registro_empresa()">Guardar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


<div id="modificar_empresa" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        
        <h4 class="modal-title ">Modificar  Empresa </h4>
      </div>
      <div class="modal-body">
         <form method="post"  id="form_ficha_registro_1">  
            <div class="row">                              
                 <div class="col-sm-4">
                     <div class="form-group">
                        <label >Nombre Comercial:</label>
                        <input type="text" class="form-control" id="nombre_comercial_1">  
                        <input type="text" class="form-control" id="id_empresa_modal" style="display: none" readonly="readonly">  
                                      
                      </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Nombre Contacto:</label>
                        <input type="text" class="form-control" id="contacto_1" >                        
                      </div>
                  </div>
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Telefono:</label>
                        <input type="text" class="form-control" id="telefono_1">                        
                      </div>
                  </div>                             
            </div>
            
            <div class="row">                              
                  
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Correo:</label>
                        <input type="text" class="form-control" id="correo_1">                        
                      </div>
                  </div> 
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Dirección:</label>
                        <input type="text" class="form-control" id="direccion_1">                        
                      </div>
                  </div> 
                  <div class="col-sm-4">
                     <div class="form-group">
                        <label >Ciudad:</label>
                            <select class="form-control" id="ciudad_1" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($ciudades as $valor): ?>
                          <option value='<?php echo ($valor['id_ciudad']); ?>'><?php echo ($valor['nombre']); ?></option>                           
                            <?php endforeach; ?>
                        </select>
                      </div>
                  </div>                                          
            </div>
            <div class="row">                              
                 <div class="col-sm-12">
                     <div class="form-group">
                        <label >Observaciones:</label>                            
                            <textarea class="form-control" rows="3" id="detalles_1">  </textarea>                      
                            <input type="hidden" id="id_emp">
                      </div>
                  </div>                                          
            </div>
           
        </form>
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-success"  onclick="modificar_empresa_x_id()">Editar</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>



       
       
    </section>

    <!-- /.content -->
</aside><!-- /.right-side -->

