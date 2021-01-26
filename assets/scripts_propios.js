
//Funciones yaglodvial
var x=$('#example105').DataTable({
    "iDisplayLength": 7,
    dom: 'Bfrtip',
    buttons: [ 'excel', 'pdf', 'print'],
});

var y=$('#example106').DataTable({
    "iDisplayLength": 7,
    dom: 'Bfrtip',
   // buttons: [ 'excel', 'pdf', 'print'],
    buttons: [
        'excel',
        'print',
        {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize: 'LEGAL'
        }
    ]
});

var z=$('#example110').DataTable();



function elimina_ruta_aprobada(id_ruta) {
  

    $.ajax({
        type: "POST",
        url: '/Rutas/elimina_ruta_aprobada',
        data: {
            "id_ruta": id_ruta,
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
            if(data1==true){
                alert ('Reverso Exitoso');
                location.reload('rutas/reverso_rutas_llegada');
            }else 
            {
                alert (' ERR al reversar');  }

        },
        Error:function(data){
            alert('Error al realizar la Consulta.');
        }
    })

}


function reversa_ruta() {
    $('#div_reversa_ruta').show();
  $('#example11').remove();
       $.ajax({
        type: "POST",
        url: '/Rutas/reversa_ruta',
        data: {
            "id_contrato": $('#cbo_contratos_rep7 option:selected').val(),
            "id_asociacion": $('#cbo_asociacion_rep7 option:selected').val(),
            "fecha_ini": $('#fecha_ini_rep7').val(),
            "fecha_fin": $('#fecha_fin_rep7').val(),

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
          // x.clear();
           $('#div_reversa_ruta').append(''+
        ' <table id="example11" class="table table-bordered table-striped">'+
        '<thead>'+
        '   <tr>'+
      
        '       <th>Asociacion</th>'+
        '       <th>Placa </th>'+
        '       <th>Contrato</th>'+
        '       <th>Viajes</th>'+
        '       <th>Cubicaje Unitario </th>'+
        '       <th>Tarifa</th>'+
        '       <th>Fecha Salida</th>'+
        '       <th>Reversar </th>'+
        '   </tr>'+
        '</thead>'+
        '<tbody>'+
        ' ');
        
            for (var i = 0; i < data1.length; i++) {
                
                 $('#example11').append(''+
            '<tr>'+
            
                '   <td>'+ data1[i]['asociacion']+ '</td>'+
                    '   <td>'+ data1[i]['placa']+ '</td>'+
                        '   <td>'+ data1[i]['nombre_contrato']+ '</td>'+
                            '   <td>'+ data1[i]['viajes']+ '</td>'+
                                '   <td>'+ data1[i]['cubicaje_unitario']+ '</td>'+
                                    '   <td>'+ data1[i]['costo_ruta']+ '</td>'+
                                        '   <td>'+ data1[i]['fecha_salida']+ '</td>'+
                                            '   <td><buttton  onclick="elimina_ruta_aprobada('+ data1[i]['idtbl_rutas_salida']+ ')" class="btn btn-danger"> <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </button></td>'+
            '<tr>');
                }
                 $('#example11').append('</tbody></table>');
            
        },
        Error:function(data){
            alert('Error al realizar la Consulta.');
        }
    })

}



function reporte_liquidacion() {
    $('#div_liquidaciones_det').show();

    $.ajax({
        type: "POST",
        url: '/Reportes/reporte_liquidacion',
        data: {
            "semana": $('#cbo_semanas_rep5 option:selected').val(),
            "periodo": $('#cbo_periodo_rep5 option:selected').val(),
            "estado": $('#cbo_estado option:selected').val(),
            "id_asociacion": $('#cbo_asociacion_rep5 option:selected').val(),

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
            var estado='';
         y.clear();
            for (var i = 0; i < data1.length; i++) {
                if(  data1[i]['estado']==1){  estado='PENDIENTE';}
                else { 
                     if(  data1[i]['estado']==2){ estado='PAGADA';}
                    else { estado='-'}
                }
                y.row.add([
                   "Semana 123123",
                    data1[i]['nombre'],
                    data1[i]['apellido'],
                    data1[i]['telefono'],
                    data1[i]['nombre'],
                    data1[i]['apellido'],
                    data1[i]['telefono'],
                    data1[i]['nombre'],
                  'estado',

                ]).draw();
            }

        },
        Error:function(data){
            alert('Error al realizar la Consulta.');
        }
    })

}

function reporte_descuentos() {
    $('#div_reporte_descuentos').show();

    //var table=$('#example105').DataTable();
   //table.destroy();


    $.ajax({
        type: "POST",
        url: '/Reportes/reporte_descuentos',
        data: {
            "id_asociacion": $('#cbo_asociacion_rep4 option:selected').val(),

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
         y.clear();
            for (var i = 0; i < data1.length; i++) {
                y.row.add([
                    data1[i]['fecha'],
                    data1[i]['nombre'],
                    data1[i]['detalle'],
                    data1[i]['monto'],
                    data1[i]['observaciones'],
                    data1[i]['prorrateo_det'],
                    data1[i]['nota'],

                ]).draw();
            }

        },
        Error:function(data){
            alert('Error al realizar la Consulta.');
        }
    })

}

function reporte_cantera_obras() {
    $('#div_produccion_canteras_contrato').show();

 if(  $("#sin_fecha").is(':checked')) {

      var float=0;
  }else{
      var float=1;
  }


    $.ajax({
        type: "POST",
        url: '/Reportes/reporte_cantera_obras',
        data: {
            "id_cantera": $('#cbo_canteras_rep4 option:selected').val(),
            "id_asociacion": $('#cbo_asociacion_rep4 option:selected').val(),
            "id_contratos": $('#cbo_contratos_rep4 option:selected').val(),
            "float": float,
            "fecha_ini": $('#fecha_ini_rep4').val(),
            "fecha_fin": $('#fecha_fin_rep4').val(),
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

            y.clear();
            
            for (var i = 0; i < data1.length; i++) {
                y.row.add([
                    data1[i]['Cantera'],
                    data1[i]['Asociacion'],
                    data1[i]['Contrato'],
                    data1[i]['placa'],
                    data1[i]['Material'],
                    data1[i]['cubicaje_unitario'],
                    data1[i]['viajes'],
                    data1[i]['costo_ruta'],
                    data1[i]['cubicaje_total'],
                    data1[i]['costo_total'],
                    data1[i]['fecha_viaje'],
                    data1[i]['liquidacion'],
                    
                ]).draw();
            }

        },
        Error:function(data){
            alert('Error al realizar la Actualización.');
        }
    })

}


function reporte_canteras_obras() {
    $('#div_reporte_canteras_obras').show();

  if(  $("#sin_fecha").is(':checked')) {

      var float=0;
  }else{
      var float=1;
  }

    $.ajax({
        type: "POST",
        url: '/Reportes/reporte_canteras_obras',
        data: {
            "id_cantera": $('#cbo_cantera_rep8 option:selected').val(),
            "float": float,
            "fecha_ini": $('#fecha_ini_rep8').val(),
            "fecha_fin": $('#fecha_fin_rep8').val(),
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

            x.clear();

            for (var i = 0; i < data1.length; i++) {
                x.row.add([
                    data1[i]['Cantera'],
                    data1[i]['Contrato'],
                    data1[i]['detalle'],
                    data1[i]['cubicaje_total'],
                    data1[i]['costo_total'],
                ]).draw();
            }

        },
        Error:function(data){
            alert('Error al realizar la Actualización.');
        }
    })

}

function reporte_produccion_canteras_det() {
    $('#div_produccion_canteras_det').show();

if(  $("#sin_fecha").is(':checked')) {

      var float=0;
  }else{
      var float=1;
  }
  
    $.ajax({
        type: "POST",
        url: '/Reportes/reporte_produccion_canteras_det',
        data: {
            "id_asociacion": $('#cbo_asociacion_rep2 option:selected').val(),
            "id_contratos": $('#cbo_contratos_rep2 option:selected').val(),
            "float": float,
            "fecha_ini": $('#fecha_ini_rep2').val(),
            "fecha_fin": $('#fecha_fin_rep2').val(),
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

            x.clear();
            
            for (var i = 0; i < data1.length; i++) {
                x.row.add([
                    data1[i]['asociacion'],
                    data1[i]['nombre_contrato'],
                    data1[i]['placa'],
                    data1[i]['viajes'],
                    data1[i]['detalle'],
                    data1[i]['cubicaje_total'],
                    data1[i]['fecha_viaje'],
                    
                ]).draw();
            }

        },
        Error:function(data){
            alert('Error al realizar la Actualización.');
        }
    })

}

function reporte_produccion_canteras() {
    $('#div_produccion_canteras').show();
if(  $("#sin_fecha").is(':checked')) {

      var float=0;
  }else{
      var float=1;
  }
    $.ajax({
        type: "POST",
        url: '/Reportes/reporte_produccion_canteras',
        data: {
            "id_asociacion": $('#cbo_asociacion_rep1 option:selected').val(),
            "float":float,
            "fecha_ini": $('#fecha_ini_rep1').val(),
            "fecha_fin": $('#fecha_fin_rep1').val(),
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
            
            x.clear();
            
            for (var i = 0; i < data1.length; i++) {
                x.row.add([
                    data1[i]['asociacion'],
                    data1[i]['nombre_contrato'],
                    data1[i]['material'],
                    data1[i]['viajes'],
                    data1[i]['ultimo_registro'],
                    data1[i]['cubicaje_total'],
                ]).draw();
            }

        },
        Error:function(data){
            alert('Error al realizar la Actualización.');
        }
    })

}

