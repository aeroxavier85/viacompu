


//////////////////////////////////////////////////////////
//Banchon services JS
$('.select2').select2();

$('#cod_barras_busqueda').keypress(function(event) {
    if (event.key === "Enter") {


     var urlEmp = base_url+'/Servicios/buscar_codigo_barra';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "bodega_origen":$('#bodega').val(),
               "cod_barras":$('#cod_barras_busqueda').val(),
              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
                     $('#detalle').val(data1[0]['descripcion_producto']);                
                     $('#tipo_producto').val(data1[0]['producto']);                
                     $("#imagen_base_ingreso").attr("src",data1[0]['imagen']);                     
                     $('#estado').val(data1[0]['estado_producto']);
                     $('#estado').trigger('change');
                     $('#id_producto').val(data1[0]['id_producto']);                      
                      $('#ppp').val(data1[0]['costo_minimo']);
                      $('#psujerido').val(data1[0]['costo_standar']);
                  
                       }
                   else
                   {
                   $('#detalle').val('');                
                     $('#tipo_producto').val('');                
                     $("#imagen_base_ingreso").attr("src",'');                     
                     $('#estado').val('');
                     $('#estado').trigger('change');
                     $('#cod_barras_busqueda').val('');
                      $('#ppp').val('');
                      $('#psujerido').val('');     
                       $('#pvp').val('');   
                  alert('Registro No encontrado');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

    }
});

 var tabla_ingreso=$('#table_ingresos').DataTable();

 var table_ingresos_guia=$('#table_ingresos_guia').DataTable({lengthMenu: [[5, 10, -1], [5, 10, "All"]], });
 var table_movimientos_internos_guia=$('#table_movimientos_internos_guia').DataTable({lengthMenu: [[3], [3, "All"]], });

 var table1=$('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    });
 var table_productos_componentes1=$('#table_productos_componentes1').DataTable({lengthMenu: [[5, 10, -1], [5, 10, "All"]], });
 var table_inventario=$('#table_inventario').DataTable( {
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    });
 var table_transacciones=$('#table_transacciones').DataTable( {
        dom: 'Bfrtip',
        buttons: [
             'excel',{
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }, 'print'
        ]
    });
 
 var table_ordenes=$('#table_ordenes').DataTable();
 var table_componentes=$('#table_componentes').DataTable();
 var table_productos_componentes=$('#table_productos_componentes').DataTable({lengthMenu: [[5, 10, -1], [5, 10, "All"]], });

 
 function abrir_guia(){
     if( $('#empresa').val()==0){alert('Seleccione Empresa'); return false;}
     if( $('#bodega').val()==0){alert('Seleccione Bodega'); return false;}

     var urlEmp = base_url+'/Servicios/abrir_guia_ingreso';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa').val(),
               "bodega":$('#bodega').val(),
              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
                    // $('#guia').val(data1);
                    // $('#empresa').prop("disabled", "true");
                    // $('#bodega').prop("disabled", "true");
                    // $('#producto').removeAttr("disabled");
                    // $('#marca').removeAttr("disabled");
                    // $('#modelo').removeAttr("disabled");
                    // $('#estado').removeAttr("disabled");
                    
                    // $('#referencia').removeAttr("readonly");
                    // $('#cod_barras').removeAttr("readonly");
                    // $('#descripcion').removeAttr("readonly");

                     // $('#guardar_ingreso').removeAttr("disabled");
                     // $('#limpiar_ingreso_btt').removeAttr("disabled");
                     // $('#cerrar_guia').removeAttr("disabled");
                    // location.reload('/control_ingresos/ingresos_inicial');
                      window.open(base_url+'/Control_Ingresos/continuar_guia/'+data1 );
                   }
                   else
                   {
                                     
                  alert('Error al guardar Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

 }

function abrir_egreso(){
     if( $('#empresa').val()==0){alert('Seleccione Empresa'); return false;}
     if( $('#bodega').val()==0){alert('Seleccione Bodega'); return false;}

     var urlEmp = base_url+'/Servicios/abrir_guia_egreso';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa').val(),
               "bodega":$('#bodega').val(),
              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
                     $('#guia_egreso').val(data1);
                     $('#cod_barras_busqueda').removeAttr("readonly");                
                     $('#empresa').prop("disabled", "true");  
                     
                     $('#guardar_egreso').removeAttr("disabled");                                                                    

                   }
                   else
                   {
                                     
                  alert('Error al guardar Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

 }
function ocultar_campo_cliente(){
    $('#cliente_nuevo').show();
    $('#cliente').hide();
    $('#cotizar_lista_cliente').hide();
    $('#cotizar_nuevo_cliente').show();

}

function mostrar_limpiar_campos(){
    $('#cliente_nuevo').hide();
    $('#cliente').show();
    $('#cliente').val(0);
     $('#cliente_nuevo').val('');
     $('#email').val('');
    $('#cotizar_lista_cliente').show();
    $('#cotizar_nuevo_cliente').hide();
    $('#crear_cliente_modal').modal('show');
}



function abrir_cotizacion(id){

    if(id==1){
        if( $('#cliente').val()=='' ){alert('Ingrese Nombre de Cliente'); return false;}  else { var cliente=$('#cliente').val()} 
    }
    if(id==2){
        if( $('#cliente_nuevo').val()=='' ){alert('Ingrese Nombre de Cliente'); return false;} else { var cliente=$('#cliente_nuevo').val()}   
    }
     
     if( $('#email').val()=='' ){alert('Ingrese email del cliente'); return false;}

     var urlEmp = base_url+'/Servicios/abrir_guia_cotizacion';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "cliente":cliente,
               "email":$('#email').val(),
              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
                      var urlEmp = base_url+'Control_Cotizaciones/continuar_cotizacion?id_cotizacion='+data1;
                      window.location.href=urlEmp;     
                                                                                        

                   }
                   else
                   {
                                     
                  alert('Error al Generar Cotización');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

 } 
  function abrir_guia_entre_bodegas(){
     if( $('#empresa_movimientos_interno').val()==0){alert('Seleccione Empresa'); return false;}
     if( $('#bodega_origen').val()==0){alert('Seleccione Bodega de Origen'); return false;}
     if( $('#bodega_destino').val()==0){alert('Seleccione Bodega de Destino'); return false;}

     var urlEmp = base_url+'/Servicios/abrir_guia_movimiento_bodegas';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa_movimientos_interno').val(),
               "bodega_origen":$('#bodega_origen').val(),
               "bodega_destino":$('#bodega_destino').val(),              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
                     $('#guia_movimiento_bodegas').val(data1);
                     $('#empresa_movimientos_interno').prop("disabled", "true");
                     $('#bodega_origen').prop("disabled", "true");
                     $('#bodega_destino').prop("disabled", "true");                     
                     $('#abrir_guia_entre_bodegas').prop("disabled", "true");

                     $('#cod_barras_busqueda').removeAttr("readonly");                 
                     $('#enviar_guia_bodegas').removeAttr("disabled");
                     $('#agregar_guia_bodegas').removeAttr("disabled");
                     $('#estado').removeAttr("disabled");
                   
                    // location.reload('/control_ingresos/ingresos_inicial');
                                
                   }
                   else
                   {
                                     
                  alert('Error al guardar Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

 }

 $('#selEmpresaOrdenes').change(function() {
       var id_empresa=($('#selEmpresaOrdenes').val());

       $('#selProductosOrdenes').empty();


       $.ajax({
            type: "POST",
            url:  base_url+'/control_productos/obtener_productos_por_empresa',
            data: {  
                   "id_empresa":id_empresa,
             }, 
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Procesando datos..."
                });
            },
            success: function (data) {
                HoldOn.close();
                
                var data1 = JSON.parse(data);

                var long=data1.length;
                          
                //console.log(data1);
                 $('#selProductosOrdenes').append('<option value="0" >--Todos--</option>');
                for (var x=0; x<long;x++){
                       var detalle1=data1[x]["descripcion"];
                       var id1=data1[x]["id_producto"];
                       $('#selProductosOrdenes').append('<option value="'+id1+'" >'+detalle1+'</option>');
                    
                }
               
            },
            Error:function(data){
                alert('Error al realizar la Consulta.');
            }
    });
   
});


$('#producto').change(function() {
        
       $.ajax({
            type: "POST",
            url:  base_url+'/Servicios/obtener_producto_por_id_para_ingreso',
            data: {  
                   "id_producto":$('#producto').val(),
             }, 
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Procesando datos..."
                });
            },
            success: function (data) {
                HoldOn.close();                
                var data1 = JSON.parse(data);
                var long=data1.length;                                        
                   $('#detalle').val(data1[0]['descripcion_producto']);                
                   $("#imagen_base_ingreso").attr("src",data1[0]['imagen']);       
                },
            Error:function(data){
                alert('Error al realizar la Consulta.');
            }
    });
   
}); 


