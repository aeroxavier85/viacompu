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
          <h3 class="box-title" id='titulo_documento'>Salida de Mercaderia</h3>
        </div>
    
        <div class="box-body">

            <div class="row">                              
               <!--   <div class="col-sm-4">
                     <div class="form-group">
                        <label >Empresa:</label>
                         <select class="form-control select2" id="empresa" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($empresas as $valor): ?>
                          <option value='<?php echo ($valor['id_empresa']); ?>'><?php echo ($valor['nombre']); ?></option>  <?php endforeach; ?>
                        </select>
                      
                      </div>
                  </div>-->
                        
            </div>
             <div class="modal-footer">
                 
                  <a href="<?php echo site_url('Control_Egresos/movimientos_egresos') ?>" class="btn btn-primary"> Registrar Salida</a>
             </div>  
            <hr>
            <div class="row">
           
            <div class="col-sm-12">
             <div class="box box-success"> 
                <div class="box-header"></div>
                 <div class="box-body">
                    <table id="example" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Guía</th>
                            <th>Origen</th>                           
                            <th>Generado por</th>  
                            <th>Fecha</th>
                            <th>Estado</th>                           
                            <th> Orden</th>    
                            <th>Opciones</th>                           
                        </tr>
                    </thead>
                    <tbody>
                       
                            <?php foreach ($lista_ingresos as $valor): ?>
                            <tr>
                            <td>Guia-<?php echo htmlspecialchars($valor['id_egresocab'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                           <?php if( $valor['tipo']=='EA') {?>
                            <td><span class='label label-warning'>Abierto - Debe Eliminarse</span></td>    
                            <?php } ?>
                             <?php if( $valor['tipo']=='EC') {?>
                            <td><span class='label label-success'>Registro de Egreso Completo </span></td>    
                            <?php } ?>
                             <td align="center"><a   onclick="imprimir_guia('<?php echo $valor['id_egresocab']; ?>')" ><span class="glyphicon glyphicon-print"> </span>
                            </span>
                             </td>
                            
                            <td align="center"><a   onclick="eliminar_guia_egreso('<?php echo $valor['id_egresocab']; ?>')" ><span class="glyphicon glyphicon-remove"> </span>  </a></td>    
                            

                                                                             
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