function update_masivo_contratos(id_contrato) {
  //  alert(id_contrato);
    $.ajax({
        type: "POST",
        url: '/Contratos/update_masivo_contratos',
        data: {
            "id_contrato": id_contrato,
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
            if (data1==true){ alert ('Actualización Masiva Exitosa !');}else {alert('Error en la Actualización');}
            console.log(data1);

        },
        Error:function(data){
            alert('Error al realizar la Actualización.');
        }
    })

}

function modificar_tarifario(){
    var arreglo_valores= new Array();
    var productos=  $('#cant_productos').val() ;
    var x=0;
    for(var i=0;i<= productos-1 ;i++){
        if ($('#data_'+i+'').val() > 0 ){

            arreglo_valores[x]=[$('#data_aso_'+i+'').val(),$('#data_cont_'+i+'').val(),$('#data_mat_'+i+'').val(),$('#data_'+i+'').val(),$('#data_can_'+i+'').val()];
            console.log(arreglo_valores[x]);
            x=x+1;
                                }
        }
    $.ajax({
        type: "POST",
        url: '/Transportistas/guardar_nuevas_tarifas_individuales',
        data: {
            "arreglo_valores": arreglo_valores,
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
            console.log(data1);

        },
        Error:function(data){
            alert('Error al realizar la transacción.');
        }
    })

}
function modifica_tarifario_individual(indice){
   // alert($('#cbo_canteras_mod_'+indice+' option:selected').val());

   if ($('#cbo_canteras_mod_'+indice+' option:selected').val()==0){ alert('Seleccione la Cantera'); return false;}
   // alert($('#idtbl_asociacion').val());

    //alert($('#id_contrato_mod_'+indice+' ').val());
    $('#modal-mensajes-99').modal('show');
    llenar_div_nuevos_costos(indice);
}
function llenar_div_nuevos_costos(indice) {
    $('#div_nuevos_costos').empty();
    $('#div_nuevos_costos').append('<center><h4>Ingrese nueva Tarifa .</h4></center><hr>');

    $.ajax({
        type: "POST",
        url: '/Transportistas/cargar_tarifario_mod',
        data: {
            "id_asociacion": $('#idtbl_asociacion').val(),
            "id_cantera": $('#cbo_canteras_mod_'+indice+' option:selected').val(),
            "id_contrato":$('#id_contrato_mod_'+indice+' ').val(),
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
            console.log(data1);
            $('#div_nuevos_costos').append('<input type="hidden" id="cant_productos" value="'+data1.length+'">');
            for(var i=0; i<=data1.length-1 ;i++ ){
                $('#div_nuevos_costos').append(''+
                    '<div class="row">'+
                    '     <div class="col-md-3"></div>'+
                    '     <div class="col-md-3"><label>'+ data1[i]["detalle"] +' : </label> </div>  '+
                    '       <div class="col-md-4"><div class="input-group">'+
                    '           <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>'+
                    ' <input type="number" class="form-control" id="data_'+i+'"  value="'+ data1[i]["valor"] +'" required'+
                    '     placeholder="$ 0.50">'+
                    ' <input type="hidden" class="form-control" id="data_aso_'+i+'"  value="'+ data1[i]["id_asociacion"] +'">'+
                    ' <input type="hidden" class="form-control" id="data_cont_'+i+'"  value="'+ data1[i]["id_contrato"] +'">'+
                    ' <input type="hidden" class="form-control" id="data_mat_'+i+'"  value="'+ data1[i]["id_material"] +'">'+
                    ' <input type="hidden" class="form-control" id="data_can_'+i+'"  value="'+ data1[i]["id_cantera"] +'">'+
                    '   </div></div>'+
                    ' </div>   <br> ');
            }


        },
        Error:function(data){
            alert('Error al realizar la transacción.');
        }
    })

}

function eliminar_ruta(id_ruta){
    $.ajax({
        type: "POST",
        url: '/Rutas/eliminar_ruta',
        data: {
            "id_ruta": id_ruta,
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
            //  alert(data1);
            if (data1 == true){

                alert('Hoja de ruta eliminada con exito.');
                location.reload('rutas/registro_control_llegada');

            }else {alert ('Registros NO se pudo eliminar');};
            console.log(data1);

        },
        Error:function(data){
            alert('Error al realizar la transacción.');
        }
    })
}

function reversar_pago_btt(id_conciliacion){
    $.ajax({
        type: "POST",
        url: '/Liquidaciones/reversar_pago_btt',
        data: {

            "id_conciliacion": id_conciliacion,

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
          //  alert(data1);
            if (data1 == 2){

                alert('Reverso de liquidación realizada');
                location.reload('Liquidaciones/confirmar_pago');

            }else {alert ('Registros NO se pudo reversar');};
            console.log(data1);

        },
        Error:function(data){
            alert('Error al realizar la transacción.');
        }
    })
}

function levanta_modal_queche(id_conciliacion) {
    $('#modal-mensajes_7').modal('show');
    $('#id_conciliacion_oculto').val(id_conciliacion);
}

function registrar_factura_modal(id_conciliacion) {
    $('#modal-mensajes_8').modal('show');
    $('#id_conciliacion_').val(id_conciliacion);
}