$('#cliente').change(function() {
        
       $.ajax({
            type: "POST",
            url:  base_url+'/Servicios/obtener_email_cliente',
            data: {  
                   "cliente":$('#cliente').val(),
             }, 
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Procesando datos..."
                });
            },
            success: function (data) {
                HoldOn.close();                
                var data1 = JSON.parse(data);
                                                     
                   $('#email').val(data1[0]['email']);                
                        
                },
            Error:function(data){
                alert('Error al realizar la Consulta.');
            }
    });
   
});

$('#producto_cotizar').change(function() {
        
       $.ajax({
            type: "POST",
            url:  base_url+'/Servicios/obtener_producto_por_id_para_cotizar',
            data: {  
                   "id_producto":$('#producto_cotizar').val(),
             }, 
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Procesando datos..."
                });
            },
            success: function (data) {
                HoldOn.close();                
                var data1 = JSON.parse(data);
                var long=data1.length;                                        
                   $('#detalle').val(data1[0]['descripcion_producto']);                
                   $('#stock').val(data1[0]['saldo_actual']);
                   $('#ppp').val(data1[0]['costo_minimo']);
                   $('#psujerido').val(data1[0]['costo_standar']);
                   $("#imagen_base_ingreso").attr("src",data1[0]['imagen']);       
                },
            Error:function(data){
                alert('Error al realizar la Consulta.');
            }
    });
   
}); 
 $('#empresa').change(function() {
       var id_empresa=($('#empresa').val());
  
       $.ajax({
            type: "POST",
            url:  base_url+'/productos/obtener_bodegas_por_empresa',
            data: {  
                   "id_empresa":id_empresa,
             }, 
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Procesando datos..."
                });
            },
            success: function (data) {
                HoldOn.close();                
                var data1 = JSON.parse(data);
                var long=data1.length;                                        
                 $('#bodega').empty(); 
                
               
                for (var x=0; x<long;x++){
                       var detalle1=data1[x]["nombre"];
                       var id1=data1[x]["id_bodega"];
                       $('#bodega').append('<option value="'+id1+'" >'+detalle1+'</option>');
                        $('#bodega').trigger('change'); 
                }
               
                },
            Error:function(data){
                alert('Error al realizar la Consulta.');
            }
    });
   
}); 

