<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class control_egresos extends CI_Controller
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
        //  $this->template->add_js('assets/js/jquery-3.1.0.min.js');


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
    public function listar_egreso_bodegas()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Listado de Movimientos de Egreso de Mercaderia";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Egresos', '/Egresos/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");   
          

            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();
            $data['lista_ingresos']=$this->model_servicios->listar_guias_egreso();
         
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_egresos/listar_movimientos_egreso.php', $data, true);
            $this->template->render();
    }

public function movimientos_egresos()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Salida de Mercaderias";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Salida', '/Salida/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");   

            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();
            $data['productos']=$this->model_servicios->obtener_lista_productos_para_ingreso();


            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_egresos/view_egresos', $data, true);
            $this->template->render();
    }



public function listar_movimientos_bodegas()
 {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Movimientos";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('ingresos', '/Ingresos/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");   

            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();
            $data['lista_movimientos']=$this->model_servicios->listar_guias_movimientos_internos();

            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_ingresos/listar_movimientos_bodegas', $data, true);
            $this->template->render();
    }

public function movimientos_entre_bodegas()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Movimiento de Mercaderias";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('ingresos', '/Ingresos/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");   

            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();


            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_ingresos/view_movimientos_bodegas', $data, true);
            $this->template->render();
    }


    public function nuevo_ingreso()
    {
        
        $this->load->model("model_ingresos");
           
        $ingresos=$this->input->post("ingresos");
       // echo($ingresos);
      //  die;

        $str_json=$this->model_ingresos->guardar_ingreso($ingresos);

        echo json_encode($str_json);
    }


 public function continuar_guia()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Ingreso de Mercaderias";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('ingresos', '/Ingresos/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");         
            $id_registro=$this->input->get("id_registro");                
            $data['productos']=$this->model_servicios->obtener_lista_productos_para_ingreso();
            $data['registro_parcial_cab']= $this->model_servicios->obtener_cab_ingreso_guia($id_registro);
            $data['registro_parcial']= $this->model_servicios->obtener_det_ingreso_guia($id_registro);
         
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_ingresos/view_ingresos_editar', $data, true);
            $this->template->render();
    }


    public function obtener_ingresos_por_criterios()
    {
        $this->load->model("model_ingresos");
        $id_empresa=$this->input->post("id_empresa");           
        $fecha_ini=$this->input->post("fecha_ini");   
        $fecha_fin=$this->input->post("fecha_fin");   
        $str_json=$this->model_ingresos->obtener_ingresos_por_criterios($id_empresa,$fecha_ini,$fecha_fin);
        echo json_encode($str_json);
    }

    public function eliminar_guia_egreso(){
         $this->load->model("model_servicios");
        $id_egresocab=$this->input->post("id_egresocab");           
         
        $str_json=$this->model_servicios->eliminar_guia_egreso($id_egresocab);
        echo json_encode($str_json);
    }
}