function registro_factura(){

  $.ajax({
        type: "POST",
        url: '/Liquidaciones/registro_factura',
        data: {
             "id_conciliacion":  $('#id_conciliacion_').val(),
            "no_factura":  $('#no_factura').val(),
          
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
            if (data1 = true){
                alert('Factura  Registrada');
               location.reload('Liquidaciones/revisar_liquidacion');

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
           
        }
    })

 }
function confirmar_pago_btt(){

  $.ajax({
        type: "POST",
        url: '/Liquidaciones/confirmar_pago_btt',
        data: {
             "id_conciliacion":  $('#id_conciliacion_oculto').val(),
            "no_cheque":  $('#no_cheque').val(),
          
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
            if (data1 = true){
                alert('Pago Confirmado');
               location.reload('Liquidaciones/confirmar_pago');

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
           
        }
    })

 }


 function guardar_nuevo_vehiculo(){

if($('#placa').val()==''){alert('Ingrese la Placa'); return false;}
if($('#cbo_asociaciones option:selected').val()=='0'){alert('Seleccione la Asociacion a Vincular'); return false;}

     $.ajax({
        type: "POST",
        url: '/Transportistas/guardar_nuevo_vehiculo',
        data: {
            
            "id_asociacion":  $('#cbo_asociaciones option:selected').val(),
            "placa":  $('#placa').val(),
            "largo_b":  $('#largo_b').val(), 
            "alto_b":  $('#alto_b').val(),
            "ancho_b":  $('#ancho_b').val(),
            "largo_t":  $('#largo_t').val(), 
            "alto_t":  $('#alto_t').val(),
            "ancho_t":  $('#ancho_t').val(),
            "largo_g":  $('#largo_g').val(), 
            "alto_g":  $('#alto_g').val(),
            "ancho_g":  $('#ancho_g').val(),
            "sintablon_manual": $('#sintablon_manual').val(),
            "contablon_manual": $('#contablon_manual').val(),
           
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
            if (data1 = true){
                alert('Vehículo Registrado Correctamente');
               location.reload('Transportistas/agregar_vehiculo');

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
           
        }
    })
}

function verifica_placa_descuento(flag)
{
  if ( $('#placa').val() == '') {alert('Ingrese Placa'); return false;};


  $.ajax({
        type: "POST",
        url: '/Rutas/verifica_placa',
        data: {
               "placa":  $('#placa').val(), 
                           },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Verificando Placas..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            if(data1.length >=1){ 
                  if(flag==1){  guardar_descuentos(); }
                   if(flag==2){  guardar_prorrateo(); }
         }
            else{
                alert('Placa No Existe');
             return false;
               
        }
        },
        Error:function(data){
            alert('Error al verificar placa');
        }

    })

}

function guardar_cantera(){

if ($('#cantera').val()==''){ alert('Ingrese nombre de la cantera'); return false;}

$.ajax({
        type: "POST",
        url: '/Canteras/guardar_cantera',
        data: { 
          "cantera":$('#cantera').val(),
          "contacto":$('#contacto').val(),
          "tel_contacto":$('#tel_contacto').val(),
          "mail_contacto":$('#mail_contacto').val(),
          "direccion":$('#direccion').val(),
          "observaciones":$('#observaciones').val(),
                        
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            console.log(data1);
            if (data1==true){ 
                            alert('Actualización Correcta');
                           location.reload('Canteras/registrar_cantera');
                            }
           else{ ('Error al Registrar Cantera');}
        },
        Error:function(data){
            alert('Error ');
        }

    })
  
}

function transferir(id_vehiculo,id_asociacion){

  if ( $("#cbo_asociaciones_"+id_asociacion+" option:selected").val() == 0 ) {
    alert('Selecciones Asociacion de destino'); 
    return false ;
  }

 $.ajax({
        type: "POST",
        url: '/Transportistas/transferir',
        data: { 
         "id_vehiculo":id_vehiculo,
         "id_asociacion":  $("#cbo_asociaciones_"+id_asociacion+" option:selected").val() , 
                        
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            console.log(data1);
            if (data1==true){ 
                            alert('Actualización Correcta');
                           location.reload('Transportistas/transferir_vehiculo');
                            }
           else{ ('Error al Transferir');}
        },
        Error:function(data){
            alert('Error ');
        }

    })
  
}

function registrar_conciliacion(){


var arreglo_movimientos1= new Array();
var arreglo_descuentos1= new Array();

var i1=0;
var a1=0;

  var oTable11 = $('#example21').dataTable();
  var nNodes11 = oTable11.fnGetNodes( );
 
$('input[name=chkrutas]:checked',nNodes11).each(function(index,valor){
    arreglo_movimientos1[i1]=[$(valor).val()];
    i1=i1+1;
 });

 var oTable21 = $('#example20').dataTable();
  var nNodes21 = oTable21.fnGetNodes( );
 
$('input[name=chkdes]:checked',nNodes21).each(function(index,valor){
    arreglo_descuentos1[a1]=[$(valor).val()];
    a1=a1+1;
 });

            console.log(arreglo_movimientos1); 
            console.log(arreglo_descuentos1); 
   $.ajax({
        type: "POST",
        url: '/Rutas/conciliacion_final',
        data: {  
          "id_asociacion":$('#cbo_asociacion option:selected').val(), 
          "arreglo_movimientos1":arreglo_movimientos1, 
          "arreglo_descuentos1":arreglo_descuentos1,
          "periodo": $('#cbo_periodo option:selected').val(),
          "semana":$('#cbo_semanas option:selected').val(),
          "total_conciliar":$('#total_conciliar_modal').val(),
          "total_descontar":$('#total_descontar_modal').val(),
          "retencion":$('#retencion').val(),
          "gran_total":$('#gran_total').val(),
                      
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {

             HoldOn.close();
           var data1 = JSON.parse(data);
          //  alert(data1);
            if (data1==1){
                alert('Conciliacion Registrada');
                console.log(data1);
                location.reload('Rutas/conciliar');
            }else { alert('Error');}

        
        },
        Error:function(data){
            alert('Error ');
        }

    })
}

function cerrar_modal(){
$('#example13').remove();
  $('#modal-mensajes_4').hide();
  $("#modal-mensajes_4").modal('hide');//ocultamos el modal
  $('body').removeClass('modal-open');//eliminamos la clase del body para poder hacer scroll
  $('.modal-backdrop').remove();//eliminamos el backdrop del modal
 //location.reload('Rutas/Conciliar');
}

function printDiv(nombreDiv) {
  
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}

function ver_asociacion(id_asociacion){

$('#div_asociacion').show();
$('#div_seleccion_asociacion').hide();

 $.ajax({
        type: "POST",
        url: '/Transportistas/obtener_asociacion_modificar',
        data: { 
         "id_asociacion":id_asociacion, 
                        
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            console.log(data1);
            $('#nombre').val(data1[0]['nombre']);
            $('#representante').val(data1[0]['representante']);
            $('#ruc').val(data1[0]['ruc']);
            $('#telefono').val(data1[0]['telefono']);
            $('#correo').val(data1[0]['correo']);
            $('#observaciones').val(data1[0]['observaciones']);
            $('#id_asociacion_oculto').val(id_asociacion);
        },
        Error:function(data){
            alert('Error ');
        }

    })
}

function  ver_tarifas(id_vehiculo){
   $('#div_vehiculo').show();
  $('#div_placas').hide();

  $.ajax({
        type: "POST",
        url: '/Transportistas/obtener_cubicaje_placa',
        data: { 
         "id_vehiculo":id_vehiculo, 
                        
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            console.log(data1);
            $('#placa').val(data1[0]['placa']);
            $('#largo_b').val(data1[0]['largo_b']);
            $('#ancho_b').val(data1[0]['ancho_b']);
            $('#alto_b').val(data1[0]['alto_b']);
            $('#largo_t').val(data1[0]['largo_t']);
            $('#ancho_t').val(data1[0]['ancho_t']);
            $('#alto_t').val(data1[0]['alto_t']);
            $('#largo_g').val(data1[0]['largo_g']);
            $('#ancho_g').val(data1[0]['ancho_g']);
            $('#alto_g').val(data1[0]['alto_g']);
            $('#contablon_manual').val(data1[0]['cubicaje_tablon']);
            $('#sintablon_manual').val(data1[0]['cubicaje_sin']);
                   
        },
        Error:function(data){
            alert('Error ');
        }

    })


}

$('#example101').DataTable({
             "iDisplayLength": 7,
            "aLengthMenu": [[7, 10, -1], [7, 10, "All"]],
           dom: 'Bfrtip',
           buttons: [ 'excel', 'pdf', 'print'],
});
$('#example104').DataTable({
             "iDisplayLength": 7,
            "aLengthMenu": [[7, 10, -1], [7, 10, "All"]],
           dom: 'Bfrtip',
           buttons: [ 'excel', 'pdf', 'print'],
});

function vista_conciliacion(){

  var arreglo_movimientos= new Array();
  var arreglo_descuentos= new Array();

var i=0;
var a=0;

  var oTable1 = $('#example21').dataTable();
  var nNodes1 = oTable1.fnGetNodes( );
 
$('input[name=chkrutas]:checked',nNodes1).each(function(index,valor){
    arreglo_movimientos[i]=[$(valor).val()];
    i=i+1;
 });

 var oTable2 = $('#example20').dataTable();
  var nNodes2 = oTable2.fnGetNodes( );
 
$('input[name=chkdes]:checked',nNodes2).each(function(index,valor){
    arreglo_descuentos[a]=[$(valor).val()];
    a=a+1;
 });

            console.log(arreglo_movimientos); 
            console.log(arreglo_descuentos); 

$('#modal-mensajes_4').modal('show');
//$('#div_pagar').hide();
$('#valor_retencion').val('');
$('#example10').remove();

$.ajax({
        type: "POST",
        url: '/Rutas/conciliacion_movimientos',
        data: { 
                "arreglo_movimientos" :arreglo_movimientos,
              },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data = JSON.parse(data);
            console.log(data);
          
            $('#example101').remove();
            $('#div_conciliar').append(''+
                ' <table id="example101" class="table table-bordered table-striped" >'+
                '<thead>'+
                '   <tr>'+
                '       <th>Placa</th>'+
                '       <th>Fecha</th>'+
                '       <th>Destino </th>'+
                '       <th>Viajes </th>'+
                '       <th>Pago P/Obra </th>'+
                '       <th>Cubicaje  </th>'+
                '       <th>Total M3 </th>'+
                '       <th>Costo a Pagar </th>'+
                '   </tr>'+
                '</thead>'+
                '<tbody>');

 
 var total_conciliar=0;
  for (var i = 0; i < data.length; i++) {
   total_conciliar= total_conciliar + eval(data[i]['costo_total']);
                   $('#example101').append(''+
                '<tr>'+
                '<td><label>'+data[i]['placa']+'</label></td>'+
                '<td><label>'+data[i]['fecha_viaje']+'</label></td>'+
                '<td><center>'+data[i]['nombre_contrato']+'</center></td>'+
                '<td><center>'+data[i]['viajes']+'</center></td>'+
                '<td><center>'+data[i]['costo_ruta']+'</center></td>'+
                '<td><center>'+data[i]['cubicaje_unitario']+'</center></td>'+
                '<td><center>'+data[i]['cubicaje_total']+'</center></td>'+
                '<td><center>$ '+data[i]['costo_total']+'</center></td>'+
                '</tr>');
  }
             
              $('#example101').append(''+
                 '<tr>'+
                    '<td colspan="7"><label>TOTAL</label></td>'+
                    '<td><input type="text" class="form-control" style="text-align:center;" id="total_conciliar_modal" disabled="disabled" value="'+total_conciliar.toFixed(2)+'"></td>'+
                 '</tr>');


              $('#example101').append('</tbody></table>');
            
        },
        Error:function(data){
            alert('Error ');
        }

    })

$.ajax({
        type: "POST",
        url: '/Rutas/conciliacion_descuentos',
        data: { 
                "arreglo_descuentos" :arreglo_descuentos,
              },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Revisando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data2 = JSON.parse(data);
            console.log(data2);
          
            $('#example10').remove();
        
$('#div_descuentos2').append(''+
                ' <table id="example10" class="table table-bordered table-striped" >'+
                '<thead>'+
                '   <tr>'+
          //      '       <th>Placa</th>'+
                '       <th>Fecha</th>'+
                '       <th>Destino </th>'+
                '       <th>Tipo </th>'+
                '       <th>Observaciones </th>'+
                '       <th>Observaciones Prorrateo </th>'+
                '       <th>Costo a Descontar </th>'+
                '   </tr>'+
                '</thead>'+
                '<tbody>'+
                ' ');
var total_descontar=0;
for (var i = 0; i < data2.length; i++) {
  total_descontar= total_descontar + eval(data2[i]['monto']);
  $('#example10').append(''+
                '<tr>'+
              //  '   <td><label >'+data2[i]['placa']+'</label></td>'+
                '   <td><label >'+data2[i]['fecha']+'</label></td>'+
                '   <td><center>'+data2[i]['nombre_contrato']+'</center></td>'+
                '   <td><center>'+data2[i]['detalle']+'</center></td>'+
                '   <td class="col-sm-3"> <center>'+data2[i]['observaciones']+'</center></td>'+
                '   <td class="col-sm-3"><center>'+data2[i]['prorrateo_det']+'</center></td>'+
                '   <td><center>$ '+data2[i]['monto']+' </center></td>'+
                 '</tr>');
}     
            $('#example10').append(''+
                 '<tr>'+
                    '<td colspan="5"><label>TOTAL</label></td>'+
                    '<td><input type="text" style="text-align:center;" class="form-control" id="total_descontar_modal" disabled="disabled" value="'+total_descontar.toFixed(2)+'"></td>'+
                 '</tr>');
            $('#example10').append('</tbody></table>');    
          
        },
        Error:function(data){
            alert('Error ');
        }

    })
}

function calcula_final_apagar(){

$('#example13').remove();
var total_conciliar_modal = $('#total_conciliar_modal').val();
var total_descontar_modal =$('#total_descontar_modal').val();
if (total_descontar_modal == null ){
  total_descontar_modal=0;
}
    
    $('#retencion').val('');
    $('#gran_total').val('');

var retencion_ingresada=$('#valor_retencion').val();
var retencion = (total_conciliar_modal*retencion_ingresada)/100;
var gran_total = total_conciliar_modal  -  total_descontar_modal - retencion;
$('#div_apagar').append(''+
                ' <table id="example13" class="table table-bordered table-striped" >'+
                '<thead>'+
                '   <tr>'+
                '       <th>Detalle</th>'+
                '       <th>Valor</th>'+
              
                '   </tr>'+
                '</thead>'+
                '<tbody>'+
                ' ');

                $('#example13').append(''+
                '<tr>'+
                '   <td><label >VALORES A CONCILIAR</label></td>'+
                '   <td><center><input type="text" id="total_conciliar_modal" disabled="disabled" style="text-align:center"  class="form-control" value="'+total_conciliar_modal+'"> </center></td>'+
               '<tr>'+
                 '<tr>'+
                '   <td><label >VALORES A DESCONTAR</label></td>'+
                '   <td><center><input type="text" id="total_descontar_modal" disabled="disabled" style="text-align:center"  class="form-control" value="'+total_descontar_modal+'"> </center></td>'+               
               '<tr>'+
                '<tr>'+
                '   <td><label >RETENCION '+ retencion_ingresada +' %</label></td>'+
                '   <td><center><input type="text" id="retencion"  style="text-align:center" disabled="disabled" class="form-control" value="'+retencion.toFixed(2)+'"> </center></td>'+               
                '<tr>'+
                '<tr><td><strong>TOTAL A CANCELAR</strong></td>'+
                '   <td><center><input type="text" id="gran_total" style="text-align:center"  disabled="disabled" class="form-control" value="'+gran_total.toFixed(2)+'"> </center></td>'+               
                '');
      
                 $('#example13').append('</tbody></table>');


}



function registro_maestro(){
  var id_ruta=$('#oculto_id_ruta').val();
  var viajes=$('#viajes').val();

  var cantidad_viajes_receptados=$('#cantidad_viajes_receptados').val();
  var cantidad_viajes_parciales=$('#cantidad_viajes_parciales').val();
  var cantidad_viajes_perdidos=$('#cantidad_viajes_perdidos').val();
  var total=parseFloat(cantidad_viajes_receptados) + parseFloat(cantidad_viajes_perdidos) + parseFloat(cantidad_viajes_parciales );
    
   if (total!=viajes) {
    alert('La cantidad de viajes reportados no concuerdax.');
    return false;
   }
  
  if (cantidad_viajes_perdidos>0)
  {
    var arreglo_perdidas= new Array();
    var observaciones= (cantidad_viajes_perdidos+' Viaje(s) perdido, con un cubicaje total de: '+ $('#cubicaje_perdido_por_viaje').val() +' - Guia Nro: ' + $('#guia').val() + ' - Origen: '+ $('#origen').val() +' - Destino: '+ $('#destino').val() +' - Carga Transportada: '+ $('#material').val()  );
    arreglo_perdidas=[ $('#placa').val(),6,$('#costo_perdido').val(),$('#id_origen').val(),$('#id_destino').val(),observaciones,id_ruta];
    console.log(arreglo_perdidas);
  }

  if (cantidad_viajes_parciales>0)
  {  var x=0;
    var arreglo_parciales_des= new Array();
    var arreglo_parciales_pagar= new Array();
    for(var i=1;i<=cantidad_viajes_parciales;i++){
    var observaciones= ('1 Viaje parcial, con un cubicaje perdido de: '+ $('#p_'+i+'').val() +' - Guia Nro: ' + $('#guia').val() + ' - Origen: '+ $('#origen').val() +' - Destino: '+ $('#destino').val() +' - Carga Transportada: '+ $('#material').val()  );
    arreglo_parciales_des[x]=[ $('#placa').val(),7,$('#d_'+i+'').val(),$('#id_origen').val(),$('#id_destino').val(),observaciones,id_ruta ];
  
    arreglo_parciales_pagar[x]=[ id_ruta,$('#r_'+i+'').val(),$('#pa_'+i+'').val() ];    
   console.log(arreglo_parciales_des[x]);
    //console.log(arreglo_parciales_pagar[x]);
    x=x+1;
        }    

  }

 if (cantidad_viajes_receptados>0)
  {
    var arreglo_receptados= new Array();
    arreglo_receptados=[ id_ruta,cantidad_viajes_receptados,$('#cubicaje_receptado_por_viaje').val(),$('#costo_facturar').val()];
    console.log(arreglo_receptados);
  }
  

   $.ajax({
        type: "POST",
        url: '/Rutas/guardar_ruta_llegada',
        data: { 
         "arreglo_receptados":arreglo_receptados, 
         "arreglo_parciales_pagar":arreglo_parciales_pagar, 
         "arreglo_parciales_des":arreglo_parciales_des, 
         "arreglo_perdidas":arreglo_perdidas,
         "id_ruta":id_ruta,
                            
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           console.log(data1);
           location.reload('Rutas/registro_control_llegada');
         
        },
        Error:function(data){
            alert('Error ');
        }

    })

}


function guardar_prorrateo(){
  // verifica_placa_descuento();

cant_prorrateo=$("#dividendos").val();
var  arreglo_prorrateo= new Array();
var x=0;
for (var i = 1; i <= cant_prorrateo; i++) {
     if($('#pro_'+i).val()==''){alert('Ingrese Valores a Descontar');return false;}
     arreglo_prorrateo[x]=[$("#cbo_asociacion option:selected").val(),$('#fecha').val(),$('#cbo_descuento option:selected').val(),
     $('#monto').val(),$('#cbo_canteras option:selected').val(),$('#cbo_destino option:selected').val(),
     $('#observaciones').val(), $('#l_'+i).text() , $('#pro_'+i).val(),$('#nota_'+i).val()  ];

     x=x+1;
  }console.log(arreglo_prorrateo);
  
  $.ajax({
        type: "POST",
        url: '/Descuentos/guardar_prorrateo',
        data: {  "arreglo_prorrateo":arreglo_prorrateo, 
                            
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           console.log(data1);
           location.reload('Descuentos/registrar_descuento');
         
        },
        Error:function(data){
            alert('Error ');
        }

    })
}



function buscar_conciliacion(){
      $('#div_descuentos').hide();
      $('#oculto_id_asociacion').val($("#cbo_asociacion option:selected").val());
//$('#example10').remove();
$.ajax({
        type: "POST",
        url: '/Rutas/buscar_conciliacion',
        data: {  
            "asociacion":$("#cbo_asociacion option:selected").text(), 
                       
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Calculando Costos..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
                
          $('#div_rutas_aprobadas').show();
            $('#example21').dataTable().fnClearTable();
 
                    var tabRx = $("#example21").DataTable();
                     for (var i = 0; i < data1.length; i++) {
                                    tabRx.row.add([
                                        data1[i]['placa'],
                                        data1[i]['guia'],
                                        data1[i]['nombre_contrato'],
                                        data1[i]['viajes'],
                                        data1[i]['fecha_viaje'],
                                        data1[i]['cubicaje_total'],
                                        data1[i]['costo_total'],
                                         "<a><input   name='chkrutas' class='chkrutas' type='checkbox' id='"+data1[i]['placa']+"'  value='"+data1[i]['id_movimientos']+"'>  </a>"
                                     ]).draw();
                                }
      },
        Error:function(data){
            alert('Error ');
        }

    })

}


function buscar_descuentos(){
  
 /* var arreglo_placas= new Array();

  var i=0;

  var oTable = $('#example21').dataTable();
  var nNodes = oTable.fnGetNodes( );
 
$('input[name=chkrutas]:checked',nNodes).each(function(index,valor){
    arreglo_placas[i]=[$(valor).attr("id")];
    i=i+1;
});


            console.log(arreglo_placas); */
           
$.ajax({
        type: "POST",
        url: '/Rutas/obten_descuentos',
        data: { 
              //  "arreglo_placas" :arreglo_placas ,
                  "arreglo_placas" :$('#oculto_id_asociacion').val(),
              },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            console.log(data1);
             $('#div_descuentos').show();
            $('#example20').dataTable().fnClearTable();
 
                    var tabR = $("#example20").DataTable();
                     for (var i = 0; i < data1.length; i++) {
                                    tabR.row.add([
                                      //  data1[i]['placa'],
                                        data1[i]['detalle'],
                                        data1[i]['monto'],
                                        data1[i]['fecha'],
                                        data1[i]['observaciones'],
                                        data1[i]['prorrateo_det'],
                                        data1[i]['nota'],
                                        "<a><input type='checkbox'  name='chkdes' class='chkdes'  value='"+data1[i]['idtbl_descuentos']+"'>  </a>"
                                     ]).draw();
                                }
         
        },
        Error:function(data){
            alert('Error ');
        }

    })


}