$('#empresa_movimientos_interno').change(function() {
       var id_empresa=($('#empresa_movimientos_interno').val());
  
       $.ajax({
            type: "POST",
            url:  base_url+'/Control_Productos/obtener_bodegas_por_empresa',
            data: {  
                   "id_empresa":id_empresa,
             }, 
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Procesando datos..."
                });
            },
            success: function (data) {
                HoldOn.close();                
                var data1 = JSON.parse(data);
                var long=data1.length;                                        
                
                for (var x=0; x<long;x++){
                       var detalle1=data1[x]["nombre"];
                       var id1=data1[x]["id_bodega"];
                       $('#bodega_origen').append('<option value="'+id1+'" >'+detalle1+'</option>');
                       $('#bodega_destino').append('<option value="'+id1+'" >'+detalle1+'</option>');
                    
                }
               
                },
            Error:function(data){
                alert('Error al realizar la Consulta.');
            }
    });
   
}); 
function valida_codigos_repetidos(){
        var urlEmp = base_url+'/Servicios/valida_codigos_repetidos';
         $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "cod_barras":$('#cod_barras').val(),              
              // "guia":$('#guia').val(), 
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                      
            if (data1!=0){
            alert(data1);
            $('#cod_barras').val('');
            return false; 
                         }else{ 
                          guardar_registro_bodega();
                         }                        
        },
        Error:function(data){
            alert('Error al verificar codigo de barra');
            }
        });
}


function valida_codigos_repetidos_egresos(){
    if($('#pvp').val()==''){alert('Ingrese Precio de Venta'); return false;}
    var pvp=$('#pvp').val();
    var ppp=$('#ppp').val();
    var diferencia=pvp-ppp;
  //  alert(diferencia);
        if(diferencia < 0){alert('El precio de venta NO puede ser inferior al precio mínimo  '); return false;}
        var urlEmp = base_url+'/Servicios/valida_codigos_repetidos_egresos';
         $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "cod_barras":$('#cod_barras_busqueda').val(),              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                      
            if (data1!=0){
            alert(data1);
            $('#cod_barras_busqueda').val('');
            return false; 
                         }else{ 
                          $('#cerrar_guia_egreso').removeAttr("disabled");
                          guardar_registro_bodega_egreso();
                         }                        
        },
        Error:function(data){
            alert('Error al verificar codigo de barra');
            }
        });
}

function valida_codigos_repetidos_movimientos_internos(){
        var urlEmp = base_url+'/Servicios/valida_codigos_repetidos_movimientos_internos';
         $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "cod_barras":$('#cod_barras_busqueda').val(),              
               "guia":$('#guia_movimiento_bodegas').val(),              
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                      
            if (data1==1){
            alert('Codigo de Barras ya existe');
            $('#cod_barras').val('');  
            return false; 
                         }else{ 
                          guardar_registro_movimiento_bodegas();
                         }                        
        },
        Error:function(data){
            alert('Error al verificar codigo de barra');
            }
        });
}

