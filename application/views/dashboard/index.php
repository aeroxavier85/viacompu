<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $title ?>

        </h1>

        <?= $breadcrumbs ?>
    </section>

    

<script>
    window.onload = graficos;

  function graficos(){
    donut_producto_mas_vendido();
    donut_producto_mas_vendido_matriz();
    donut_producto_mas_vendido_fortin();
  
    bar_gastos_ingresos_matriz();
    bar_gastos_ingresos_fortin();

  }

     function bar_gastos_ingresos_matriz() {      
            var bar;          
            var url = base_url + '/dashboard/bar_gastos_ingresos_matriz';
            $.ajax({
                url: url,              
                type: 'post',
                beforeSend: function () {
                    HoldOn.open({
                        theme: "sk-circle",
                        message: "Consultando datos... espere"
                    });
                },
                success: function (respuesta) {
                    HoldOn.close();
                    var obj = JSON.parse(respuesta);
                            console.log(obj) ;   
                            bar = new Morris.Bar({
                            element: 'bar-chart-ingresos-gastos_matriz',                            
                            data: obj.mensaje,
                            barColors: ['#00a65a', '#f78909'],
                            xkey: 'mes',
                            ykeys: ['precio_base', 'ppp'],
                            labels: ['Precio Base', 'PVP'],
                            hideHover: 'auto'
                        });                                       
                  
                },
                error: function (error) {
                    HoldOn.close();
                    mostrar_mensaje(0, "Ocurrio un problema al consultar, intentelo en unos momentos", '');
                }
                ,
                dataType: 'text'
            });
        }

    function bar_gastos_ingresos_fortin() {      
            var bar;          
            var url = base_url + '/dashboard/bar_gastos_ingresos_fortin';
            $.ajax({
                url: url,              
                type: 'post',
                beforeSend: function () {
                    HoldOn.open({
                        theme: "sk-circle",
                        message: "Consultando datos... espere"
                    });
                },
                success: function (respuesta) {
                    HoldOn.close();
                    var obj = JSON.parse(respuesta);
                            console.log(obj) ;   
                            bar = new Morris.Bar({
                            element: 'bar-chart-ingresos-gastos_fortin',                            
                            data: obj.mensaje,
                            barColors: ['#00a65a', '#f78909'],
                            xkey: 'mes',
                            ykeys: ['precio_base', 'ppp'],
                            labels: ['Precio Base', 'PVP'],
                            hideHover: 'auto'
                        });                                       
                  
                },
                error: function (error) {
                    HoldOn.close();
                    mostrar_mensaje(0, "Ocurrio un problema al consultar, intentelo en unos momentos", '');
                }
                ,
                dataType: 'text'
            });
        }
   
    function donut_producto_mas_vendido() {
        var url = base_url + '/dashboard/donut_producto_mas_vendido';
        $.ajax({
            url: url,           
            type: 'post',
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Consultando datos... espere"
                });
            },
            success: function (respuesta) {
                HoldOn.close();
                obj = JSON.parse(respuesta);
                var donut = new Morris.Donut({
                    element: 'pie-mas-vendido',
                    resize: false,
                    data: obj.mensaje[0],
                    hideHover: 'auto'
                });
              },
            error: function (error) {
                HoldOn.close();
                alert("Ocurrio un problema al consultar, intentelo en unos momentos");
            }
            ,
            dataType: 'text'
        })
    };

     function donut_producto_mas_vendido_matriz() {
        var url = base_url + '/dashboard/donut_producto_mas_vendido_matriz';
        $.ajax({
            url: url,           
            type: 'post',
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Consultando datos... espere"
                });
            },
            success: function (respuesta) {
                HoldOn.close();
                obj = JSON.parse(respuesta);
                var donut = new Morris.Donut({
                    element: 'pie-mas-vendido_matriz',
                    resize: false,
                    data: obj.mensaje[0],
                    hideHover: 'auto'
                });
              },
            error: function (error) {
                HoldOn.close();
                alert("Ocurrio un problema al consultar, intentelo en unos momentos");
            }
            ,
            dataType: 'text'
        })
    };

     function donut_producto_mas_vendido_fortin() {
        var url = base_url + '/dashboard/donut_producto_mas_vendido_fortin';
        $.ajax({
            url: url,           
            type: 'post',
            beforeSend: function () {
                HoldOn.open({
                    theme: "sk-circle",
                    message: "Consultando datos... espere"
                });
            },
            success: function (respuesta) {
                HoldOn.close();
                obj = JSON.parse(respuesta);
                var donut = new Morris.Donut({
                    element: 'pie-mas-vendido_fortin',
                    resize: false,
                    data: obj.mensaje[0],
                    hideHover: 'auto'
                });
              },
            error: function (error) {
                HoldOn.close();
                alert("Ocurrio un problema al consultar, intentelo en unos momentos");
            }
            ,
            dataType: 'text'
        })
    };