function calcula_descuento(id){
    var tarifa_fijada=$('#tarifa_fijada').val();
    var cubicaje_viaje=$('#cubicaje_unitario').val();
    var cubicaje_recibido=$('#r_'+id).val();
    var cubicaje_perdido=cubicaje_viaje-cubicaje_recibido;
    $('#p_'+id).val(cubicaje_perdido.toFixed(2));
    var pagar=tarifa_fijada*cubicaje_recibido;
    $('#pa_'+id).val(pagar.toFixed(2));
    var descontar= tarifa_fijada*cubicaje_perdido;
    $('#d_'+id).val(descontar.toFixed(2));

}

function det_rut_parcial(){
    var parciales=  $('#cantidad_viajes_parciales').val();
    var cub_esperado= $('#cubicaje_unitario').val();
    var cost_ruta= $('#costo_unitario').val();
    var cost_cubicaje = $('#oculto_valor_cubicaje').val();
    $('#example10').remove();
    $('#row_tarifa').remove();
    $('#tarifa_fijada').remove();

        $('#div_parciales').append(''+
                '<div class="row" id="row_tarifa">'+
                        '<div class="col-sm-5"><label >Tarifa Fijada :</label></div>'+
                        '<div class="col-sm-4"><input  type="number" disabled="disabled" id="tarifa_fijada" value="'+cost_cubicaje+'"></div>'+
                '</div>'+
                 '<table id="example10" class="table table-bordered table-striped">'+
                '<thead>'+
                '   <tr>'+
               '       <th>Esperado</th>'+
                '       <th>Recibido</th>'+
                '       <th>Perdido</th>'+
                  '     <th> </th>'+
                '       <th>Pagar </th>'+
                '       <th>Descontar </th>'+
                '   </tr>'+
                '</thead>'+
                '<tbody>'+
                ' ');

 for(var i=1; i<= parciales;i++){
                 $('#example10').append(''+
                '<tr>'+
               '   <td><center>'+cub_esperado+' </center></td>'+
                '   <td><center><input  id="r_'+i+'" class="form-control" type="text" id=""> </center></td>'+
                '   <td><center><input  id="p_'+i+'" class="form-control" disabled="disabled" type="text" id=""> </center></td>'+
                '   <td><center><button type="button" onclick="calcula_descuento('+i+')" class="btn btn-success"> <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button></center></td>'+
                '   <td><center><input  id="pa_'+i+'" class="form-control" type="text" id="">  </center></td>'+
                '   <td><center><input  id="d_'+i+'" class="form-control" type="text" id="">  </center></td>'+
                '<tr>');
            }
                 $('#example10').append('</tbody></table>');
    
}