function  guardar_registro_movimiento_bodegas(){
 
     if( $('#estado').val()==0){alert('Seleccione Estados'); return false;}
     if( $('#guia').val()==0){alert('Ingrese Número de Guía'); return false;}

     var urlEmp = base_url+'/Servicios/guardar_registro_movimiento_bodegas';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {               
               "guia":$('#guia_movimiento_bodegas').val(),
               "cod_barras":$('#cod_barras_busqueda').val(),               
               "estado":$('#estado').val(), 
         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
               table_movimientos_internos_guia.clear();
                //table_movimientos_internos_guia.DataTable().rows().clear().draw();
                 //$('#referencia').prop("readonly", "true");
                for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_ingreso_interno(" +data1[x]['id_movimientodet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_movimientos_internos_guia.row.add([
                        data1[x]["cod_barras"],
                       
                        data1[x]["Estado_producto"],
                        data1[x]["categoria"],
                        data1[x]["marca"],
                        data1[x]["modelo"],
                        data1[x]["bodega"],
                        accion
                        ]).draw();
                }
                    $('#cod_barras_busqueda').val('');                    
                    $('#tipo_producto').val('');                    
                    $('#marca_producto').val('');                    
                    $('#modelo_producto').val('');                    
                    $('#estado').val('0');  
                    $('#estado').trigger('change');                  
                    $('#cod_barras_busqueda').val('');                    
                   }
                   else
                   {
                                     
                  alert('Error al guardar Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function eliminar_registro_ingreso_interno(id){
    var urlEmp = base_url+'/Servicios/eliminar_registro_ingreso_interno';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "id_registro":id,
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
          
        if(data1!='Err'){               
                table_movimientos_internos_guia.clear();   
                table_movimientos_internos_guia.draw();                  
                   for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_ingreso_interno(" +data1[x]['id_movimientodet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_movimientos_internos_guia.row.add([
                        data1[x]["cod_barras"],                       
                        data1[x]["Estado_producto"],
                        data1[x]["categoria"],
                        data1[x]["marca"],
                        data1[x]["modelo"],
                        data1[x]["bodega"],
                        accion
                        ]).draw();
                } 
                                
                   }
                   else
                   {                       
                  alert('Error al eliminar registro');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}



