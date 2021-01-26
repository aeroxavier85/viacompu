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
          <h3 class="box-title" id='titulo_documento'>Cotizaciones de Clientes </h3>
        </div>
    
        <div class="box-body">

            <div class="row">                              
              
            </div>
             <div class="modal-footer">
                 
                 
                    <button class="btn btn-primary" onclick="mostrar_limpiar_campos()"><span class="glyphicon glyphicon-plus"> Cotizar </span></button>  

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
                            <th>Cotización</th>
                            <th>Cliente</th>  
                            <th>Email Cliente</th>                           
                            <th>Generado por</th>  
                            <th>Fecha</th>
                             <th>Estado</th>
                            <th>Opciones</th>                           
                                                                             
                        </tr>
                    </thead>
                    <tbody>
                       
                            <?php foreach ($listar_cotizaciones as $valor): ?>
                            <tr>
                            <td>Cotización No: <?php echo htmlspecialchars($valor['id_cotizacionescab'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['cliente'], ENT_QUOTES, 'UTF-8'); ?></td>
                               <td><?php echo htmlspecialchars($valor['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($valor['fecha_cotizacion'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <?php if( $valor['tipo']=='CA') {?>
                            <td><span class='label label-warning'> Pendiente</span></td>    
                            <?php } ?>
                             <?php if( $valor['tipo']=='CC') {?>
                            <td><span class='label label-success'> Enviada </span></td>    
                            <?php } ?>
                            <td align="center"> 
                              <a href="<?php echo site_url('Control_Cotizaciones/mail_cotizaciones/'.$valor['id_cotizacionescab']) ?>" > <span class="glyphicon glyphicon-envelope"> </span></a> &nbsp;
                              <a   onclick="imprimir_guia('<?php echo $valor['id_cotizacionescab']; ?>')" ><span class="glyphicon glyphicon-print"> </span>  </a> &nbsp;
                              <a href="<?php echo site_url('Control_Cotizaciones/continuar_cotizacion?id_cotizacion='.$valor['id_cotizacionescab']) ?>" > <span class="glyphicon glyphicon-edit"> </span></a>
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



<div class="modal fade" id="crear_cliente_modal" tabindex="-1" role="dialog" aria-labelledby="crear_cliente_modal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" >
        <h4 class="modal-title"  > Datos de Cliente a Cotizar</h5>        
      </div>
          <div class="modal-body">
        <form id="form_producto_nuevo">
        <div class="row">
          <div class="col-sm-3">
              <label>Nombre Cliente </label>
           </div> 
          <div class="col-md-6">
                 <select class="form-control" id="cliente" >                              
                              <option value='0'> -- seleccione --</option>                           
                         <?php foreach ($listar_clientes_cotizar as $valor): ?>
                          <option value='<?php echo ($valor['cliente']); ?>'><?php echo ($valor['cliente']); ?></option>  <?php endforeach; ?>
                 </select>  
                  <input type="text" name="cliente_nuevo" id='cliente_nuevo'  class="form-control" style="display: none">
                 <a  onclick="ocultar_campo_cliente()"> Cliente Nuevo </a> 
          </div>
        </div>    
        <div class="row">
          <div class="col-sm-3">
            <label>Email </label>
           </div> 
          <div class="col-sm-6">
              <input type="text" name="email" id='email'  class="form-control" >
          </div>
        </div>       
 
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id='cotizar_lista_cliente' onclick="abrir_cotizacion(1)">Cotizar</button> 
          <button type="button" class="btn btn-primary" id='cotizar_nuevo_cliente' onclick="abrir_cotizacion(2)" style="display: none;">Cotizar</button>
        </div>
        </form>   
       </div>
       
           
    </div>
     
    </div>
  </div>