</script>

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-4 col-6">
            <div class="small-box bg-green">
              <div class="inner">
                <h3><!--<?=$etiquetas[0]['ingresos']?>-->100</h3>

                <p>Costo de Mercaderia<br>
                </p>
              </div>
            
              
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-red">
              <div class="inner">
              <h3><!--<?=$etiquetas[0]['ingresos']?>-->100</h3>


                <p>Ventas</p>
              </div>
              
            </div>
          </div>
          <div class="col-lg-4 col-6">
            <div class="small-box bg-yellow">
              <div class="inner">
               <h3><!--<?=$etiquetas[0]['ingresos']?>-->100</h3>

                <p>Ganancia Neta (Ventas -Costo de Mercaderia ) </p>
              </div>
            
            </div>
          </div>          
        </div>        
      </div>
</section>
<section class="content">
    <div class="row">
      <div class="col-md-4"> 
         <div class="box box-solid box-primary">
            <div class="box-header">
                    <h3 class="box-title">Producto Más Vendido</h3>
              <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" id="panel_2" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
              </div>
            </div>
            <div class="box-body">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="row">
                        <section class="col-lg-12 connectedSortable">
                          <div class="box box-primary" id="loading-example">
                            <div id="pie-mas-vendido"></div>             
                          </div>
                        </section>
                      </div>

                  </div>
               </div>
             </div>
           </div>
      </div>
      <div class="col-md-4"> 
         <div class="box box-solid box-primary">
            <div class="box-header">
                    <h3 class="box-title">Producto Más Vendido-Matriz</h3>
              <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" id="panel_2" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
              </div>
            </div>
            <div class="box-body">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="row">
                        <section class="col-lg-12 connectedSortable">
                          <div class="box box-primary" id="loading-example">
                              <div id="pie-mas-vendido_matriz"></div>       
                          </div>
                        </section>
                      </div>

                  </div>
               </div>
             </div>
           </div>
      </div>
      <div class="col-md-4"> 
         <div class="box box-solid box-primary">
            <div class="box-header">
                    <h3 class="box-title">Producto Más Vendido-El Fortin</h3>
              <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" id="panel_2" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
              </div>
            </div>
            <div class="box-body">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="row">
                        <section class="col-lg-12 connectedSortable">
                          <div class="box box-primary" id="loading-example">
                              <div id="pie-mas-vendido_fortin"></div>       
                          </div>
                        </section>
                      </div>

                  </div>
               </div>
             </div>
           </div>
      </div>
     
      
    </div>
    <div class="row">
        <div class="col-md-6">            
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">Matriz</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" id="panel_2" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                      <div class="row">
                        <div class="col-sm-12">                            
                            <div class="row">                              
                                <section class="col-lg-12 connectedSortable">                                   
                                    <div class="box box-primary" id="loading-example">                                      
                                      <div id="bar-chart-ingresos-gastos_matriz"></div>     
                                    </div>
                                </section>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">            
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">El Fortin</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-primary btn-sm" id="panel_2" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                      <div class="row">
                        <div class="col-sm-12">                            
                            <div class="row">                              
                                <section class="col-lg-12 connectedSortable">                                   
                                    <div class="box box-primary" id="loading-example">                                      
                                      <div id="bar-chart-ingresos-gastos_fortin"></div>     
                                    </div>
                                </section>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        </div>
       
    </div> 
   
</section>
  
</aside><!-- /.right-side -->