function eliminar_guia_egreso(id){
    var urlEmp = base_url+'/control_egresos/eliminar_guia_egreso';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "id_egresocab":id,
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
            if(data1==0){
                alert('Error , vuelva a intentar')    
            }else{
                 var urlEmp = base_url+'control_egresos/listar_egreso_bodegas';
                window.location.href = urlEmp;
            }
   

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function  guardar_registro_bodega(){
 //    if( $('#empresa').val()==0){alert('Seleccione Empresa'); return false;}
  //   if( $('#bodega').val()==0){alert('Seleccione Bodega'); return false;}

     if( $('#producto').val()==0){alert('Seleccione Producto'); return false;}   
     if( $('#estado').val()==0){alert('Seleccione Estados'); return false;}
     if( $('#guia').val()==0){alert('Ingrese Número de Guía'); return false;}
     if( $('#referencia').val()==0){alert('Ingrese Número de Referencia'); return false;}
     if( $('#cod_barras').val()==0){alert('Ingrese Codigo de Barra'); return false;}

     var urlEmp = base_url+'/Servicios/guardar_registro_bodega';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa').val(),
               "bodega":$('#bodega').val(),
               "producto":$('#producto').val(),              
               "estado":$('#estado').val(),
               "guia":$('#guia').val(),
               "referencia":$('#referencia').val(),
               "cod_barras":$('#cod_barras').val(),                           

         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
            
                table_ingresos_guia.clear();
                 //$('#referencia').prop("readonly", "true");
                for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_ingreso(" +data1[x]['id_ingresodet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_ingresos_guia.row.add([
                        data1[x]["cod_barras"],
                        data1[x]["producto"],
                        data1[x]["Estado_producto"],                       
                        accion
                        ]).draw();
                }
                    // limpiar_movimiento(2);
                    // location.reload('/control_ingresos/ingresos_inicial');
                       $('#cod_barras').val('');         
                   }
                   else
                   {
                                     
                  alert('Error al guardar Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function  guardar_registro_bodega_egreso(){
 
     var urlEmp = base_url+'/Servicios/guardar_registro_bodega_egreso';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa').val(),
               "bodega":$('#bodega').val(),
               "producto":$('#id_producto').val(),              
               "estado":$('#estado').val(),
               "guia":$('#guia_egreso').val(),               
               "cod_barras":$('#cod_barras_busqueda').val(),                           
               "ppp":$('#pvp').val(),

         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
            
                table_ingresos_guia.clear();
                 //$('#referencia').prop("readonly", "true");
                for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_ingreso_egreso(" +data1[x]['id_egresodet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_ingresos_guia.row.add([
                        data1[x]["cod_barras"],                        
                        data1[x]["producto"],
                        data1[x]["precio_venta"],
                        data1[x]["Estado_producto"],                       
                        accion
                        ]).draw();
                }                   
                     $('#cod_barras_busqueda').val('');  
                     $('#id_producto').val('');   
                     $('#tipo_producto').val('');                                
                     $('#estado').val('');  
                     $('#ppp').val('');  
                     $('#pvp').val('');  
                     $('#psujerido').val('');  
                     $('#detalle').val('');
                      $('#estado').val('0');  
                    $('#estado').trigger('change'); 
                      $("#imagen_base_ingreso").attr("src",'');       
                   }
                   else
                   {
                                     
                  alert('Error al guardar Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function  guardar_registro_cotizacion(){
 
  if( $('#producto_cotizar').val()==0){alert('Seleccione Producto'); return false;}   
  if( $('#pvp').val()==0){alert('Ingrese valor cotizado'); return false;}   
  if( $('#cantidad').val()==0){alert('Ingrese cantidad'); return false;}   
  
  var subtotal=($('#pvp').val() * $('#cantidad').val());
  var urlEmp = base_url+'/Servicios/guardar_registro_cotizacion';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
                "id_cotizacion":$('#guia_cotizacion').val(),
               "costo_cotizado":$('#pvp').val(),
               "id_producto":$('#producto_cotizar').val(),
               "cantidad":$('#cantidad').val(),
               "subtotal":subtotal,
              

         }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
            
                table_ingresos_guia.clear();
              
                for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_cotizacion(" +data1[x]['id_cotizacionesdet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_ingresos_guia.row.add([
                        data1[x]["producto"],                        
                        data1[x]["costo_cotizado"],
                        data1[x]["cantidad"],
                        data1[x]["subtotal"],                       
                        accion
                        ]).draw();
                }                   
                     $('#pvp').val('');  
                     $('#producto_cotizar').val('');   
                     $('#cantidad').val('');                                
                     $('#producto_cotizar').val(''); 
                     $('#producto_cotizar').trigger('change');                               
                      $('#detalle').val('');
                       $('#psujerido').val('');
                        $('#ppp').val('');
                        $('#stock').val('');
                         $("#imagen_base_ingreso").attr("src",'../assets/images/no-imagen.jpg');

                          
                   }
                   else
                   {                                    
                  alert('Error al guardar la cotizacion');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function eliminar_registro_cotizacion(id){
    var urlEmp = base_url+'/Servicios/eliminar_registro_cotizacion';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "id_registro":id,
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
          
        if(data1!='Err'){
                table_ingresos_guia.clear();   
                table_ingresos_guia.draw();                  
                for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_cotizacion(" +data1[x]['id_cotizacionesdet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_ingresos_guia.row.add([
                        data1[x]["producto"],                        
                        data1[x]["costo_cotizado"],
                        data1[x]["cantidad"],
                        data1[x]["subtotal"],                       
                        accion
                        ]).draw();
                }   
                                
                   }
                   else
                   {                       
                  alert('Error al eliminar registro');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

$('#cerrar_guia_cotizacion_final').on("click", function (e) { 
     var guia=$('#guia_cotizacion').val();
     var urlEmp = base_url+'/Servicios/cerrar_guia_cotizacion';
       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
             
               "guia":$('#guia_cotizacion').val(),
               "observaciones":$('#observaciones').val()

               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1==1){
                    alert('Cotización Cerrada y Enviada al Cliente');
                     
                   // window.open(base_url+'/Pdfs/generar_cotizacion/'+guia, '_blank');     
                   window.open(base_url+'/Control_Cotizaciones/mail_cotizaciones/'+guia ,"_self"); 
                                              
                  // window.location.href=base_url+"/Control_Cotizaciones/listar_cotizaciones";                     
                   }
                   else
                   {
                                     
                  alert('Error al Cerrar la Cotización');
                   }

            },
        Error:function(data){
            HoldOn.close();
            alert('Error al realizar la Consulta.');
            }
        });
});

$('#limpiar_ingreso_btt').on("click", function (e) { 
                     $('#producto').val('0');
                     $('#marca').val('0');
                     $('#modelo').val('0');
                     $('#estado').val('0');                    
                     $('#cod_barras').val('');
                     $('#descripcion').val('');
                     $('#producto').trigger('change');
                     $('#marca').trigger('change');
                     $('#estado').trigger('change');
});

 function cerrar_guia_movimientos(){ 
    
     var urlEmp = base_url+'/Servicios/cerrar_guia_movimiento';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "guia":$('#guia_movimiento_bodegas').val(),
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1!=0){
                    alert('Guia de Movimiento Cerrada');
                    window.location.href=base_url+"/control_ingresos/listar_movimientos_bodegas";                     
                   }
                   else
                   {
                                     
                  alert('Error al Cerrar la Orden');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
};

