<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicios extends CI_Controller
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *        http://example.com/index.php/welcome
     *    - or -
     *        http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */


    function __construct()
    {
        parent::__construct();
        //$this->load->model('medicamento');

        $this->lang->load('auth');

        //$this->lang->load('backend', 'es_EC');
        //$this->lang->load('backend','en_US'); //cambiar de idioma

        //$this->template->set_template('backend'); //cambiar plantilla si existieran mas configuradas

        // Librerias y modelos para menu dinamico
        $this->load->model("menu_model", "menu");
        $items = $this->menu->all();

        $this->load->library("multi_menu");
        $this->multi_menu->set_items($items);


        //a�adimos los archivos css que necesitemoa

        $this->template->add_css('assets/css/bootstrap.min.css');

        $this->template->add_css('assets/css/font-awesome.min.css');

        $this->template->add_css('assets/css/ionicons.min.css');

        $this->template->add_css('assets/css/datatables/dataTables.bootstrap.css');

        $this->template->add_css('assets/css/AdminLTE.css');

        $this->template->add_css('assets/css/estilos.css');

        $this->template->add_css('assets/css/jquery.dataTables.min.css');

        //a�adimos los archivos js que necesitemoa
        //	$this->template->add_js('assets/js/jquery-3.1.0.min.js');


        $data['conectado'] = $this->ion_auth->get_user();

        //la secci?n header ser? el archivo views/registro/header_template
        $this->template->write_view('header', 'backend/header_template',$data);
        //desde aqu? tambi?n podemos setear el t?tulo
        $this->template->write('title', 'Nuestro t?tulo', true);

        $this->template->write_view('sidebar', 'backend/sidebar_template',$data);
        //la secci�n footer ser� el archivo views/registro/footer_template
        $this->template->write_view('footer', 'backend/footer_template');
        //con el m�todo render podemos renderizar y hacer que se visualice la template

    }

    public function index()
    {

    }
//******************************************
    //Llamado a Vistas
//******************************************
    public function registro_empresa()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Registro de Empresas";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Servicios', '/registro/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();

            $this->load->model('model_servicios');           
            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
           // $data['ciudades']=$this->model_servicios->obtener_ciudades();

            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'servicios/registro_empresas', $data, true);
            $this->template->render();
    }

    public function registro_bodega()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Registro de Bodegas";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Servicios', '/registro/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();

            $this->load->model('model_servicios');           
            $data['bodegas']=$this->model_servicios->obtener_datos_bodegas();
           // $data['ciudades']=$this->model_servicios->obtener_ciudades();

            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'servicios/registro_bodegas', $data, true);
            $this->template->render();
    }


    public function obtener_empresa_por_id()
    {
        $this->load->model('model_servicios');
         $valor=$this->input->post("valor");
      
        $str_json=$this->model_servicios->obtener_datos_empresas_por_id($valor);
        echo json_encode($str_json);
    }


  
    public function registro_empresas_nuevas(){
        $this->load->model('model_servicios');
           
        $nombre_comercial=$this->input->post("nombre_comercial");
        $contacto=$this->input->post("contacto");
        $correo=$this->input->post("correo");
        $telefono=$this->input->post("telefono");
        $direccion=$this->input->post("direccion");
        $ciudad=$this->input->post("ciudad");
        $detalles=$this->input->post("detalles");
                           
        $str_json=$this->model_servicios->guardar_empresa($nombre_comercial,$contacto,$correo,$telefono,$direccion,$ciudad,$detalles);

        echo json_encode($str_json);
    }

  



public function obtener_producto_marcas(){
    $this->load->model('model_servicios');
        $producto=$this->input->post("producto");           
        $str_json=$this->model_servicios->obtener_producto_marcas_consula($producto);
        echo json_encode($str_json);
}

public function obtener_modelo_marcas(){
    $this->load->model('model_servicios');
        $categoria=$this->input->post("categoria");           
        $marca=$this->input->post("marca"); 
        $str_json=$this->model_servicios->obtener_modelo_marcas_consulta($categoria,$marca);
        echo json_encode($str_json);
}

