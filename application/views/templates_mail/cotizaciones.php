<html lang='en'>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
<head>
    <title>Cotización</title>

</head>
<body style='margin:0; padding:0;'  leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
    <br>
    <img width="120" height="90" src="https://viacompu.com/wp-content/uploads/2018/04/versiones-cromaticas-1-1030x728.png">

 <br> <br>
 <table border='0' width='800' cellpadding='0' cellspacing='0' class='container'>
                <tr>
                    <td class='container-padding content' align='left'>
                     
                        <br>

                        <div class='body-text'>
                            Estimad(@) . <br><br>

                            Se adjunta la Cotización Solicitada, acorde a los detalles recibidos.
                            <br><br>
                           <hr>
                           <center>
                           <table  border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse">
                           <?php foreach ($registro_cotizacion_parcial_cab as $value) {  ?>
                                   
                           <tr><th >Cotización No.</th><td ><?php echo $value['id_cotizacionescab']?> </td></tr>
                           <tr><th >Vendedor</th><td ><?php echo $value['cotizador']?></td></tr>
                           <tr><th >Teléfono</th><td>‌‌ 0991196445</td></tr>
                           <tr><th >Email</th><td><?php echo $value['email']?></td></tr>
                           <tr><th >Empresa / Cliente </th><td><?php echo $value['cliente']?></td></tr> 
                           
                             <?php  }  ?>
                            
                           </table>
                          </center>
                            <br> 
                            <center><table  border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse">
                           <tr><th >Producto</th><th >Detalle</th><th >Cantidad</th><th >Precio Unitario</th><th >Subtotal</th></tr>     
                           <?php  
                           $subtotal = 0;
                           foreach ($registro_cotizacion_parcial as $value2) {  ?>
                                   
                           <tr><td ><?php echo $value2['producto']?> </td><td ><?php echo $value2['detalle']?> </td><td ><?php echo $value2['cantidad']?> </td><td > $ <?php echo $value2['costo_cotizado']?> </td><td > $ <?php echo $value2['subtotal']?> </td></tr>
                                                    
                             <?php 
                              $subtotal = $subtotal + $value2['subtotal'];
                              } 
                              $IVA =  $subtotal * 0.12; 
                              $total =  $subtotal + $IVA; 
                               ?>
                              
                             <tr><td  colspan="4"><strong>SUBTOTAL</strong></td><td align='center'> $ <?php echo $subtotal ?> </td></tr>       
                             <tr><td  colspan="4"><strong>IVA 12 %</strong> </td><td align='center'> $ <?php echo $IVA ?></td></tr>       
                             <tr><td  colspan="4"><strong>TOTAL</strong></td><td align='center'> $ <?php echo $total ?> </td></tr>  
                           </table></center>  
                           <hr> 
                            <br><br>
                          <strong> Observaciones: </strong> <?php echo $value['observaciones']?>
                            <br><br>
                            Saludos Cordiales
                            <br><br>
                            <hr><br>
                            Ventas   PBX +593 (4)  6036141 (4) 2566030 | Celular: +593 (9) 91196445 | <br>
                            Junin 422 Y Cordova | Guayaquil - Ecuador |<br>
                            Sucursal Mall El Fortin Subsuelo 1 Local 006A<br>
                            ViaCompu-Store   <br><br>

                        </div>
                    </td>
                </tr>
                <tr>
                    <td class='container-padding footer-text' align='left'>
                        <br><br>

                        <strong>  <br>Copyright &copy; 2021.</strong><br>
                        </span>

                        <br><br>
                    </td>
                </tr>
 </table>
      
</body>
</html>