$('#cerrar_guia').on("click", function (e) { 
    
     var urlEmp = base_url+'/Servicios/cerrar_guia_ingreso';
               
       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa').val(),
               "bodega":$('#bodega').val(),
               "guia":$('#guia').val(),
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1==1){
                    alert('Guia de Ingreso Cerrada');
                    window.location.href=base_url+"/control_ingresos/listar_ingreso_bodegas";                     
                   }
                   else
                   {
                                     
                  alert('Error al Cerrar la Orden');
                   }

            },
        Error:function(data){
            HoldOn.close();
            alert('Error al realizar la Consulta.');
            }
        });
});

$('#cerrar_guia_egreso_final').on("click", function (e) { 
    
     var urlEmp = base_url+'/Servicios/cerrar_guia_egreso';
     var guia=$('#guia_egreso').val();
       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "empresa":$('#empresa').val(),
               "bodega":$('#bodega').val(),
               "guia":$('#guia_egreso').val(),
               "observaciones":$('#observaciones').val()
               

               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
           
        if(data1==1){
                    alert('Guia de Egreso Cerrada');
                     
                   window.open(base_url+'/Pdfs/generar_orden/'+guia, '_blank');                                
                   window.location.href=base_url+"/control_egresos/listar_egreso_bodegas";                     
                   }
                   else
                   {
                                     
                  alert('Error al Cerrar la Orden');
                   }

            },
        Error:function(data){
            HoldOn.close();
            alert('Error al realizar la Consulta.');
            }
        });
});

function imprimir_guia(guia){
     window.open(base_url+'Pdfs/generar_cotizacion/'+guia, '_blank');
}

function eliminar_registro_ingreso(id){
    var urlEmp = base_url+'/Servicios/eliminar_registro_ingreso';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "id_registro":id,
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
          
        if(data1!='Err'){
                table_ingresos_guia.clear();   
                table_ingresos_guia.draw();                  
                   for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_ingreso(" +data1[x]['id_ingresodet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_ingresos_guia.row.add([
                        data1[x]["cod_barras"],
                        data1[x]["producto"],
                        data1[x]["Estado_producto"],
                       
                        accion
                        ]).draw();
                } 
                                
                   }
                   else
                   {                       
                  alert('Error al eliminar registro');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function eliminar_registro_ingreso_egreso(id){
    var urlEmp = base_url+'/Servicios/eliminar_registro_ingreso_egreso';

       $.ajax({
        type: "POST",
        url: urlEmp,
        data: {  
               "id_registro":id,
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
          
        if(data1!='Err'){
                table_ingresos_guia.clear();   
                table_ingresos_guia.draw();                  
                   for (var x = 0; x < data1.length; x++) {

                    var accion = "<a onclick='eliminar_registro_ingreso_egreso(" +data1[x]['id_egresodet'] + ")'><span class='label label-danger'>Eliminar</span></a>";
                    table_ingresos_guia.row.add([
                        data1[x]["cod_barras"],
                        data1[x]["producto"],
                    
                        data1[x]["precio_venta"],
                        data1[x]["Estado_producto"],                       
                        accion

                        ]).draw();
                } 
                                
                   }
                   else
                   {                       
                  alert('Error al eliminar registro');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function continuar_guia(id){
      var urlEmp = base_url+'/Control_Ingresos/continuar_guia?id_registro='+id;
       window.location.href=urlEmp;            


}

function continuar_guia_movimiento_interno(id){
      var urlEmp = base_url+'/Servicios/continuar_guia_movimiento_interno?id_registro='+id;
       window.location.href=urlEmp;            

}

function actualizar_producto()
    {      
    var url = base_url + 'servicios/actualizar_producto';
    var formData = new FormData(document.getElementById("form_producto_m"));
    
    $.ajax({
        type: "POST",
        cache: false,
       // dataType: "html",
        contentType: false,
        processData: false,
        url: url,
        data: formData,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Espere un momento por favor ..."
            });
        },
        success: function (respuesta) {           
            HoldOn.close();
            alert(respuesta);
            window.location.href=base_url+"/productos/listar_productos";
        },
        error: function (error) {

            HoldOn.close();
            alert("Ocurrió un error, intente en unos momentos");
        }        ,
        dataType: 'text'
    });
    }



function crear_producto_nuevo(id_seleccion)
    {      
    var url = base_url + 'servicios/crear_producto_nuevo';
    if(id_seleccion==1){
        var formData = new FormData(document.getElementById("form_producto_nuevo_directo"));
     }
     if(id_seleccion==0){
        var formData = new FormData(document.getElementById("form_producto_nuevo"));
     }
      if(id_seleccion==2){
        var formData = new FormData(document.getElementById("form_producto_nuevo_cotizador"));
     }
      

    
    
    $.ajax({
        type: "POST",
        cache: false,
       // dataType: "html",
        contentType: false,
        processData: false,
        url: url,
        data: formData,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Espere un momento por favor ..."
            });
        },
        success: function (respuesta) {           
            HoldOn.close();
            if (respuesta!='0'){
            alert('Producto Guardado con Exito');  
                if(id_seleccion==0){
                    window.location.href=base_url+"/productos/listar_productos";        
                }     
                else{
                    var urlEmp = base_url+'Control_Cotizaciones/continuar_cotizacion?id_cotizacion='+id_seleccion;
                    window.location.href=urlEmp; 
                } 
            }else{
            alert(respuesta+'Error al momento de guardar');    
            }
            
            
        },
        error: function (error) {

            HoldOn.close();
            alert("Ocurrió un error, intente en unos momentos");
        }        ,
        dataType: 'text'
    });
    }