public function guardar_registro_bodega(){
    
     $this->load->model('model_servicios');
    
     $empresa=$this->input->post("empresa");
     $bodega=$this->input->post("bodega");
     $producto=$this->input->post("producto");    
     $cod_barras=$this->input->post("cod_barras");
     $guia=$this->input->post("guia");
     $referencia=$this->input->post("referencia");
     $estado=$this->input->post("estado");   
     $str_json=$this->model_servicios->guardar_registro_bodega_ingreso($empresa,$bodega,$producto,$cod_barras ,$guia ,  
        $referencia,$estado );
     echo json_encode($str_json);
}

public function guardar_registro_bodega_egreso(){
    
     $this->load->model('model_servicios');
    
     $empresa=$this->input->post("empresa");
     $bodega=$this->input->post("bodega");
     $producto=$this->input->post("producto"); 
      $estado=$this->input->post("estado");    
     $cod_barras=$this->input->post("cod_barras");
     $guia=$this->input->post("guia");     
     $ppp=$this->input->post("ppp"); 
      
     $str_json=$this->model_servicios->guardar_registro_bodega_egreso($empresa,$bodega,$producto,$cod_barras ,$guia ,  
        $estado,$ppp );
     echo json_encode($str_json);
}

public function guardar_registro_cotizacion(){
    
     $this->load->model('model_servicios');
        
     $id_cotizacion=$this->input->post("id_cotizacion");
     $id_producto=$this->input->post("id_producto");
     $costo_cotizado=$this->input->post("costo_cotizado");
     $cantidad=$this->input->post("cantidad"); 
     $subtotal=$this->input->post("subtotal");    
          
     $str_json=$this->model_servicios->guardar_registro_cotizacion($id_cotizacion,$id_producto,$costo_cotizado,$cantidad,$subtotal);
     echo json_encode($str_json);
}

public function guardar_registro_movimiento_bodegas(){
    
     $this->load->model('model_servicios');    
     $cod_barras=$this->input->post("cod_barras");
     $guia=$this->input->post("guia");    
     $estado=$this->input->post("estado");    
     $str_json=$this->model_servicios->guardar_registro_bodega_movimiento_interno($cod_barras ,$guia,$estado);
     echo json_encode($str_json);
}

public function abrir_guia_ingreso(){
    $this->load->model('model_servicios');
     $empresa=$this->input->post("empresa");
     $bodega=$this->input->post("bodega");
     $str_json=$this->model_servicios->abrir_guia_ingreso($empresa,$bodega);
     echo json_encode($str_json);
}

public function abrir_guia_egreso(){
    $this->load->model('model_servicios');
     $empresa=$this->input->post("empresa");
     $bodega=$this->input->post("bodega");
     $str_json=$this->model_servicios->abrir_guia_egreso($empresa,$bodega);
     echo json_encode($str_json);
}

public function abrir_guia_cotizacion(){
    $this->load->model('model_servicios');
     $cliente=$this->input->post("cliente");
     $email=$this->input->post("email");
     $str_json=$this->model_servicios->abrir_guia_cotizacion($cliente,$email);
     echo json_encode($str_json);
}

public function abrir_guia_movimiento_bodegas(){
    $this->load->model('model_servicios');
     $empresa=$this->input->post("empresa");
     $bodega_origen=$this->input->post("bodega_origen");
     $bodega_destino=$this->input->post("bodega_destino");
     $str_json=$this->model_servicios->abrir_guia_movimiento_bodegas($empresa,$bodega_origen,$bodega_destino);
     echo json_encode($str_json);
}

public function cerrar_guia_ingreso(){
    $this->load->model('model_servicios');
    $empresa=$this->input->post("empresa");
    $guia=$this->input->post("guia");
    $bodega=$this->input->post("bodega");
    $str_json=$this->model_servicios->cerrar_guia_ingreso($empresa,$guia,$bodega);
    echo json_encode($str_json);
}

public function cerrar_guia_egreso(){
    $this->load->model('model_servicios');
    $empresa=$this->input->post("empresa");
    $guia=$this->input->post("guia");
    $bodega=$this->input->post("bodega");
    $observaciones=$this->input->post("observaciones");
    
    $str_json=$this->model_servicios->cerrar_guia_egreso($empresa,$guia,$bodega,$observaciones);
    echo json_encode($str_json);
}

public function cerrar_guia_cotizacion(){
    $this->load->model('model_servicios');
   
    $guia=$this->input->post("guia");
     $observaciones=$this->input->post("observaciones");
    
    $str_json=$this->model_servicios->cerrar_guia_cotizacion($guia,$observaciones);
    echo json_encode($str_json);
}


