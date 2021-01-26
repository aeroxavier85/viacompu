<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class control_cotizaciones extends CI_Controller
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
    public function listar_cotizaciones()
    {
            if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Cotizaciones Generadas";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Cotizaciones', '/Cotizaciones');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");   
          

            $data['empresas']=$this->model_servicios->obtener_datos_empresas();
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();
            $data['listar_cotizaciones']=$this->model_servicios->listar_cotizaciones();
            $data['listar_clientes_cotizar']=$this->model_servicios->obtener_clientes_cotizar();
          
         
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_cotizaciones/listar_cotizaciones.php', $data, true);
            $this->template->render();
    }


 public function continuar_cotizacion()
    {
             if (!$this->ion_auth->logged_in()) {
                // redirect them to the login page
                redirect('autenticacion/login', 'refresh');
            }

            $data['title'] = "Cotizaciones";
    // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Salida', '/Salida/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

    // output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
   
            $this->load->model("model_servicios");           
            $id_cotizacion=$this->input->get("id_cotizacion");  
            $data['categorias']=$this->model_servicios->obtener_datos_categoria_productos();
            $data['marcas']=$this->model_servicios->obtener_datos_marca_productos();

            $data['productos']=$this->model_servicios->obtener_lista_productos_para_ingreso();
            $data['registro_cotizacion_parcial_cab']= $this->model_servicios->obtener_cab_cotizacion_guia($id_cotizacion);
            $data['registro_cotizacion_parcial']= $this->model_servicios->obtener_det_cotizacion_guia($id_cotizacion);
           

            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'view_cotizaciones/view_cotizaciones', $data, true);
            $this->template->render();
    }

 function mail_cotizaciones(){
                     
             $this->load->model("model_servicios");              
             $id_cotizacion= $this->uri->segment(3);
             $data['registro_cotizacion_parcial_cab']= $this->model_servicios->obtener_cab_cotizacion_guia($id_cotizacion);
             $data['registro_cotizacion_parcial']= $this->model_servicios->obtener_det_cotizacion_guia($id_cotizacion);
             
           
            if ($this->config->item("envio_email")) {
                $this->load->library("email");
                $this->email->from($this->config->item("correo_admin"));
                $this->email->to( $data['registro_cotizacion_parcial_cab'][0]['email']);
                $this->email->subject(" Cotizacion - ViaCompuStore ");
                $message = $this->load->view('templates_mail/cotizaciones', $data, true);
                $this->email->message($message);
                $this->email->send();}
    
            redirect('/control_cotizaciones/listar_cotizaciones');
           
}
  
}