function eliminar_empresa(id_empresa){
    
     var url = base_url + 'Empresas/eliminar_empresa';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_empresa":id_empresa,                             
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                  alert('Registro Eliminado Correctamente');
                  window.location.href=base_url+"/Empresas/registro_empresa";

                   }

            },
        Error:function(data){
             HoldOn.close();       
            alert('Error al realizar la Consulta.');
            }
        });
}

function modal_modificar_empresa(id_empresa){
    $('#modificar_empresa').modal('show');
    
       var url = base_url + 'Empresas/obtener_empresa_por_id';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_empresa":id_empresa             
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                      $('#id_empresa_modal').val(data1[0]['id_empresa']);
                      $('#nombre_comercial_1').val(data1[0]['nombre']);
                      $('#contacto_1').val(data1[0]['contacto']);               
                      $('#telefono_1').val(data1[0]['telefono']);
                      $('#correo_1').val(data1[0]['correo']);
                      $('#direccion_1').val(data1[0]['direccion']);
                      $('#ciudad_1').val(data1[0]['ciudad']);
                      $('#detalles_1').val(data1[0]['detalles']);

                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

} 
 
function modificar_empresa_x_id(){
   
     var url = base_url + 'Empresas/modificar_empresa_por_id';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_empresa":$('#id_empresa_modal').val(),
               "nombre_comercial":$('#nombre_comercial_1').val(),               
               "contacto":$('#contacto_1').val(),               
               "telefono":$('#telefono_1').val(),               
               "correo":$('#correo_1').val(),               
               "direccion":$('#direccion_1').val(),               
               "ciudad":$('#ciudad_1').val(),               
               "detalles":$('#detalles_1').val()
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                  alert('Registro Modificado Correctamente');
                  window.location.href=base_url+"/Empresas/registro_empresa";

                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function guardar_registro_empresa(){
    
     var url = base_url + 'servicios/guardar_registro_empresa';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "nombre_comercial":$('#nombre_comercial').val(),               
               "contacto":$('#contacto').val(),               
               "telefono":$('#telefono').val(),               
               "correo":$('#correo').val(),               
               "direccion":$('#direccion').val(),               
               "ciudad":$('#ciudad').val(),               
               "detalles":$('#detalles').val()
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                  alert('Registro Creado Correctamente');
                  window.location.href=base_url+"/Empresas/registro_empresa";

                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function modificar_producto(id_producto){
    $('#exampleModal').modal('show');
    var url = base_url + 'servicios/obtener_producto_por_id';
    $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_producto":id_producto,               
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1!=null){
                   $('#cod_producto_m').val(data1[0]['id_producto']);
                   $('#marca_m').val(data1[0]['marca']);
                   $('#modelo_m').val(data1[0]['modelo']);
                   $('#detalle_m').val(data1[0]['descripcion_producto']);
                   $('#precio_m').val(data1[0]['precio']);
                    $('#costo_minimo_m').val(data1[0]['costo_minimo']);
                     $('#costo_maximo_m').val(data1[0]['costo_maximo']);
                      $('#costo_standar_m').val(data1[0]['costo_standar']);
                   $("#imagen_base_m").attr("src",data1[0]['imagen']);
                   }
                   else
                   {
                                     
                  alert('Error al Obtener Data');
                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function eliminar_bodega(id_bodega){
    
     var url = base_url + 'Bodegas/eliminar_bodega';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_bodega":id_bodega,                             
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                  alert('Registro Eliminado Correctamente');
                  window.location.href=base_url+"/Bodegas/registro_bodega";

                   }

            },
        Error:function(data){
             HoldOn.close();       
            alert('Error al realizar la Consulta.');
            }
        });
}