public function cerrar_guia_movimiento(){
    $this->db_inventario = $this->load->database('autenticacion', TRUE);
     $guia=$this->input->post("guia");
     $sql = "update inventario.tbl_movimientocab set  tipo ='MC' , tipo_final='T' where id_movimientocab=?";   
    if($this->db_inventario->query($sql, [$guia]) ){
        $str_json='1';
        echo json_encode($str_json);  
    }  else {
         $str_json='0';
        echo json_encode($str_json);  
    }
}

public  function valida_codigos_repetidos(){
  
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $cod_barras=$this->input->post("cod_barras");
    //$guia=$this->input->post("guia");

    $sql = "select c.tipo,c.id_ingresocab from inventario.tbl_ingresocab c 
            inner join inventario.tbl_ingresodet d on c.id_ingresocab=d.id_ingresocab
            where d.estado='A' and d.cod_barras=?  ;";   
    $result = $this->db_inventario->query($sql, [$cod_barras])->result_array();   

            if (count($result)>0){   
              
               if ($result[0]['tipo']=='IA') {
                    $str_json='Este registro ya se encuentra en la orden de ingreso No. '.$result[0]['id_ingresocab']. ' (Duplicado) y no ha sido finalizada, favor finalice el ingreso en la orden indicada.';
                     echo json_encode($str_json); 
                     //registro encontrado en unmovimiento de nigreso inconcluso
               }else{
                     $sql2 = "SELECT * FROM inventario.tbl_registro_movimiento where cod_barras=? and estado='A' ;";   
                     $result2 = $this->db_inventario->query($sql2, [$cod_barras])->result();  
                     if (count($result2)>0){   
                       $str_json='Este producto con codigo '.$cod_barras.' ya se encuentra en el inventario';
                       echo json_encode($str_json);                            
                       //registro duplicado en transacciones registradas
                         }
               }
              
            }
            else{
               $str_json=0;
               echo json_encode($str_json);                   
               //no existe el registro
                }
}

public  function valida_codigos_repetidos_egresos(){
  
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $cod_barras=$this->input->post("cod_barras");
     $sql = "select c.tipo,c.id_egresocab from inventario.tbl_egresocab c 
            inner join inventario.tbl_egresodet d on c.id_egresocab=d.id_egresocab
            where d.estado='A' and d.cod_barras=?  ;";
    $result = $this->db_inventario->query($sql, [$cod_barras])->result_array();   

            if (count($result)>0){   
                if ($result[0]['tipo']=='EA') {
                   $str_json='Este registro ya se encuentra en la orden de Egreso No. '.$result[0]['id_egresocab']. ' (Duplicado) y no ha sido finalizada, favor eliminar la orden de egreso para liberar el producto.';
                     echo json_encode($str_json);     
                }else{
                    $sql2 = "SELECT * FROM inventario.tbl_registro_movimiento where cod_barras=? and estado='A' and tipo='E' ;";   
                     $result2 = $this->db_inventario->query($sql2, [$cod_barras])->result();  
                     if (count($result2)>0){   
                       $str_json='Este producto con codigo '.$cod_barras.' ya NO se encuentra en el inventario';
                       echo json_encode($str_json);                            
                       //registro duplicado en transacciones registradas
                         }    
                }
            }
            else{
               $str_json=0;
               echo json_encode($str_json);                   
               //no existe el registro
                }
}
 