$("#cantidad_viajes_receptados").keyup(function () {
        var value = $(this).val();
        var cubicaje_unitario=$('#cubicaje_unitario').val();
        var cubicaje= (value *cubicaje_unitario);
        
        var cost_unitario=$('#costo_unitario').val();
        var costo= (cost_unitario*value);
        $("#cubicaje_receptado_por_viaje").val(cubicaje.toFixed(2));
        $("#costo_facturar").val(costo.toFixed(2));
    });


$("#cantidad_viajes_perdidos").keyup(function () {
        var value = $(this).val();
        var cubicaje_unitario=$('#cubicaje_unitario').val();
        var cost_unitario=$('#costo_unitario').val();
       
       var material = $('#material').val();
       var origen = $('#origen').val();


  switch(origen){

    case "Cantera Santa Barbara":
      switch(material) {
               case 'Material azul':
                  var costo= (cubicaje_unitario*3.75);
                break;
              case 'Piedra Bola':
                  var costo= (cubicaje_unitario*3.75);
                break;
              default:
                  var costo= (cubicaje_unitario*1.5);
                        }
        break;
    case "Cantera Taura":
      switch(material) {
               case 'Material azul':
                  var costo= (cubicaje_unitario*3.75);
                break;
              case 'Piedra Bola':
                  var costo= (cubicaje_unitario*3.75);
                break;
              default:
                  var costo= (cubicaje_unitario*2);
                        }
        break;
                }       
  /*Costos de Produccion
  Cantera Taura 
-----------------
  Cascajo,arena,arcilla,Piedra 3/4 , tierra vegetal  $ 2
  Piedra Azul o Bola     $ 3,75

  Catera Santa Barbara
---------------------
  Cascajo,arena,arcilla,Piedra 3/4 , tierra vegetal    $1.5
  Piedra Azul o Bola     $ 3,75

  */
        var cubicaje= (value *cubicaje_unitario);
        $("#cubicaje_perdido_por_viaje").val(cubicaje.toFixed(2));
        $("#costo_perdido").val(costo.toFixed(2));
    });

function obtener_ruta(id_ruta){

    $('#llenado_confirmacion').show();
    $('#div_rutas').hide();

$.ajax({
        type: "POST",
        url: '/Rutas/extrae_ruta',
        data: {  "id_ruta":id_ruta , 
            
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Calculando Costos..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            console.log(data1);
          
                $('#guia').val(data1[0]['guia']);
                $('#placa').val(data1[0]['placa']);
                $('#fecha').val(data1[0]['fecha_salida']);
                $('#origen').val(data1[0]['detalle']);
                $('#destino').val(data1[0]['nombre_contrato']);
                $('#material').val(data1[0]['det_material']);
                $('#viajes').val(data1[0]['viajes']);
                $('#cubicaje_unitario').val(data1[0]['cubicaje_unitario']);
                $('#costo_unitario').val(data1[0]['costo_ruta_cubicaje']);
                $('#cubicaje_total').val(data1[0]['cubicaje_total']);
                $('#costo_total_viajes').val(data1[0]['costo_total']);
                $('#oculto_valor_cubicaje').val(data1[0]['costo_ruta']);
                $('#tablon').val(data1[0]['tablon']);
                $('#oculto_id_ruta').val(data1[0]['idtbl_rutas_salida']);
               
                $('#id_origen').val(data1[0]['origen']);
                $('#id_destino').val(data1[0]['destino']);
            },
        Error:function(data){
            alert('Error ');
        }

    })
 

}

function prorratea_descuento(){
  
$('#modal-mensajes_3').modal('show');
$('#example11').remove();
 //   $('#modal-mensajes_3').append('<input type="hidden" id="id_dd" value="'+id_descuento+'">');
  }


function prorratea_valor(){
var monto= $('#monto').val();
var dividendos =$('#dividendos').val();
var descuento_sujerido= (monto /dividendos) ;
$('#example11').remove();
 $('#div_dividendos').append(''+
                ' <table id="example11" class="table table-bordered table-striped">'+
                '<thead>'+
                '   <tr>'+
                '       <th>Observaciones</th>'+
                '       <th>Descuento Sujerido</th>'+
                '       <th>Descuento </th>'+
                '       <th>Notas </th>'+
                '   </tr>'+
                '</thead>'+
                '<tbody>'+
                ' ');

 for(var i=1; i<= dividendos;i++){
                 $('#example11').append(''+
                '<tr>'+
                '   <td><label id="l_'+i+'">Descuento '+ $("#cbo_descuento option:selected").text()+':  '+ i+'/'+dividendos+'</label></td>'+
                '   <td><center>$ '+ descuento_sujerido.toFixed(2) +'</center></td>'+
                '   <td><input type="text" id="pro_'+i+'" class="form-control "></td>'+
                '   <td><input type="text" id="nota_'+i+'" class="form-control "></td>'+
                '<tr>');
            }
                 $('#example11').append('</tbody></table>');

}

function registra_eliminacion(){
     
$.ajax({
        type: "POST",
        url: '/Descuentos/registra_eliminacion',
        data: {  "id_descuento":$('#id_dd').val() , 
                "observaciones" :$('#eliminacion_detalle').val() ,
            
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           console.log(data1);
           location.reload('Descuentos/modificar_descuento');
         
        },
        Error:function(data){
            alert('Error ');
        }

    })
  }

function elimina_descuento(id_descuento){
    $('#modal-mensajes_2').modal('show');
    $('#modal-mensajes_2').append('<input type="hidden" id="id_dd" value="'+id_descuento+'">');
  }


/*
function tarifa_contratos(id_asociacion,nombre){
    
$.ajax({
        type: "POST",
        url: '/Transportistas/tarifa_contratos',
        data: {  "id_asociacion":id_asociacion , 
            
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Calculando Costos..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           console.log(data1);
               
           $('#tarifa_fija').show();
           $('#lista_tarifa').hide();
           $('#titulo_asociacion_tarifa').append(nombre);
          for(var i=0;i<=data1.length;i++)
          {
$('#tabla_tarifa').append('<tr>'+
    '<td><label >'+data1[i]["nombre_contrato"]+'</label></td>'+
    '<td> $ <input type="text" id="p_'+i+'" value="'+data1[i]["tarifa_piedra"]+'"></td>'+
    '<td> $ <input type="text" id="c_'+i+'" value="'+data1[i]["tarifa_cascajo"]+'"></td>'+
    '<td> $<input type="text"  id="a_'+i+'" value="'+data1[i]["tarifa_arcilla"]+'"></td>'+
    '<td> $<input type="text"  id="pb_'+i+'" value="'+data1[i]["tarifa_pbola"]+'">'+
    ' <input type="hidden"  id="contrato_'+i+'" value="'+data1[i]["id_contrato"]+'">'+
    ' <input type="hidden"  id="asociacion_'+i+'" value="'+data1[i]["id_asociacion"]+'"></td>'+
    '</tr>');
          }

         
        },
        Error:function(data){
            alert('Error ');
        }

    })
    
}
*/

    

