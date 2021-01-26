

$("#btn_buscar_archivos").on("click", function (){
    var txt_nombre_r_d = $("#txt_nombre_r_d").val();
    var txt_archivo = $("#txt_archivo").val();
    if(txt_archivo == ""){
        mostrar_mensaje(1, "Ingrese del archivo", '');
        return false;
    }

    var data_  = {
        'txt_nombre_r_d': txt_nombre_r_d,
        'txt_archivo': txt_archivo
    };

    $.ajax({
        type: "GET",
        url: base_url + 'documentos/buscar_archivos',
        data: data_,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Consultando datos por favor... espere"
            });
        },
        success: function (respuesta) {
            var data = JSON.parse(respuesta);
            HoldOn.close();
            if(data.op == 0){
                $("#id_info_busqueda").html(data.tabla);
            }else{
                $("#id_info_busqueda").html(data.mensaje);
            }
        },
        error: function (error) {
            HoldOn.close();
            mostrar_mensaje(1, 'Ocurrio un problema con la conexión, intente en unos momentos', '');
        },
        dataType: 'text'
    });
});

function presentaDoc(id)
{
    var pdf = "<embed src='"+base_url +"assets"+id+"' width='640' height='375'>"
    $("#doc_presenta").html(pdf);
}

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
