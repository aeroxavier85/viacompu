<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdfs extends CI_Controller
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


public  function generar_orden()
{
    $this->load->model('model_pdf');
    $guia= $this->uri->segment(3);    
    $cabecera=$this->model_pdf->orden_cabecera_pdf($guia);
    $detalle=$this->model_pdf->orden_detalle_pdf($guia);

    $this->load->library('Pdf');


    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('ViaCompu');
    $pdf->SetTitle('ORDEN EGRESO');
    //$pdf->SetSubject('Tutorial TCPDF');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '' , '', array(0, 64, 255), array(0, 64, 128));
    $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));


// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//relación utilizada para ajustar la conversión de los píxeles
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------
// establecer el modo de fuente por defecto
    $pdf->setFontSubsetting(true);

// Establecer el tipo de letra
//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
// Helvetica para reducir el tamaño del archivo.
    $pdf->SetFont('times', '', 10, '', true);

// Añadir una página
// Este método tiene varias opciones, consulta la documentación para más información.
    $pdf->AddPage();

// set style for barcode
$style = array(
    'border' => 2,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);


//$pdf->write2DBarcode($guia, 'QRCODE,H', 175, 30, 20, 20, $style, 'N');

// QRCODE,H : QR-CODE Best error correction
//$pdf->write2DBarcode('Orden 0001,Clinica Kennedy Alborada,receptar :ASD-456 / GST-458,pedido: 2 / 3 Lt/ Oxigeno', 'QRCODE,H', 160, 20, 25, 25, $style, 'N');
//$pdf->Text(20, 20, 'ORDEN 001');



//fijar efecto de sombra en el texto
   // $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Establecemos el contenido para imprimir


    //preparamos y maquetamos el contenido a crear
    $html = '';
    $html .= "<style type=text/css>";
    $html .= "th{color: #fff; ; background-color: grey}";
  //  $html .= "td{background-color: #AAC7E3; color: #fff}";
    $html .= "</style>";
    $html .= "<br><br><h2><center>Guia de Egreso de Mercadería </center></h2>";
    $html .= "<h2><center>Operador</center></h2>";
    $html .= "<center><table  border=\"1\" cellspacing=\"0\" cellpadding=\"4\" style=\"border-collapse: collapse\">";
    foreach ($cabecera as $value) {
           
    $html .= "<tr><td style=\"background-color: grey\">Vendedor</td><td >".$value['usuario']."</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Teléfono</td><td>".$value['phone']."</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Email</td><td>".$value['email']."</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Empresa</td><td>".$value['company']."</td></tr>"; 
    $html .= "<tr><td style=\"background-color: grey\">Bodega</td><td>".$value['nombre']."</td></tr>"; 
    $html .= "<tr><td style=\"background-color: grey\">Dirección</td><td>".$value['direccion']."</td></tr>"; 
      } 
    
    $html .= "</table></center>";
     //foreach ($cabecera as $value) {
       // $html .= "<font face='arial'>".$value['nombre']."</font>";
     //   $html .= "<br>Semana  ".$value['id_semanas']." ,  ".$value['periodo'];
       // $html .= "<br>Factura Nro.  ".$value['factura'];
    //}
    $html .= "<h4><center>Detalle de Orden </center></h4>";
    $html .= "<table width='100%' border=\"1\" cellspacing=\"0\" cellpadding=\"4\" style=\"border-collapse: collapse\">";
    $html .= "<tr><th >Cod Barras</th><th >Producto</th><th >Bodega</th><th >Caracteristicas</th><th >Precio Venta(Sin IVA)</th></tr>";
    foreach ($detalle as $value) {
      $html .= "<tr><td>".$value['cod_barras']."</td><td>".$value['producto_completo']."</td><td> ".$value['nombre']."</td><td align='center'> ".$value['detalle']."</td><td align='center'> $ ".$value['precio_venta']."</td></tr>";       
      }   
    $html .= "</table>";

    $html .= "<br><br><br><strong>Observaciones  :</strong>   ".$cabecera[0]['observaciones']."";
    $html .= "<br><br><br>Fecha y hora de Registro  :   ".$detalle[0]['fecha']."";

    
  //  $html .= "<br><br><hr>Para obtener más información de nuestros servicios visitenos en www.viacompu.com  o contactandonos a nuestros telefonos (04)999-9999 , gustosos de servirles<br>";
  

// Imprimimos el texto con writeHTMLCell()
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
    $nombre_archivo = utf8_decode("orden.pdf");
    $pdf->Output($nombre_archivo, 'I');



}


public  function generar_cotizacion()
{
    $this->load->model("model_servicios");              
            
    $id_cotizacion= $this->uri->segment(3);    
    $cabecera=$this->model_servicios->obtener_cab_cotizacion_guia($id_cotizacion);
    $detalle=$this->model_servicios->obtener_det_cotizacion_guia($id_cotizacion);

    $this->load->library('Pdf');


    $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('ViaCompu');
    $pdf->SetTitle('Cotización');
    //$pdf->SetSubject('Tutorial TCPDF');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config_alt.php de libraries/config
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '' , '', array(0, 64, 255), array(0, 64, 128));
    $pdf->setFooterData($tc = array(0, 64, 0), $lc = array(0, 64, 128));