function actualizar_tarifa(cant_registros){
 var  arreglo_tarifas= new Array();
for (var i = 0; i <= cant_registros-1; i++) {
   
     arreglo_tarifas[i]=[$('#p_'+i).val() , $('#c_'+i).val() , $('#a_'+i).val() , $('#pb_'+i).val(), 
     $('#contrato_'+i).val(), $('#asociacion_'+i).val()];
     var id_asociacion_buscar=$('#asociacion_'+i).val();
  }console.log(arreglo_tarifas);
  
  $.ajax({
        type: "POST",
        url: '/Transportistas/actualizar_tarifario',
        data: {  "arreglo_tarifas":arreglo_tarifas , 
                "id_asociacion_buscar":'147' , 
            
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Procesando..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           //console.log(data1);
           alert('Tarifario Actualizado');
           location.reload('Transportistas/modificar_tarifa');

           // mostrar_mensaje(2, 'Tarifario Guardado Con Exito', '');
             
        },
        Error:function(data){
            alert('Error al Actualizar el Tarifario');
        }

    })
    

}

function registrar_tarifa(cant_materiales,cant_contratos){

 var cantera=$('#cbo_cantera_base option:selected').val();
 if (cantera < 1){alert ('Seleccione Cantera de Origen'); return false;}
 var  arreglo_tarifas= new Array();
 //var total_registro=cant_materiales+cant_contratos;
var temp=0;
  for (var i = 0; i <= cant_contratos-1; i++) {
   
   for (var j = 0; j <= cant_materiales-1; j++) {

     arreglo_tarifas[temp]=[cantera,$('#t_'+i).val() , $('#mat_'+j).val() , $('#dat_'+i+'_'+j).val()];
     temp=temp+1;
  //alert($('#t_'+i).val()+ '-' +$('#mat_'+j).val()+'-'+ $('#dat_'+i+'_'+j).val()   );  
    }

}

  console.log(arreglo_tarifas);
  
//return false;


  $.ajax({
        type: "POST",
        url: '/Transportistas/guardar_tarifario',
        data: {  "arreglo_tarifas":arreglo_tarifas , 
                  "id_asociacion": $('#idtbl_asociacion').val() ,
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Calculando Costos..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           //console.log(data1);
           if(data1==true){
           alert('Tarifario Guardado');
           location.reload('Transportistas/registrar_tarifa');}
           else {
             alert('Error al guardar');
           }          // mostrar_mensaje(2, 'Tarifario Guardado Con Exito', '');
             
        },
        Error:function(data){
            alert('Error al Guardar el Tarifario');
        }

    })
    

}
//imagen de campos en  tablon
 $("#largo_b").keyup(function () {
        var value = $(this).val();
        $("#largo_t").val(value);
    });
 $("#ancho_b").keyup(function () {
        var value = $(this).val();
        $("#ancho_t").val(value);
    });
//

function confirma_cubicaje(){
    
  $('#modal-mensajes_1').modal('show');
  $('#sintablon_auto').val( ( $('#alto_b').val() * $('#largo_b').val() * $('#ancho_b').val() ) - ( $('#alto_g').val() * $('#largo_g').val() * $('#ancho_g').val() ));
  $('#contablon_auto').val( ( $('#alto_b').val() * $('#largo_b').val() * $('#ancho_b').val() ) - ( $('#alto_g').val() * $('#largo_g').val() * $('#ancho_g').val() ) + ( $('#alto_t').val() * $('#largo_t').val() * $('#ancho_t').val() ));
}

function guardar_ruta(){
//alert($("#cbo_material option:selected").val());
//alert($('#id_asociacion').val());
//return false;
 $.ajax({
        type: "POST",
        url: '/Rutas/guardar_ruta',
        data: {
                "guia":  $('#guia').val(), 
                "asociacion":$('#trasport_titulo').text(),
                "placa":  $('#placa_master').val(), 
                "origen": $("#cbo_canteras option:selected").val(),
                "destino": $("#cbo_destino option:selected").val(),
                "tablon": $("#cbo_tablon option:selected").text(),
                //"destino":$('#obra_titulo').text(),
                //"material":$('#material').val(),
                "material": $("#cbo_material option:selected").val(),
                "viajes":$('#viajes').val(),
                "cubicaje_unitario": $('#cubicaje').val(),
                "cubicaje_total":$('#metros_total').val(),
                "costo_ruta":$('#c_acordado').val(),
                "costo_ruta_cubicaje":  $('#c_final_acordado').val(),
                "costo_total":  $('#c_final_total').val(),
                "fecha_salida":  $('#fecha_salida').val(),
                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Verificando Placas..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            if (data1==true){
                alert('Registro Exitoso');
                location.reload('Rutas/guardar_ruta');

            }else{alert('No se registro .')}
        },
        
        Error:function(data){
            alert('Error al verificar placa');
        }

    })
}

function verifica_placa ()
{
  if ( $('#placa_master').val() == '') {alert('Ingrese Placa'); return false;};
  if ( $('#cbo_canteras option:selected').val() == 0) {alert('Seleccione la  Cantera de Origen'); return false;}
  if ( $('#cbo_material option:selected').val() == 0) {alert('Seleccione el material'); return false;}
  if ( $('#cbo_destino option:selected').val() == 0) {alert('Seleccione la obra de destino'); return false;}
  if ( $('#cbo_tablon option:selected').val() == 0) {alert('Seleccione si se uso tablón'); return false;}


  $.ajax({
        type: "POST",
        url: '/Rutas/verifica_placa',
        data: {
               "placa":  $('#placa_master').val(), 
                           },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Verificando Placas..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
            if(data1.length >=1){ 
            $('#div_desglose').append('<input type="hidden" id="id_asociacion" value="'+data1[0]['id_asociacion']+'">');
             calcular_ruta(); 
         }
            else{
                alert('Placa No Existe');
                $('#c_final_acordado').val('');
                $('#c_final_total').val('');
                $('#c_acordado').val('');
                $('#cubicaje').val('');
                 $('#metros_total').val('');
                $('#viajes').val('');
                $('#placa').val('');
                $('#material').val('');
                 $('#obra_titulo').text('');
                $('#trasport_titulo').text('');
        }
        },
        Error:function(data){
            alert('Error al verificar placa');
        }

    })

}
function calcular_ruta(){


                $('#c_final_acordado').val('');
                $('#c_final_total').val('');
                $('#c_acordado').val('');
                $('#cubicaje').val('');
                 $('#metros_total').val('');

                $('#viajes').val('');
                $('#placa').val('');
                $('#material').val('');
                $('#obra_titulo').text('');


 $.ajax({
        type: "POST",
        url: '/Rutas/calcular_ruta',
        data: {
            "guia":  $('#guia').val(),
            "placa":  $('#placa_master').val(), 
            "cantera":  $('#cbo_canteras option:selected').val(),
            "material":  $('#cbo_material').val(),
            "fecha_salida":  $('#fecha_salida').val(),
            "tablon":  $('#cbo_tablon').val(),
            "destino":  $('#cbo_destino').val(),
            "viajes_master":  $('#viajes_master').val(),
            "asociacion":  $('#id_asociacion').val(),

                },
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Calculando Costos..."
            });
        },
        success: function (data) {
             HoldOn.close();
            var data1 = JSON.parse(data);
           console.log(data1);      
               
                $('#c_final_acordado').val(data1[0]["costo_unitario_vuelta"]);
                $('#c_final_total').val(data1[0]["costo_final_vueltas"]);
                $('#c_acordado').val(data1[0]["tarifa"]);
                $('#cubicaje').val(data1[0]["cubicaje"]);
                $('#metros_total').val(data1[0]["metraje"]);

                $('#viajes').val( $('#viajes_master').val());
                $('#placa').val($('#placa_master').val());
                $('#material').val($('#cbo_material option:selected').html());
                $('#obra_titulo').text(data1[0]["nombre_contrato"]);
                $('#trasport_titulo').text(data1[0]["nombre"]);
                
                //

        },
        Error:function(data){
            alert('Error al calcular No ingreso');
        }

    })

}

function mostrar_tarifa(nombre,idtbl_asociacion)
{
$('#lista').hide();
$('#tarifa').show();
$('#titulo_asociacion').append(' '+nombre+'');
$('#titulo_asociacion').append('<input type="hidden" id="idtbl_asociacion" value="'+idtbl_asociacion+'">');
//alert($('#idtbl_asociacion').val());

}



function guardar_descuentos(){
  
  
     $.ajax({
        type: "POST",
        url: '/Descuentos/guardar_descuentos',
        data: {
            "placa": $("#cbo_asociacion option:selected").val(),
            "cbo_descuento":  $('#cbo_descuento').val(), 
            //"origen":  $('#origen').val(),
            "origen": $("#cbo_canteras option:selected").val(),
            "fecha":  $('#fecha').val(),
            "monto":  $('#monto').val(),
            "cbo_destino":  $('#cbo_destino').val(),
            "observaciones":  $('#observaciones').val(),
                     
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
           console.log(data1);
               if (data1 = true){
                alert('Descuento guardado Correctamente');
                
                location.reload('Descuentos/registro_descuento');
                                }
        }
    })

}

