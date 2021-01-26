


$("#cbo_opcion").on("change", function (){
   var opcion =  $("#cbo_opcion option:selected").val();
    if(opcion == 0){
        $("#div_raiz").hide();
        $("#btn_guardar_1").hide();
        $("#div_raiz_raiz").hide();
        $("#btn_guardar_2").hide();
        $("#campo_obligatorio").hide();
        $("#tab_Archivos").hide();
    }else{
        if(opcion == "P"){
            $("#div_raiz").show();
            $("#btn_guardar_1").show();
           //$("#div_raiz").hide();
            $("#btn_guardar_2").hide();
            $("#campo_obligatorio").show();

        }else{
            //$("#div_raiz_raiz").show();
            $("#btn_guardar_2").show();
            $("#div_raiz").show();
            $("#btn_guardar_1").hide();
            $("#campo_obligatorio").hide();

        }
    }
});

$("#btn_submit").on("click", function (){

        HoldOn.open({
            theme: "sk-circle",
            message: "Guardando datos por favor... espere"
        });
        setTimeout(function(){
            HoldOn.close();
            mostrar_mensaje(0, "Datos Guardados", '');
            setTimeout(function(){
                window.location= base_url + 'documentos/ruta';
            }, 1000);
        }, 1000);

});

$("#btn_cambiar_nombre").on("click", function() {
    var id_name = $("#cbo_opcion_carpetas").val();
    var txt_nuevo_nombre = $("#txt_nuevo_nombre").val();
    if(id_name == 0){
        mostrar_mensaje(2,"Seleccione una carpeta", '');
        return false;
    }
    if(txt_nuevo_nombre == ""){
        mostrar_mensaje(2,"Ingrese el nuevo nombre de la carpeta", '');
        return false;
    }
    var data_  = {
        'id_name': id_name,
        'txt_nuevo_nombre' : txt_nuevo_nombre
    };

    $.ajax({
        type: "GET",
        url: base_url + 'Administracion/admin_cambiar_nombre',
        data: data_,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando los datos por favor... espere"
            });
        },
        success: function (respuesta) {
            var data = JSON.parse(respuesta);
            HoldOn.close();
            if(data.op == 0){
                mostrar_mensaje(data.op, data.mensaje, '');
                setTimeout(function(){
                    window.location= base_url + 'documentos/ruta';
                }, 1500);
            }else{
                mostrar_mensaje(data.op, data.mensaje, '');
            }
        },
        error: function (error) {
            HoldOn.close();
            mostrar_mensaje(1, 'Ocurrio un problema con la conexión, intente en unos momentos', '');
        },
        dataType: 'text'
    });


});

$("#btn_guardar_1").on("click", function (){
    var nombre = $("#txt_raiz").val();
    if(nombre == ""){
        mostrar_mensaje(1, "Ingrese el nombre para la carpeta", '');
        return false;
    }

    var data_  = {
        'nombre': nombre
    };

    $.ajax({
        type: "GET",
        url: base_url + 'Administracion/crear_nueva_ruta',
        data: data_,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando los datos por favor... espere"
            });
        },
        success: function (respuesta) {
            var data = JSON.parse(respuesta);
            HoldOn.close();
            if(data.op == 0){
                mostrar_mensaje(data.op, data.mensaje, '');
                $("#tab_Archivos").show();
                $("#tab_Archivos").click();
                $("#btn_guardar_2").hide();
                $("#btn_guardar_1").hide();
                $("#nueva_ruta_id").val(data.nueva_ruta_id);
                /*setTimeout(function(){
                    window.location= base_url + 'documentos/ruta';
                }, 1500);*/
            }else{
                mostrar_mensaje(data.op, data.mensaje, '');
            }
        },
        error: function (error) {
            HoldOn.close();
            mostrar_mensaje(1, 'Ocurrio un problema con la conexión, intente en unos momentos', '');
        },
        dataType: 'text'
    });
});

$("#btn_guardar_2").on("click", function(){
    var nombre = $("#txt_raiz").val();
    var opcion =  $("#cbo_opcion option:selected").val();
    var nombre_texto =  $("#cbo_opcion option:selected").text();
    if(nombre == ""){
        mostrar_mensaje(1, "Ingrese el nombre para la carpeta", '');
        return false;
    }

    var data_  = {
        'nombre': nombre,
        'opcion': opcion,
        'nombre_texto':nombre_texto
    };

    $.ajax({
        type: "GET",
        url: base_url + 'Administracion/crear_nueva_ruta_hija',
        data: data_,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Guardando los datos por favor... espere"
            });
        },
        success: function (respuesta) {
            var data = JSON.parse(respuesta);
            HoldOn.close();
            if(data.op == 0){
                mostrar_mensaje(data.op, data.mensaje, '');
                $("#tab_Archivos").show();
                $("#tab_Archivos").click();
                $("#btn_guardar_2").hide();
                $("#btn_guardar_1").hide();
                $("#nueva_ruta_id").val(data.nueva_ruta_id);
                /*setTimeout(function(){
                    window.location= base_url + 'documentos/ruta';
                }, 1500);*/
            }else{
                mostrar_mensaje(data.op, data.mensaje, '');
            }
        },
        error: function (error) {
            HoldOn.close();
            mostrar_mensaje(1, 'Ocurrio un problema con la conexión, intente en unos momentos', '');
        },
        dataType: 'text'
    });
});



function mostrar_mensaje(error, mensaje, page) {
    var icono='<i class="fa fa-check-circle"></i> ';
    var color="green";
    $('#btnCerrarModalMensaje').removeClass('btn-warning');
    $('#btnCerrarModalMensaje').removeClass('btn-danger');
    $('#btnCerrarModalMensaje').addClass('btn-success');
    if(error==1)
    {
        var color="red";
        var icono='<i class="fa fa-exclamation-circle"></i> ';
        $('#btnCerrarModalMensaje').removeClass('btn-warning');
        $('#btnCerrarModalMensaje').removeClass('btn-success');
        $('#btnCerrarModalMensaje').addClass('btn-danger');
    }
    if(error==2)
    {
        var color="orange";
        var icono='<i class="fa fa-exclamation-circle"></i> ';

        $('#btnCerrarModalMensaje').removeClass('btn-success');
        $('#btnCerrarModalMensaje').removeClass('btn-danger');
        $('#btnCerrarModalMensaje').addClass('btn-warning');

    }


    $('#modal_body_mensaje').html("<span style='color:"+color+";'>"+icono+mensaje+"</span>");
    if (page != '') {
        $('#btnCerrarModalMensaje').attr("onclick", "redireccionar_pagina('" + page + "')");
    }


    $('#modal-mensajes').modal();
}


function presentaDoc(id)
{
    var pdf = "<embed src='"+base_url +"assets"+id+"' width='400' height='375'>"
    $("#doc_presenta").html(pdf);
}