public  function valida_codigos_repetidos_movimientos_internos(){
  
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $cod_barras=$this->input->post("cod_barras");
    $guia=$this->input->post("guia");
    $sql = "SELECT * FROM inventario.tbl_movimientodet where cod_barras =? and estado='A' and id_movimientocab=?";   
    $result = $this->db_inventario->query($sql, [$cod_barras,$guia])->result();   

            if (count($result)>0){   
               $str_json=1;
               echo json_encode($str_json);                            
               //registro duplicado
            }
            else{
               $str_json=0;
               echo json_encode($str_json);                   
               //no existe el registro
                }
}



 public function eliminar_registro_ingreso(){
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $id_registro=$this->input->post("id_registro");
    $sql = "update inventario.tbl_ingresodet set  estado ='I' where id_ingresodet=?";   
    if($this->db_inventario->query($sql, [$id_registro]) ){
        $sql2 = "SELECT id_ingresocab FROM inventario.tbl_ingresodet where id_ingresodet=?";   
        $result = $this->db_inventario->query($sql2, [$id_registro])->result_array();

       $id=$result[0]['id_ingresocab'];
       
        $sql2="call inventario.sp_ObtenerDetalleIngresos('".$id."');";   
        $result2 = $this->db_inventario->query($sql2, [$result])->result();          
        echo json_encode($result2);  


    }  else {
         $str_json='err';
        echo json_encode($str_json);  
    }

 }


 public function eliminar_registro_cotizacion(){
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $id_registro=$this->input->post("id_registro");
    $sql = "update inventario.tbl_cotizacionesdet set  estado ='I' where id_cotizacionesdet=?";   
    if($this->db_inventario->query($sql, [$id_registro]) ){
        $sql2 = "SELECT id_cotizacionescab FROM inventario.tbl_cotizacionesdet where id_cotizacionesdet=?";   
        $result = $this->db_inventario->query($sql2, [$id_registro])->result_array();

       $id=$result[0]['id_cotizacionescab'];
       
        $sql2="select  concat(c.descripcion,' - ',m.descripcion,' - ',p.id_modelo)as producto,cot.*
                    from inventario.tbl_producto p
                    inner join inventario.tbl_cotizacionesdet cot on p.id_producto=cot.id_producto
                    inner join inventario.tbl_categoria c on p.id_categoria=c.id_categoria
                    inner join inventario.tbl_marca m on p.id_marca=m.id_marca
                    where cot.estado='A' and cot.id_cotizacionescab='".$id."'";   
        $result2 = $this->db_inventario->query($sql2, [$result])->result();          
        echo json_encode($result2);  


    }  else {
         $str_json='err';
        echo json_encode($str_json);  
    }

 }


 public function eliminar_registro_ingreso_egreso(){
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $id_registro=$this->input->post("id_registro");
    $sql = "update inventario.tbl_egresodet set  estado ='I' where id_egresodet=?";   
    if($this->db_inventario->query($sql, [$id_registro]) ){
        $sql2 = "SELECT id_egresocab FROM inventario.tbl_egresodet where id_egresodet=?";   
        $result = $this->db_inventario->query($sql2, [$id_registro])->result_array();

       $id=$result[0]['id_egresocab'];
       // var_dump($id);die;
        $sql2="call inventario.sp_ObtenerDetalleEgresos('".$id."');";   

        $result2 = $this->db_inventario->query($sql2, [$result])->result();          
        echo json_encode($result2);  


    }  else {
         $str_json='err';
        echo json_encode($str_json);  
    }

 }

 public function eliminar_registro_ingreso_interno(){
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $id_registro=$this->input->post("id_registro");
    $sql = "update inventario.tbl_movimientodet set  estado ='I' where id_movimientodet=?";   
    if($this->db_inventario->query($sql, [$id_registro]) ){
        $sql2 = "SELECT id_movimientocab FROM inventario.tbl_movimientodet where id_movimientodet=?";   
        $result = $this->db_inventario->query($sql2, [$id_registro])->result_array();

       $id=$result[0]['id_movimientocab'];
    //   var_dump($id);die;
        $sql2="call inventario.sp_ObtenerDetalleMovimientos('".$id."');";  

        $result2 = $this->db_inventario->query($sql2)->result();          
        echo json_encode($result2);  


    }  else {
         $str_json='err';
        echo json_encode($str_json);  
    }

 }


    public function continuar_guia_movimiento_interno()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Registro de Movimiento de Mercaderias Entre Bodegas";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('ingresos', '/Ingresos/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");   
        //    $this->load->model("model_componentes");   
            $id_registro=$this->input->get("id_registro");                
            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();
            $data['registro_parcial_cab']= $this->model_servicios->obtener_cab_ingreso_guia($id_registro);
            $data['registro_parcial']= $this->model_servicios->obtener_det_ingreso_guia($id_registro);
                       

            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_ingresos/view_movimientos_bodegas_editar', $data, true);
            $this->template->render();
    }





    public function buscar_codigo_barra(){
    $this->load->model('model_servicios');
    
     $bodega_origen=$this->input->post("bodega_origen");
     $cod_barras=$this->input->post("cod_barras");
     $str_json=$this->model_servicios->buscar_codigo_barra($cod_barras,$bodega_origen);
     echo json_encode($str_json);
    }


    public  function actualizar_producto(){
        $id_producto = $this->input->post('cod_producto_m');
        $descripcion = $this->input->post('detalle_m');       
        $precio = $this->input->post('precio_m'); 
           $costo_minimo = $this->input->post('costo_minimo_m'); 
           $costo_standar = $this->input->post('costo_standar_m'); 
           $costo_maximo = $this->input->post('costo_maximo_m');    

        $imagen_adjunta =$_FILES["imagen-adjunta_m"]["type"];;
      
        if ($imagen_adjunta==''){  
      //   var_dump(  $id_producto .' '.$descripcion.' '.$precio.' '.$imagen_adjunta.'AQUIIII');
             $data1 = array(
                        'id_producto' => $id_producto,                        
                        'descripcion' => $descripcion,                        
                        'precio' => $precio,
                        'costo_minimo' => $costo_minimo,
                        'costo_standar' => $costo_standar,
                        'costo_maximo' => $costo_maximo                                            
                    );                   
                      $this->load->model("model_servicios");
                     if($this->model_servicios->actualizar_producto_data_sin_imagen($data1)){
                        echo json_encode('Datos actualizados');
                     } else { echo json_decode('No se pudo actualizar los datos');}
        }
        else
        {      
                $nombre_archivo = $_FILES["imagen-adjunta_m"]["name"];
                $tipo_archivo = $_FILES["imagen-adjunta_m"]["type"];
                $tamano_archivo = $_FILES["imagen-adjunta_m"]["size"];
                $tmp_archivo = $_FILES["imagen-adjunta_m"]["tmp_name"];
                if ($tmp_archivo != ""  && $tamano_archivo <= $this->config->item("tamanio_archivos_permitido") && $tipo_archivo == $this->config->item("tipo_archivos_permitido") ||  $tipo_archivo == $this->config->item("tipo_archivos_permitido2")) {

                    $upload_folder = $this->config->item("directorio");
                    $upload_data = $this->config->item("directorio_corto");

                    $nombreCarpeta = $id_producto;
                    $archivador = $upload_folder . "/" . $nombreCarpeta;
                   if (!file_exists($archivador)) {                
                        mkdir($archivador, 0777, true);
                    } 
                    $nombre_archivo = $id_producto . ".JPEG";
                    $rutaArchivo = $archivador . "/" . $nombre_archivo;
                    $rutaArchivo_corto =  $upload_data . "/" . $nombreCarpeta. "/" . $nombre_archivo;

                    if (move_uploaded_file($tmp_archivo, $rutaArchivo)) {             
                            $data = array(                               
                                'id_producto' => $id_producto,                                                        
                                'ruta' => $rutaArchivo_corto,                                                
                                'descripcion' => $descripcion,                        
                                'precio' => $precio,    
                                'costo_minimo' => $costo_minimo,
                                'costo_standar' => $costo_standar,
                                'costo_maximo' => $costo_maximo
                                );
                   
                            $this->load->model("model_servicios");
                            if($this->model_servicios->actualizar_producto_data($data)){
                                echo json_encode('Datos Actualizados Correctamente');
                            } else { echo json_decode('No se pudo actualizar los datos');}
                    } else  {  echo json_encode('No se pudo mover datos del producto');   } 
                }else{ echo json_encode('Tipo de archivo equivocado') ;}              
               
    }        
}

    public  function crear_producto_nuevo(){
        $producto = $this->input->post('cmb_tipo_producto');
        $marca = $this->input->post('cmb_tipo_marca');       
        $modelo = $this->input->post('modelo');
        $detalle = $this->input->post('detalle');
        $precio = $this->input->post('precio');
           $costo_minimo = $this->input->post('costo_minimo');
           $costo_standar = $this->input->post('costo_standar');
           $costo_maximo = $this->input->post('costo_maximo');
        $imagen_adjunta = $_FILES["imagen-adjunta"]["type"];
        
        if ($imagen_adjunta==''){
        
                $rutaArchivo_corto='../assets/images/no-imagen.jpg';
                $data = array(
                        'producto' => $producto,                        
                        'marca' => $marca, 
                        'modelo' => $modelo, 
                        'detalle' => $detalle,                        
                        'precio' => $precio,                        
                        'ruta' => $rutaArchivo_corto,
                        'costo_minimo' => $costo_minimo,
                        'costo_standar' => $costo_standar,
                        'costo_maximo' => $costo_maximo
                    );
                $this->load->model("model_servicios");
                $str_json=$this->model_servicios->crear_producto_data($data);
                echo json_encode($str_json);
        }else{
                $nombre_archivo = $_FILES["imagen-adjunta"]["name"];
                $tipo_archivo = $_FILES["imagen-adjunta"]["type"];
                $tamano_archivo = $_FILES["imagen-adjunta"]["size"];
                $tmp_archivo = $_FILES["imagen-adjunta"]["tmp_name"];
                
                $rutaArchivo_corto='../assets/images/no-imagen.jpg';
                $data = array(
                        'producto' => $producto,                        
                        'marca' => $marca, 
                        'modelo' => $modelo, 
                        'detalle' => $detalle,                        
                        'precio' => $precio,     
                        'costo_minimo' => $costo_minimo,
                        'costo_standar' => $costo_standar,
                        'costo_maximo' => $costo_maximo,                   
                        'ruta' => $rutaArchivo_corto,
                    );
                $this->load->model("model_servicios");
                $id_producto=$this->model_servicios->crear_producto_data($data);
               

                if ($tmp_archivo != ""  && $tamano_archivo <= $this->config->item("tamanio_archivos_permitido") && $tipo_archivo == $this->config->item("tipo_archivos_permitido") ||  $tipo_archivo == $this->config->item("tipo_archivos_permitido2")) {

                    $upload_folder = $this->config->item("directorio");
                    $upload_data = $this->config->item("directorio_corto");

                    $nombreCarpeta = $id_producto;
                    $archivador = $upload_folder . "/" . $nombreCarpeta;
                   if (!file_exists($archivador)) {                
                        mkdir($archivador, 0777, true);
                    } 
                    $nombre_archivo = $id_producto . ".JPEG";
                    $rutaArchivo = $archivador . "/" . $nombre_archivo;
                    $rutaArchivo_corto =  $upload_data . "/" . $nombreCarpeta. "/" . $nombre_archivo;

                    if (move_uploaded_file($tmp_archivo, $rutaArchivo)) {             
                            $data = array(                               
                                'id_producto' => $id_producto,                                                        
                                'ruta' => $rutaArchivo_corto,
                                );
                   
                            $this->load->model("model_servicios");
                            if($this->model_servicios->actualizar_imagen($data)){
                                echo json_encode('Datos Guardados');
                            } else { echo json_decode('No se pudo actualizar los datos');}
                    } else  {  echo json_encode('No se pudo mover datos del producto');   } 
                }else{ echo json_encode('Tipo de archivo equivocado') ;}
        }                       
    }   

