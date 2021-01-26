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
          <h3 class="box-title" id='titulo_documento'>Movimientos</h3>
        </div>
    
        <div class="box-body">

            <div class="row">                              
                 <!-- <div class="col-sm-4">
                     <div class="form-group">
                        <label >Empresa:</label>
                         <select class="form-control select2" id="empresa" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($empresas as $valor): ?>
                          <option value='<?php echo ($valor['id_empresa']); ?>'><?php echo ($valor['nombre']); ?></option>  <?php endforeach; ?>
                        </select>
                      
                      </div>
                  </div> -->
                        
            </div>
             <div class="modal-footer">
                 
                  <a href="<?php echo site_url('Control_Ingresos/movimientos_ingreso') ?>" class="btn btn-primary"> Registrar Ingreso</a>
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
                            <th>Destino</th> 
                            <th>Fecha</th>
                            <th>Estado</th>                            
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                            <?php foreach ($lista_ingresos as $valor): ?>
                            <tr>
                            <td>Guia-<?php echo htmlspecialchars($valor['id_ingresocab'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['nombre'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['fecha'], ENT_QUOTES, 'UTF-8'); ?></td>
                           <?php if( $valor['tipo']=='IA') {?>
                            <td><span class='label label-warning'>Abierto</span></td>    
                            <?php } ?>
                             <?php if( $valor['tipo']=='IC') {?>
                            <td><span class='label label-success'>Ingreso Completo </span></td>    
                            <?php } ?>
                            
                            <td align="center">                                                               
                               
                                 <a href="<?php echo site_url('Control_Ingresos/continuar_guia/'.$valor['id_ingresocab']) ?>" > <span class="glyphicon glyphicon-edit"> </span></a>  
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

