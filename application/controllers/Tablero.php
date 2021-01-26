<?php
defined('BASEPATH') OR exit( 'No direct script access allowed' );

class Tablero extends CI_Controller
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

	public function __construct()
	{
		parent::__construct();

		$this->lang->load('backend', 'es_EC');
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

        $this->template->add_css('assets/css/morris/morris.css');

        $this->template->add_css('assets/css/jvectormap/jquery-jvectormap-1.2.2.css');

        $this->template->add_css('assets/css/fullcalendar/fullcalendar.css');

        $this->template->add_css('assets/css/daterangepicker/daterangepicker-bs3.css');

        $this->template->add_css('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');

        $this->template->add_css('assets/css/AdminLTE.css');

        $this->template->add_css('assets/css/estilos.css');

		//a�adimos los archivos js que necesitemoa
		//	$this->template->add_js('assets/js/jquery-3.1.0.min.js');

	}


	function index()
	{

		if (!$this->ion_auth->logged_in())
		{
			// redirect them to the login page
			redirect('/autenticacion/login', 'refresh');
		}
		/*elseif (!$this->ion_auth->have_permision('dashboard')) // remove this elseif if you want to enable this for non-admins
		{

			// redirect them to the home page because they must be an administrator to view this
			return show_error('No tiene permisos para ver este recurso.');
		}*/
		else
		{

            $data['title'] = "Dashboard";

            // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Tablero', '/tablero/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/edit_group');
			// set the flash data error message if there is one

            // unshift crumb
            // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
            $data['breadcrumbs'] = $this->breadcrumbs->show();


			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			//list the users
			$data['users'] = $this->ion_auth->users()->result();

			foreach ($data['users'] as $k => $user)
			{
				$data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}

            $data['conectado'] = $this->ion_auth->get_user();

            $this->template->write('title', $data['title'], true);

            //la secci�n header ser� el archivo views/registro/header_template
            $this->template->write_view('header', 'backend/header_template',$data);
            //desde aqu� tambi�n podemos setear el t�tulo
            $this->template->write_view('sidebar', 'backend/sidebar_template',$data);
            //la seccion footer ser� el archivo views/registro/footer_template
            $this->template->write_view('footer', 'backend/footer_template');
            //con el metodo render podemos renderizar y hacer que se visualice la template

          //  $this->load->model('model_letswork');
       // 	$data["subcategorias"]=$this->model_letswork->subcategorias();
        //	$data[1]=$this->model_letswork->subcategorias();
           //  $rs[1] = $this->Dashboard_model->consulta_tipo_donut($tipo, $tipo2, $anio);

            $this->template->write_view('content', 'dashboard/index', $data, true);

			$this->template->render();
		}
	}





}
