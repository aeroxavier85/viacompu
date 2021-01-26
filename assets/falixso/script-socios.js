
    //initiate dataTables plugin
    var myTable =
        $('#dynamic-table')
            .DataTable( {
                bAutoWidth: false,
                "aoColumns": [
                    { "bSortable": false },
                    null, null,null, null, null,
                    { "bSortable": false }
                ],
                "aaSorting": [],
                select: {
                    style: 'multi'
                }
            } );



    $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

    new $.fn.dataTable.Buttons( myTable, {
        buttons: [
            {
                "extend": "colvis",
                "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Mostrar/Ocultar Columnas</span>",
                "className": "btn btn-white btn-primary btn-bold",
                columns: ':not(:first):not(:last)'
            },
            {
                "extend": "copy",
                "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copiar al Portapapeles</span>",
                "className": "btn btn-white btn-primary btn-bold"
            },
            {
                "extend": "csv",
                "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Exportar a CSV</span>",
                "className": "btn btn-white btn-primary btn-bold"
            },
            {
                "extend": "excel",
                "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exportar a Excel</span>",
                "className": "btn btn-white btn-primary btn-bold"
            },
            {
                "extend": "pdf",
                "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exportar a PDF</span>",
                "className": "btn btn-white btn-primary btn-bold"
            },
            {
                "extend": "print",
                "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimir</span>",
                "className": "btn btn-white btn-primary btn-bold",
                autoPrint: false,
                message: 'This print was produced using the Print button for DataTables'
            }
        ]
    } );
    myTable.buttons().container().appendTo( $('.tableTools-container') );

    //style the message box
    var defaultCopyAction = myTable.button(1).action();
    myTable.button(1).action(function (e, dt, button, config) {
        defaultCopyAction(e, dt, button, config);
        $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
    });


    var defaultColvisAction = myTable.button(0).action();
    myTable.button(0).action(function (e, dt, button, config) {

        defaultColvisAction(e, dt, button, config);


        if($('.dt-button-collection > .dropdown-menu').length == 0) {
            $('.dt-button-collection')
                .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                .find('a').attr('href', '#').wrap("<li />")
        }
        $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
    });

    ////

    setTimeout(function() {
        $($('.tableTools-container')).find('a.dt-button').each(function() {
            var div = $(this).find(' > div').first();
            if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
            else $(this).tooltip({container: 'body', title: $(this).text()});
        });
    }, 500);





    myTable.on( 'select', function ( e, dt, type, index ) {
        if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
        }
    } );
    myTable.on( 'deselect', function ( e, dt, type, index ) {
        if ( type === 'row' ) {
            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
        }
    } );




    /////////////////////////////////
    //table checkboxes
    $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

    //select/deselect all rows according to table header checkbox
    $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header

        $('#dynamic-table').find('tbody > tr').each(function(){
            var row = this;
            if(th_checked) myTable.row(row).select();
            else  myTable.row(row).deselect();
        });
    });

    //select/deselect a row when the checkbox is checked/unchecked
    $('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
        var row = $(this).closest('tr').get(0);
        if(this.checked) myTable.row(row).deselect();
        else myTable.row(row).select();
    });



    $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    });



    //And for the first simple table, which doesn't have TableTools or dataTables
    //select/deselect all rows according to table header checkbox
    var active_class = 'active';



    /********************************/
    //add tooltip for small view action buttons in dropdown menu
    $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});

    //tooltip placement on right or left
    function tooltip_placement(context, source) {
        var $source = $(source);
        var $parent = $source.closest('table')
        var off1 = $parent.offset();
        var w1 = $parent.width();

        var off2 = $source.offset();
        //var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
    }




    /***************/
    $('.show-details-btn').on('click', function(e) {
        e.preventDefault();
        $(this).closest('tr').next().toggleClass('open');
        $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
    });
    /***************/




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


    $("#btn_crear_socio").on('click', function () {
        $("#div_tabla_socios").hide();
        $("#div_crear_socios").show();
    });

    $("#btn_lista_socio").on('click', function () {
        $("#div_tabla_socios").show();
        $("#div_crear_socios").hide();
    });

    $("#btn_borrar").on("click", function(){
        $("#txt_nombre_usuario").val("");
        $("#txt_nombres").val("");
        $("#txt_apellidos").val("");
        $("#txt_correo").val("");
        $("#txt_cedula").val("");
        $("#txt_telefono").val("");
        $("#txt_celular").val("");
        $("#txt_ciudad").val("");
        $("#txt_fecha_nacimiento").val("");
        $("#txt_pagina").val("");
        $("#txt_acerca_de_mi").val("");
    });


    function soloNumeros(e) {
        var key = window.Event ? e.which : e.keyCode
        return ((key >= 46 && key <= 57) || (key == 8))
    }

    function sololetras() {
        //alert(event.keyCode);
        if (event.keyCode > 46 && event.keyCode < 57 | event.keyCode == 64) event.returnValue = false;
    }


    function guardar_resumen(){

        var ids;
        ids = $('input[type=checkbox]:checked').map(function() {
            var temp= $(this).attr('id');
            var nombre= $('#nombre_'+temp).text() +' '+ $('#apellido_'+temp).text();
            return nombre;
        }).get();
        // alert('IDS: ' + ids.join(', '));

        var data_  = {
            'fecha_reunion': $('#id_fecha_reunion').val(),
            'data' : tinyMCE.get('resumen_data').getContent(),
            'listado' : ids.join(', '),
            'titulo': $('#titulo_reunion').val(),
        };

        if($('#id_fecha_reunion').val()  == ""){
            mostrar_mensaje(2,"Ingrese la fecha de la reunión", '');
            return false;
        }
        if($('#titulo_reunion').val()  == ""){
            mostrar_mensaje(2,"Ingrese el Título de la reunión", '');
            return false;
        }
        if(ids  == ""){
            mostrar_mensaje(2,"Seleccione las personas que estuvierón en la reunión", '');
            return false;
        }
        if(tinyMCE.get('resumen_data').getContent()  == ""){
            mostrar_mensaje(2,"Ingrese el resumen ejecutivo de la reunión", '');
            return false;
        }

        $.ajax({
            type: "GET",
            url: base_url + 'Socios/guardar_asistencia',
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
                if(data == true){
                    mostrar_mensaje(data.op, "Lista guardada", '');
                    setTimeout(function(){
                        window.location= base_url + 'socios/asistencia';
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
    }


   

    function agregarPermisos(id)
    {
        var data_  = {
            'id_usuario': id
        };

        $.ajax({
            type: "GET",
            url: base_url + 'Administracion/cargar_menu_socios',
            data: data_,
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Cargando los datos por favor... espere"
                });
            },
            success: function (respuesta) {
                var data = JSON.parse(respuesta);
                HoldOn.close();
                if(data.op == 0){
                    $("#id_socio_menus").val(id);
                    $("#tabla_socios_menu").html(data.tabla);
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
    }

    function desactivarSocio(id)
    {
        $("#txt_id_socio_desactiva").val(id);
    }

    $("#btn_desactivar_socio").on("click", function(){
       var id_socio_desactiva = $("#txt_id_socio_desactiva").val();
        var data_  = {
            'id_socio_desactiva': id_socio_desactiva
        };

        $.ajax({
            type: "GET",
            url: base_url + 'Administracion/admin_desactiva_socio',
            data: data_,
            beforeSend: function () {
                $("#btn_cerrar_desactiva").click();
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
function consutaDetalle(){

        var cbo_mes = $('#cbo_mes').val();
        var cbo_anio = $('#cbo_anio').val();

        if(cbo_mes == 0) {
            mostrar_mensaje(2,"Seleccione mes", '');
            return false;
        }
        if(cbo_anio == 0) {
            mostrar_mensaje(2,"Seleccione anio", '');
            return false;
        }
        HoldOn.open({
            theme: "sk-circle",
            message: "Guardando datos por favor... espere"
        });

        setTimeout(function(){
            window.open(base_url + 'socios/consulta_informe_asistencia/'+cbo_mes+'/'+cbo_anio,'_blank');
            //window.open= base_url + 'socios/consulta_informe_asistencia';
        }, 1500);
        HoldOn.close();
    }
    $("#btn_guardar_1").on("click", function (){
        var group = $('input[name="grupos[]"]');
        var id_group_t = "";
        var id_group_f = "";
        if (group.length > 1){
            group.each(function () {
                if( $(this).is(':checked') ){
                    if(id_group_t == ""){
                        id_group_t = $(this).attr("id");
                    }else{
                        id_group_t = id_group_t + "_" + $(this).attr("id");
                    }
                }else{
                    if(id_group_f == ""){
                        id_group_f = $(this).attr("id");
                    }else{
                        id_group_f = id_group_f + "_"+$(this).attr("id");
                    }
                }
            });
        }
        var socio_id = $("#id_socio_menus").val();
        var data_  = {
            'socio_id': socio_id,
            'id_group_t':id_group_t,
            'id_group_f':id_group_f
        };
        $.ajax({
            type: "GET",
            url: base_url + 'Administracion/asignar_menu_socio',
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
                    $("#btn_cerrar").click();
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