function guardar_asociacion(){
   
     $.ajax({
        type: "POST",
        url: '/Transportistas/guardar_asociacion',
        data: {
            //"asociacion": $('#contrato').val(),
            "nombre":  $('#nombre').val(),
            "representante":  $('#representante').val(), 
            "ruc":  $('#ruc').val(),
            "telefono":  $('#telefono').val(),
             "correo":  $('#correo').val(),
            "observaciones":  $('#observaciones').val(),
                     
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
            // alert  (data1);
           console.log(data1);
           //$('#id_asociacion').val(data1[0]['idtbl_asociacion']);
            $('#id_asociacion').val(data1);
           $('#div_asociacion').hide();
           $('#div_vehiculo').show();

        }
    })

}

function modificar_asociacion_(){
   
     $.ajax({
        type: "POST",
        url: '/Transportistas/modificar_asociacion_',
        data: {
            "id_asociacion":  $('#id_asociacion_oculto').val(),
            "representante":  $('#representante').val(), 
            "ruc":  $('#ruc').val(),
            "telefono":  $('#telefono').val(),
             "correo":  $('#correo').val(),
            "observaciones":  $('#observaciones').val(),
                     
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
             //alert  (data1[0]['idtbl_asociacion']);
           console.log(data1);
          // $('#id_asociacion').val(data1[0]['idtbl_asociacion']);
          // $('#div_asociacion').hide();
          //$('#div_vehiculo').show();
          alert('Asociación Modificada con Exito');
            location.reload('Transportistas/modificar_asociacion');
        }
    })

}

