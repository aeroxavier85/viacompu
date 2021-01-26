


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


    function soloNumeros(e) {
        var key = window.Event ? e.which : e.keyCode
        return ((key >= 46 && key <= 57) || (key == 8))
    }

    function sololetras() {
        //alert(event.keyCode);
        if (event.keyCode > 46 && event.keyCode < 57 | event.keyCode == 64) event.returnValue = false;
    }


    $("#btn_grabar_edicion_socio").on("click", function (){
        var id_usuario = $("#id_usuario_socio").val();
        var txt_nombres = $("#txt_nombres").val();
        var txt_apellidos = $("#txt_apellidos").val();
        var txt_correo = $("#txt_correo").val();
        var txt_telefono = $("#txt_telefono").val();
        var txt_celular = $("#txt_celular").val();
        var txt_ciudad = $("#txt_ciudad").val();
        var txt_direccion = $("#txt_direccion").val();
        var txt_fecha_nacimiento = $("#txt_fecha_nacimiento").val();
        var txt_pagina = $("#txt_pagina").val();
        var txt_acerca_de_mi = $("#txt_acerca_de_mi").val();

        if(txt_nombres == ""){
            mostrar_mensaje(2,"Ingrese sus nombres", '');
            return false;
        }
        if(txt_apellidos == ""){
            mostrar_mensaje(2,"Ingrese sus apellidos", '');
            return false;
        }
        if(txt_correo == ""){
            mostrar_mensaje(2,"Ingrese un correo", '');
            return false;
        }
        if(txt_telefono == ""){
            mostrar_mensaje(2,"Ingrese un número de teléfono", '');
            return false;
        }
        if(txt_celular == ""){
            mostrar_mensaje(2,"Ingrese un número de celular", '');
            return false;
        }
        if(txt_fecha_nacimiento == 0){
            mostrar_mensaje(2,"Seleccione una fecha", '');
            return false;
        }
        if(txt_direccion == 0){
            mostrar_mensaje(2,"Ingrese una dirección", '');
            return false;
        }

        var data_  = {
            'id_usuario':id_usuario,
            'nombres' : txt_nombres,
            'apellidos' : txt_apellidos,
            'correo' : txt_correo,
            'telefono' : txt_telefono,
            'celular' : txt_celular,
            'ciudad' : txt_ciudad,
            'fecha_nace' : txt_fecha_nacimiento,
            'pagina'  : txt_pagina,
            'acerca'  : txt_acerca_de_mi,
            'direccion': txt_direccion
        };

        $.ajax({
            type: "GET",
            url: base_url + 'Administracion/admin_editar_socio',
            data: data_,
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Guardando datos por favor... espere"
                });
            },
            success: function (respuesta) {
                var data = JSON.parse(respuesta);
                HoldOn.close();
                if(data.op == 0){
                    mostrar_mensaje(data.op, data.mensaje, '');
                    setTimeout(function(){
                        window.location= base_url + 'Administracion/crear_socio';
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