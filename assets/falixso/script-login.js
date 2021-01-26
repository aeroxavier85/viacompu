
$("#btn_login").on("click", function() {
    var usuario =  $("#txt_usuario").val();
    var contraseña =  $("#txt_pass").val();
    var empresa =  $("#cb_empresa option:selected").val();

    if(usuario == ""){
        mostrar_mensaje(1, 'El campo usuario no puede estar vacío', '');
        return false;
    }
    if(contraseña == ""){
        mostrar_mensaje(1, 'El campo contraseña no puede estar vacío', '');
        return false;
    }
    if(empresa == 0){
        mostrar_mensaje(1, 'Seleccione empresa', '');
        return false;
    }

    var data_  = {
        'usuario': usuario,
        'contraseña' : contraseña,
        'empresa' : empresa
    };

    $.ajax({
        type: "GET",
        url: base_url + 'Autenticacion/click_login',
        data: data_,
        beforeSend: function () {
            HoldOn.open({
                theme: "sk-circle",
                message: "Consultando datos de inicio de sesión por favor... espere"
            });
        },
        success: function (respuesta) {
            var data = JSON.parse(respuesta);
            mostrar_mensaje(data.op, data.mensaje, '');
            HoldOn.close();
            setTimeout(function(){
                window.location= base_url + 'socios/perfil';
            }, 2500);

        },
        error: function (error) {
            HoldOn.close();
            mostrar_mensaje(1, 'Ocurrio un problema con la conexión, intente en unos momentos', '');
        },
        dataType: 'text'
    });
});

$("#btn_registrar").on("click", function (){

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