function genera_tabla(){

    $('#example12').remove();
    $('#example12').empty();
    $('#divtabla').remove();
    $('#divtabla').empty();

    var div = document.createElement('div');
    div.id = 'divtabla';
    div.class = 'box-body table-responsive';
    $('#xxx').append(div);
    var table = document.createElement('table');
    table.id = 'example12';

    $('#divtabla').append(table);
    $("#example12").attr("class", "display table-bordered table-striped");


   //  id_asociacion = id_asociacion.toUpperCase();

     $.ajax({

        type: "POST",
        url: '/Transportistas/vehiculos_registrados',
        data: {
                "id_asociacion": $('#id_asociacion').val(),
                },

        success: function (data) {

            //alert(data);
            var data1 = JSON.parse(data);
            console.log(data1);

            $('#example12').DataTable({

                data: data1,
                "columns": [
                    {title: "Asignación", "data": "nombre"},
                    {title: "Placa", "data": "placa"},
                    {title: "Cubicaje con Tablón", "data": "cubicaje_tablon"},
                    {title: "Cubicaje sin Tablón", "data": "cubicaje_sin"},
                    {title: "id_asociacion", "data": "id_asociacion"},
                  
                   ],

                "language": {
                    "search": "Buscar",
                    "zeroRecords": "No se encontraron registros",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrando de _MAX_ registros en total)",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });

        }})

    };


    function modifica_vehiculo(){

      
     $.ajax({
        type: "POST",
        url: '/Transportistas/modifica_vehiculo',
        data: {
            //"asociacion": $('#contrato').val(),
            "id_asociacion":  $('#id_asociacion').val(),
            "placa":  $('#placa').val(),
            "largo_b":  $('#largo_b').val(), 
            "alto_b":  $('#alto_b').val(),
            "ancho_b":  $('#ancho_b').val(),
            "largo_t":  $('#largo_t').val(), 
            "alto_t":  $('#alto_t').val(),
            "ancho_t":  $('#ancho_t').val(),
            "largo_g":  $('#largo_g').val(), 
            "alto_g":  $('#alto_g').val(),
            "ancho_g":  $('#ancho_g').val(),
            "sintablon_manual": $('#sintablon_manual').val(),
            "contablon_manual": $('#contablon_manual').val(),
           
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
            if (data1 = true){
                alert('Vehiculo  modificado Correctamente');
                location.reload('Transportistas/modifica_cubicaje');  

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
            //location.reload('Transportistas/registro_vehiculos');
        }
    })

}

    function guardar_vehiculo(){

if($('#placa').val()==''){alert('Ingrese la Placa'); return false;}

     $.ajax({
        type: "POST",
        url: '/Transportistas/guardar_vehiculo',
        data: {
            //"asociacion": $('#contrato').val(),
            "id_asociacion":  $('#id_asociacion').val(),
            "placa":  $('#placa').val(),
            "largo_b":  $('#largo_b').val(), 
            "alto_b":  $('#alto_b').val(),
            "ancho_b":  $('#ancho_b').val(),
            "largo_t":  $('#largo_t').val(), 
            "alto_t":  $('#alto_t').val(),
            "ancho_t":  $('#ancho_t').val(),
            "largo_g":  $('#largo_g').val(), 
            "alto_g":  $('#alto_g').val(),
            "ancho_g":  $('#ancho_g').val(),
            "sintablon_manual": $('#sintablon_manual').val(),
            "contablon_manual": $('#contablon_manual').val(),
           
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
            if (data1 = true){
                alert('Contrato guardado Correctamente');
                //  mostrar_mensaje(1, "Vehículo Registrado");
                    $('#placa').val('');
                    $('#largo_b').val('');
                    $('#alto_b').val('');
                    $('#ancho_b').val('');
                    $('#largo_t').val(''); 
                    $('#alto_t').val('');
                    $('#ancho_t').val('');
                    $('#largo_g').val(''); 
                    $('#alto_g').val('');
                    $('#ancho_g').val('');
                    $('#sintablon_manual').val(''),
                    $('#contablon_manual').val(''),
                    genera_tabla();
             

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
            //location.reload('Transportistas/registro_vehiculos');
        }
    })

}


$('#example11').dataTable({
"paging": true,
"bPaginate": true,
"iDisplayLength": 5,
"aLengthMenu": [[5, 10, -1], [5, 10, "All"]],
"bFilter": true,
"bSort": true,
"bInfo": true,
"bAutoWidth": true
});

$('#example1').dataTable({
"paging": true,
"bPaginate": true,
"iDisplayLength": 7,
"aLengthMenu": [[7, 10, -1], [7, 10, "All"]],
"bFilter": true,
"bSort": true,
"bInfo": true,
"bAutoWidth": false
});

$('#example10').dataTable({
"paging": true,
"bPaginate": true,
"iDisplayLength": 7,
"aLengthMenu": [[7, 10, -1], [7, 10, "All"]],
"bFilter": true,
"bSort": true,
"bInfo": true,
"bAutoWidth": false
});



$('#example100').DataTable({
             "iDisplayLength": 7,
            "aLengthMenu": [[7, 10, -1], [7, 10, "All"]],
           dom: 'Bfrtip',
           buttons: [ 'excel', 'pdf', 'print'],
});



function mostrar_contrato(idtbl_contrator,contrato,mail_contacto,contacto,dir_contacto,tel_contacto,
                          observaciones){

    $('#contratos').hide();
    $('#llenado_modificacion').attr( "style", "display: block ;" );
    $('#titulo_documento').append(' : '+ contrato);
    $('#contrato').val(contrato);
    $('#mail_contacto').val(mail_contacto);
    $('#contacto').val(contacto);
    $('#tel_contacto').val(tel_contacto);
    $('#dir_entrega').val(dir_contacto);
    $('#observaciones').val(observaciones);
    $('#oculto_id_contrato').val(idtbl_contrator);
   // obtiene_costos_guardados(idtbl_contrator);
    obtiene_cubicaje_guardados(idtbl_contrator);
}

function obtiene_cubicaje_guardados(idtbl_contrator){

$.ajax({
        type: "POST",
        url: '/Contratos/obtiene_cubicaje_guardados',
        data: {
            "id_contrato": idtbl_contrator,
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
           
           for(var i=0; i<=data1.length-1;i++ ){
             $('#div_requerido').append(''+
              '<div class="row">'+
                       '     <div class="col-md-3"></div>'+
                        '     <div class="col-md-3"><label>'+data1[i]['detalle']+': </label> </div>  '+
                         '       <div class="col-md-4"><div class="input-group">'+
                         '           <span class="input-group-addon"><i class="glyphicon glyphicon-tasks"></i></span>'+
                         ' <input type="number" class="form-control" id="cub_data_'+i+'"  value="'+data1[i]['cantidad']+'" required'+
                          '     placeholder="5000">'+
                           ' <input type="hidden" class="form-control" id="cub_data_mat_'+i+'" value="'+data1[i]['id_material']+'">'+
                           ' <input type="hidden" class="form-control" id="cub_data_con_'+i+'"  value="'+data1[i]['id_contrato']+'">'+
                            '   </div></div>'+
                       ' </div>   <br> ');
                }
            console.log(data1);
        },

    })

}

function mostrar_contrato_base(idtbl_contrator,contrato){

    $('#contratos').hide();
    $('#llenado_modificacion').attr( "style", "display: block ;" );
    $('#titulo_2').append(' : '+ contrato);
    $('#contrato').val(contrato);

    $('#oculto_id_contrato').val(idtbl_contrator);
   // obtiene_costos_guardados(idtbl_contrator);

}

$('#cbo_canteras').change(function() {
  if( $(this).val()==0){     $('#div_costo').empty(); return false; }
  else { obtiene_costos_guardados( $('#oculto_id_contrato').val(),$(this).val()); }

})

$('#cbo_cantera_base').change(function() {
    if( $(this).val()==0){
        //$('#mega_tabla').empty();
        return false; }
    else {  $('#mega_data').show();
    obtiene_mega_matriz_costos( $('#idtbl_asociacion').val(),$(this).val());
        }

})

function obtiene_mega_matriz_costos (id_asociacion,id_cantera){
    $.ajax({
        type: "POST",
        url: '/Transportistas/obtiene_mega_matriz_costos',
        data: {
            "id_contrato": id_asociacion,
            "id_cantera": id_cantera,
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
            console.log(data1);
            $('#mega_data').append('<table>');

            for(var i=0; i<=7 ;i++ ) {
                $('#mega_data').append('' +
                    '<tr>' +
                    ' <td ><input type="text" value="'+data1[0]['id_contrato']+'" id="" ></td>' );
                for(var x=0; x<=5 ;x++ ) {
                    $('#mega_data').append(' <td ><input type="text" value="'+data1[0]['valor']+'"  ></td>' );
                                    }

                $('#mega_data').append('</tr>');
            }
            $('#mega_data').append('</table>');
        },
        Error:function(data){
            alert('Error ');
        }
    })
}

function obtiene_costos_guardados(idtbl_contrator,id_cantera){
$('#div_costo').empty();
$.ajax({
        type: "POST",
        url: '/Contratos/obtiene_costos_guardados',
        data: {
            "id_contrato": idtbl_contrator,
            "id_cantera": id_cantera,
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
                     $('#div_costo').append('<input type="hidden" id="cant_items" value=" '+ data1.length+' ">');
           for(var i=0; i<=data1.length -1 ;i++ ){
             $('#div_costo').append(''+
              '<div class="row">'+
                       '     <div class="col-md-3"></div>'+
                        '     <div class="col-md-3"><label>'+data1[i]['detalle']+': </label> </div>  '+
                         '       <div class="col-md-4"><div class="input-group">'+
                         '           <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>'+
                         ' <input type="number" class="form-control" id="val_data_'+i+'"  value="'+data1[i]['valor']+'" required'+
                          '     placeholder="$ 0.50">'+
                            ' <input type="hidden" class="form-control" id="val_data_mat'+i+'"  value="'+data1[i]['id_material']+'">'+
                           ' <input type="hidden" class="form-control" id="val_data_con'+i+'"  value="'+data1[i]['id_contrato']+'">'+
                            '   </div></div>'+
                       ' </div>   <br> ');
                }
            console.log(data1);
        },
         Error:function(data){
            alert('Error ');
        }
    })

}


function elimina_contrato(){

   $.ajax({
        type: "POST",
        url: '/Contratos/elimina_contrato',
        data: {
            "id_contrato": $('#oculto_id_contrato').val(),
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
            if (data1 = true){
                alert('Contrato Eliminado ');
                location.reload('Contratos/modificar_contrato');
            }else {alert ('Error al Eliminar el Contrato');};
            console.log(data1);
             

        },
         Error:function(data){
            alert('Error ');
        }
    })

    }



function finaliza_contrato(){

   $.ajax({
        type: "POST",
        url: '/Contratos/finaliza_contrato',
        data: {
            "id_contrato": $('#oculto_id_contrato').val(),
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
            if (data1 = true){
                alert('Contrato Finalizado ');
                location.reload('Contratos/modificar_contrato');
            }else {alert ('Error al Felinalizar el Contrato');};
            console.log(data1);
             

        },
         Error:function(data){
            alert('Error ');
        }
    })

    }

function llena_precio_base(cant_items){
    if($('#cbo_canteras option:selected').val()==0 ){ alert('Seleccione Cantera');return false  ;};
    var  arreglo_tarifas= new Array();
    var x=0;
    for (var i = 0; i <= cant_items-1; i++) {
        if ($('#val_data_'+i).val() > 0){
            arreglo_tarifas[x]=[$('#val_data_con'+i).val() , $('#val_data_mat'+i).val(), $('#val_data_'+i).val(), $('#cbo_canteras option:selected').val() ];
            x=x+1;
        }
       
      //  console.log(arreglo_tarifas);

    } 
    if (arreglo_tarifas.length == 0){alert('Nada que registrar'); return false;}
   // return false;

    $.ajax({
        type: "POST",
        url: '/Contratos/actualizar_base',
        data: {
            "arreglo_tarifas": arreglo_tarifas,
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

            if (data1 = true){
                alert('Contrato Actualizado Correctamente');
            }else {
                alert ('Registros NO se pudo guardar');};
            console.log(data1);
            location.reload('Contratos/modificar_contrato');

        }
    })

}


    function modificar_contrato(){

/*
if ($('#mail_contacto').val()==''){alert('Ingrese el email del Contacto');return false;};
if ($('#contacto').val()==''){alert('Ingrese el Nombre del Contacto');return false;};
if ($('#tel_contacto').val()==''){alert('Ingrese el No telefónico del Contacto');return false;};
if ($('#dir_entrega').val()==''){alert('Ingrese la dirección de entrega');return false;};
if ($('#piedra').val()==''){alert('Ingrese costo referencial la piedra');return false;};
if ($('#cascajo').val()==''){alert('Ingrese costo referencial del Cascajo');return false;};
if ($('#arcilla').val()==''){alert('Ingrese costo referencial la arcilla');return false;};
if ($('#piedra_bola').val()==''){alert('Ingrese costo referencial la piedra bola');return false;};
*/

var  arreglo_cubicaje= new Array();
//var  arreglo_tarifas= new Array();
    for (var i = 0; i <= 12; i++) {
      if ( $('#cub_data_'+i).val() > 0 ){
          arreglo_cubicaje[i]=[$('#cub_data_con_'+i).val() , $('#cub_data_mat_'+i).val(), $('#cub_data_'+i).val()  ];
          //arreglo_tarifas[i]=[$('#val_data_con'+i).val() , $('#val_data_mat'+i).val(), $('#val_data_'+i).val()  ];
      }
     
  }


   $.ajax({
        type: "POST",
        url: '/Contratos/modificar_contratos',
        data: {
            "id_contrato": $('#oculto_id_contrato').val(),
            "nombre_contrato": $('#contrato').val(),
            "email_contrato":  $('#mail_contacto').val(),
            "contacto_contrato":  $('#contacto').val(), 
            "direccion_contrato":  $('#dir_entrega').val(),
            "telefono_contrato":  $('#tel_contacto').val(),
            "observaciones_contrato":  $('#observaciones').val(),
            "arreglo_cubicaje": arreglo_cubicaje,
          //  "arreglo_tarifas": arreglo_tarifas,
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

            if (data1 = true){
                alert('Contrato Actualizado Correctamente');
            }else {
              alert ('Registros NO se pudo guardar');};
              console.log(data1);
             location.reload('Contratos/modificar_contrato');

        }
    })

    }

function guardar_contrato(cantidad){

if ($('#contrato').val()==''){alert('Ingrese el Nombre del Contrato');return false;};
if ($('#mail_contacto').val()==''){alert('Ingrese el email del Contacto');return false;};
if ($('#contacto').val()==''){alert('Ingrese el Nombre del Contacto');return false;};
if ($('#tel_contacto').val()==''){alert('Ingrese el No telefónico del Contacto');return false;};
if ($('#dir_entrega').val()==''){alert('Ingrese la dirección de entrega');return false;};  


   $.ajax({
        type: "POST",
        url: '/Contratos/guardar_contrato',
        data: {
            "nombre_contrato": $('#contrato').val(),
            "email_contrato":  $('#mail_contacto').val(),
            "contacto_contrato":  $('#contacto').val(), 
            "direccion_contrato":  $('#dir_entrega').val(),
            "telefono_contrato":  $('#tel_contacto').val(),
            "observaciones_contrato":  $('#observaciones').val(),
            "compactado":  $('#compactado').val(),
            "suelto":  $('#suelto').val(),

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
                if (data1[0]['last_insert_id()'] > 0){
                guardar_contrato_valores(cantidad,data1[0]['last_insert_id()']);
                }else{alert('No se pudo registrar');}
            console.log(data1);
        }
    })
}


function guardar_contrato_valores(cantidad,id_contrato){

 var  arreglo_tarifas= new Array();
 var x=0;
    for (var i = 0; i <= cantidad-1; i++) {
   
     arreglo_tarifas[x]=[id_contrato,$('#material_'+i).val() , $('#v_'+i).val() ];
     x=x+1;
  }console.log(arreglo_tarifas);
  
     $.ajax({
        type: "POST",
        url: '/Contratos/guardar_contrato_valores',
        data: {
        "arreglo":arreglo_tarifas,
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
            if (data1 = true){

               guardar_contrato_cubicaje_requerido(cantidad,id_contrato);

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
                             }
    })
 }

function guardar_contrato_cubicaje_requerido(cantidad,id_contrato){

 var  arreglo_cubicaje_solicitado= new Array();
    for (var i = 0; i <= cantidad-1; i++) {
   
     arreglo_cubicaje_solicitado[i]=[id_contrato,$('#material_cubicaje_'+i).val() , $('#cubicaje_'+i).val() ];
     
  }console.log(arreglo_cubicaje_solicitado);
  
     $.ajax({
        type: "POST",
        url: '/Contratos/guardar_contrato_cubicaje_requerido',
        data: {
        "arreglo":arreglo_cubicaje_solicitado,
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
            if (data1 = true){

                alert('Contrato guardado Correctamente'); 
                location.reload('Contratos/registrar_contrato');

            }else {alert ('Registros NO se pudo guardar');};
            console.log(data1);
        }
    })   
    }



   

    