function modal_modificar_bodega(id_empresa){
    $('#modificar_empresa').modal('show');
    
       var url = base_url + 'Empresas/obtener_empresa_por_id';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_empresa":id_empresa             
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                      $('#id_empresa_modal').val(data1[0]['id_empresa']);
                      $('#nombre_comercial_1').val(data1[0]['nombre']);
                      $('#contacto_1').val(data1[0]['contacto']);               
                      $('#telefono_1').val(data1[0]['telefono']);
                      $('#correo_1').val(data1[0]['correo']);
                      $('#direccion_1').val(data1[0]['direccion']);
                      $('#ciudad_1').val(data1[0]['ciudad']);
                      $('#detalles_1').val(data1[0]['detalles']);

                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });

} 
 
function modificar_bodega_x_id(){
   
     var url = base_url + 'Empresas/modificar_empresa_por_id';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "id_empresa":$('#id_empresa_modal').val(),
               "nombre_comercial":$('#nombre_comercial_1').val(),               
               "contacto":$('#contacto_1').val(),               
               "telefono":$('#telefono_1').val(),               
               "correo":$('#correo_1').val(),               
               "direccion":$('#direccion_1').val(),               
               "ciudad":$('#ciudad_1').val(),               
               "detalles":$('#detalles_1').val()
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);
                  
        
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                  alert('Registro Modificado Correctamente');
                  window.location.href=base_url+"/Empresas/registro_empresa";

                   }

            },
        Error:function(data){
            alert('Error al realizar la Consulta.');
            }
        });
}

function crear_bodega_nueva(){    
     var url = base_url + 'Bodegas/crear_bodega_nueva';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "empresa":$('#empresa_').val(),               
               "nom_bodega":$('#nom_bodega').val(),               
               "telefono":$('#telefono').val(),               
               "correo":$('#correo').val(),               
               "direccion":$('#direccion').val(),               
               "ciudad":$('#ciudad').val(),               
               "detalles":$('#detalles').val()
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);                    
        if(data1==0){
                 alert('Error en transacción')
                   }
                   else
                   {                                     
                  alert('Registro Creado Correctamente');
                  window.location.href=base_url+"/Bodegas/registro_bodega";

                   }

            },
        Error:function(data){
             HoldOn.close();    
            alert('Error al realizar la Consulta.');
            }
        });
}
  
function obtener_inventario_por_criterios(){    
     var url = base_url + 'inventario/obtener_inventario_por_criterios';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "empresa":$('#empresa').val(),               
               "bodega":$('#bodega').val(),                              
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);                    
        if(data1==0){
                 //  alert('Error en Consulta');
                   table_inventario.clear();   
                   table_inventario.draw();       
                   }
                   else
                   {                                     
                    table_inventario.clear();   
                    table_inventario.draw();                  
                   for (var x = 0; x < data1.length; x++) {

                 
                    table_inventario.row.add([
                        data1[x]["empresa"],
                        data1[x]["bodega"],
                        data1[x]["tipo"],                       
                        data1[x]["marca"], 
                        data1[x]["modelo"], 
                        data1[x]["detalle"], 
                        data1[x]["saldo_actual"],                       
                        ]).draw();
                } 

                   }

            },
        Error:function(data){
             HoldOn.close();    
            alert('Error al realizar la Consulta.');
            }
        });
} 



function obtener_transacciones_por_criterios(){    
     var url = base_url + 'transacciones/obtener_transacciones_por_criterios';
       $.ajax({
        type: "POST",
        url: url,
        data: {  
               "empresa":$('#selEmpresa').val(),               
            //   "empresa":$('#empresa').val(),
               "fecha_ini":$('#fecha_ini').val(),
               "fecha_fin":$('#fecha_fin').val(),                              
               }, 
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando datos..."
            });
        },
        success: function (data) {
            HoldOn.close();          
            var data1 = JSON.parse(data);                    
        if(data1==0){
                 //  alert('Error en Consulta');
                   table_transacciones.clear();   
                   table_transacciones.draw();       
                   }
                   else
                   {                                     
                    table_transacciones.clear();   
                    table_transacciones.draw();                  
                   for (var x = 0; x < data1.length; x++) {

                 
                    table_transacciones.row.add([
                      //  data1[x]["empresa"],
                        data1[x]["bodega"],
                        data1[x]["guia"],
                        data1[x]["fecha"],
                        data1[x]["tipo_guia"],
                        data1[x]["cod_barras"],
                        data1[x]["tipo"],                       
                        data1[x]["marca"], 
                        data1[x]["modelo"], 
                        data1[x]["estado"],
                        data1[x]["detalle"], 
                        data1[x]["usuario"],                       
                        ]).draw();
                } 

                   }

            },
        Error:function(data){
             HoldOn.close();    
            alert('Error al realizar la Consulta.');
            }
        });
} 

    

