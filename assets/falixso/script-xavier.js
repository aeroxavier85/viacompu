
$('#example1').DataTable();

 $("#btn_grabar_socio").on("click", function(){


        var txt_nombre_usuario = $("#txt_nombre_usuario").val();
        var txt_nombres = $("#txt_nombres").val();
        var txt_apellidos = $("#txt_apellidos").val();
        var txt_cedula = $("#txt_cedula").val();
        var txt_telefono = $("#txt_telefono").val();

        if(txt_nombre_usuario == ""){
           
             mostrar_mensaje(1,"Ingrese sus nombres", '');
            return false;
        }
        if(txt_nombres == ""){
            mostrar_mensaje(1,"Ingrese sus nombres", '');
            return false;
        }
        if(txt_apellidos == ""){
            mostrar_mensaje(1,"Ingrese sus apellidos", '');
            return false;
        }

        if(txt_cedula == ""){
            mostrar_mensaje(1,"Ingrese un número de cédula", '');
            return false;
        }
        if(txt_telefono == ""){
            mostrar_mensaje(1,"Ingrese un número de teléfono", '');
            return false;
        }


        var data_  = {
            'usuario': txt_nombre_usuario,
            'nombres' : txt_nombres,
            'apellidos' : txt_apellidos,
            'cedula' : txt_cedula,
            'telefono' : txt_telefono

        };

        $.ajax({
            type: "POST",
            url: base_url + 'Administracion/admin_crear_socio',
            data: data_,
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Guardando los datos por favor... espere"
                });
            },
            success: function (respuesta) {
                console.log(respuesta);
                HoldOn.close();
                 var data = JSON.parse(respuesta);
                  console.log(data);
                
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

////////////////////


