<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bodegas extends CI_Controller
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
            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['ciudades']=$this->model_servicios->obtener_ciudades();
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'servicios/registro_bodegas', $data, true);
            $this->template->render();
    }

 
    public function obtener_bodega_por_id()
    {
        $this->load->model('model_servicios');
         $valor=$this->input->post("valor");
      
        $str_json=$this->model_servicios->obtener_datos_bodega_por_id($valor);
        echo json_encode($str_json);
    }

    public function eliminar_bodega()
    {
        $this->load->model('model_servicios');
         $id_bodega=$this->input->post("id_bodega");
      
        $str_json=$this->model_servicios->eliminar_bodega_empresa($id_bodega);
        echo json_encode($str_json);
    }


    public function crear_bodega_nueva(){
        $this->load->model('model_servicios');
        
         $empresa=$this->input->post("empresa");    
         $nom_bodega=$this->input->post("nom_bodega"); 
         $telefono=$this->input->post("telefono"); 
         $correo=$this->input->post("correo"); 
         $direccion=$this->input->post("direccion"); 
         $ciudad=$this->input->post("ciudad"); 
         $detalles=$this->input->post("detalles"); 

         $str_json=$this->model_servicios->crear_bodega_nueva($empresa,$nom_bodega,$telefono,$correo,$direccion,$ciudad,$detalles);
         echo json_encode($str_json);

}

}



