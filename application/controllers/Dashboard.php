<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller
{

    function __construct()
    {
        parent::__construct();

       // $this->load->model('medicamento');

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

        //a�adimos los archivos js que necesitemoa
        //  $this->template->add_js('assets/js/jquery-3.1.0.min.js');


        $data['conectado'] = $this->ion_auth->get_user();

        //la secci?n header ser? el archivo views/registro/header_template
        $this->template->write_view('header', 'backend/header_template', $data);
        //desde aqu? tambi?n podemos setear el t?tulo


        $this->template->write_view('sidebar', 'backend/sidebar_template', $data);
        //la sección footer será el archivo views/registro/footer_template
        $this->template->write_view('footer', 'backend/footer_template');
        //con el método render podemos renderizar y hacer que se visualice la template


    }




function donut_producto_mas_vendido(){
            $this->load->model("Model_dashboard");
            $data = $this->Model_dashboard->donut_producto_mas_vendido();
            $array = [];
            $array[0]  = $data;
            $respuesta = ['error' => 0, 'mensaje' => $array];            
          //  $rs['data'] = $this->Dashboard_model->consulta_productividad( $desde, $hasta);                 
             echo json_encode($respuesta);
}

function donut_producto_mas_vendido_matriz(){
            $this->load->model("Model_dashboard");
            $data = $this->Model_dashboard->donut_producto_mas_vendido_matriz();
            $array = [];
            $array[0]  = $data;
            $respuesta = ['error' => 0, 'mensaje' => $array];            
          //  $rs['data'] = $this->Dashboard_model->consulta_productividad( $desde, $hasta);                 
             echo json_encode($respuesta);
}

function donut_producto_mas_vendido_fortin(){
            $this->load->model("Model_dashboard");
            $data = $this->Model_dashboard->donut_producto_mas_vendido_fortin();
            $array = [];
            $array[0]  = $data;
            $respuesta = ['error' => 0, 'mensaje' => $array];            
          //  $rs['data'] = $this->Dashboard_model->consulta_productividad( $desde, $hasta);                 
             echo json_encode($respuesta);
}

function bar_gastos_ingresos_matriz(){
            $this->load->model("Model_dashboard");
            $data = $this->Model_dashboard->bar_gastos_ingresos_matriz();    
            $respuesta = ['error' => 0, 'mensaje' => $data];            
            echo json_encode($respuesta);
}

function bar_gastos_ingresos_fortin(){
            $this->load->model("Model_dashboard");
            $data = $this->Model_dashboard->bar_gastos_ingresos_fortin();    
            $respuesta = ['error' => 0, 'mensaje' => $data];            
            echo json_encode($respuesta);
}




}