// datos por defecto de cabecera, se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// se pueden modificar en el archivo tcpdf_config.php de libraries/config
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//relación utilizada para ajustar la conversión de los píxeles
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


// ---------------------------------------------------------
// establecer el modo de fuente por defecto
    $pdf->setFontSubsetting(true);

// Establecer el tipo de letra
//Si tienes que imprimir carácteres ASCII estándar, puede utilizar las fuentes básicas como
// Helvetica para reducir el tamaño del archivo.
    $pdf->SetFont('times', '', 10, '', true);

// Añadir una página
// Este método tiene varias opciones, consulta la documentación para más información.
    $pdf->AddPage();

// set style for barcode
$style = array(
    'border' => 2,
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);


//$pdf->write2DBarcode($guia, 'QRCODE,H', 175, 30, 20, 20, $style, 'N');

// QRCODE,H : QR-CODE Best error correction
//$pdf->write2DBarcode('Orden 0001,Clinica Kennedy Alborada,receptar :ASD-456 / GST-458,pedido: 2 / 3 Lt/ Oxigeno', 'QRCODE,H', 160, 20, 25, 25, $style, 'N');
//$pdf->Text(20, 20, 'ORDEN 001');



//fijar efecto de sombra en el texto
   // $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Establecemos el contenido para imprimir


    //preparamos y maquetamos el contenido a crear
    $html = '';
    $html .= "<style type=text/css>";
    $html .= "th{color: #fff; ; background-color: grey}";
  //  $html .= "td{background-color: #AAC7E3; color: #fff}";
    $html .= "</style>";
    $html .= "<br><br><h2><center>Cotización de Mercadería </center></h2>";
   
    $html .= "<center><table  border=\"1\" cellspacing=\"0\" cellpadding=\"4\" style=\"border-collapse: collapse\">";
    foreach ($cabecera as $value) {
           
    $html .= "<tr><td style=\"background-color: grey\">Cotización No.</td><td >".$value['id_cotizacionescab']."</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Vendedor</td><td >".$value['cotizador']."</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Teléfono</td><td>‌‌ 0991196445</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Email</td><td>".$value['email']."</td></tr>";
    $html .= "<tr><td style=\"background-color: grey\">Empresa / Cliente </td><td>".$value['cliente']."</td></tr>"; 
   
      } 
    
    $html .= "</table></center>";
    
    $html .= "<h4><center>Detalle de Orden </center></h4>";
    $html .= "<table width='100%' border=\"1\" cellspacing=\"0\" cellpadding=\"4\" style=\"border-collapse: collapse\">";
    $html .= "<tr><th >Producto</th><th >Detalle</th><th >Cantidad</th><th >Precio Unitario</th><th >Subtotal</th></tr>";
     
     $subtotal=0;
    foreach ($detalle as $value) {
      $html .= "<tr><td>".$value['producto']."</td><td>".$value['detalle']."</td><td>".$value['cantidad']."</td><td> $ ".$value['costo_cotizado']."</td><td align='center'> $ ".$value['subtotal']."</td></tr>";       
      $subtotal = $subtotal + $value['subtotal'];
      }   
      $IVA =  $subtotal * 0.12; 
      $total =  $subtotal + $IVA; 
      $html .= "<tr><td  colspan=\"4\">SUBTOTAL</td><td align='center'> $ ".$subtotal." </td></tr>";       
      $html .= "<tr><td  colspan=\"4\">IVA 12 % </td><td align='center'> $ ".$IVA."</td></tr>";       
      $html .= "<tr><td  colspan=\"4\">TOTAL</td><td align='center'> $ ".$total." </td></tr>";       
     
    $html .= "</table>";

    $html .= "<br><br><br><strong>Observaciones  :</strong>   ".$cabecera[0]['observaciones']."";
    $html .= "<br><br><br>Fecha y hora de Registro  :   ".$cabecera[0]['fecha_cotizacion']."";

    
    $html .= "<br><br><hr><br>
                            Ventas   PBX +593 (4)  6036141 (4) 2566030 | Celular: +593 (9) 91196445 | <br>
                            Junin 422 Y Cordova | Guayaquil - Ecuador | <br>
                            Sucursal Mall El Fortin Subsuelo 1 Local 006A <br>
                            ViaCompu-Store   <br>";
  

// Imprimimos el texto con writeHTMLCell()
    $pdf->writeHTMLCell($w = 0, $h = 0, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);

// ---------------------------------------------------------
// Cerrar el documento PDF y preparamos la salida
// Este método tiene varias opciones, consulte la documentación para más información.
    $nombre_archivo = utf8_decode("cotizacion.pdf");
    $pdf->Output($nombre_archivo, 'I');



}
}