public function obtener_producto_por_id(){
    $this->load->model('model_servicios');
    
     $id_producto=$this->input->post("id_producto");    
     $str_json=$this->model_servicios->obtener_producto_por_id($id_producto);
     echo json_encode($str_json);
}

public function obtener_producto_por_id_para_ingreso(){
    $this->load->model('model_servicios');
    
     $id_producto=$this->input->post("id_producto");    
     $str_json=$this->model_servicios->obtener_producto_por_id_para_ingreso($id_producto);
     echo json_encode($str_json);
}

public function obtener_producto_por_id_para_cotizar(){
    $this->load->model('model_servicios');
    
     $id_producto=$this->input->post("id_producto");    
     $str_json=$this->model_servicios->obtener_producto_por_id_para_cotizar($id_producto);
     echo json_encode($str_json);
}

public function guardar_registro_empresa(){
    $this->load->model('model_servicios');
    
     $nombre_comercial=$this->input->post("nombre_comercial");    
     $contacto=$this->input->post("contacto"); 
     $telefono=$this->input->post("telefono"); 
     $correo=$this->input->post("correo"); 
     $direccion=$this->input->post("direccion"); 
     $ciudad=$this->input->post("ciudad"); 
     $detalles=$this->input->post("detalles"); 

     $str_json=$this->model_servicios->guardar_registro_empresa($nombre_comercial,$contacto,$telefono,$correo,$direccion,$ciudad,$detalles);
     echo json_encode($str_json);

}


public  function obtener_email_cliente(){
  
    $this->db_inventario = $this->load->database('autenticacion', TRUE);    
    $cliente=$this->input->post("cliente");
    $sql = "SELECT * FROM inventario.tbl_cotizacionescab where cliente=?  ;";
    $result = $this->db_inventario->query($sql, [$cliente])->result_array();   
    echo json_encode($result);
                      
}
 
}



