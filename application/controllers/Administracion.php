<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Administracion extends CI_Controller
{
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
                $this->load->model("Administracion_model");

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






    function crear_socio()
    {
        
            $root = "http://".$_SERVER['HTTP_HOST'];
            $root .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
            $data['tittle'] = "Rotary - Creación Socio";
            $data['menu'] = "Administración";
            $data['menu2'] = "Creación de Socio";
            $data['menu3'] = "";
            $data["root"] = $root;
            $data["informacion_usuario"] = $this->Administracion_model->listar_informacion_usuario();

            $this->template->write_view('content', '/administracion/creacion_socios', $data, true);
            $this->template->render();
        
    }

    function crear_agenda_rotary()
    {
        if (!$this->session->userdata('logged_in')) {

            redirect('autenticacion/login', 'refresh');
        } else {
            $data['tittle'] = "Rotary - Creación Socio";
            $data['menu'] = "Administración";
            $data['menu2'] = "Creación Agenda Rotary";
            $data['menu3'] = "";
            $this->template->write_view('content', '/administracion/crear_agenda_rotary', $data, true);
            $this->template->render();
        }
    }

    function en_construccion()
    {
        if (!$this->session->userdata('logged_in')) {

            redirect('autenticacion/login', 'refresh');
        } else {
            $data['tittle'] = "Rotary - Construcción";
            $data['menu'] = "Construcción";
            $data['menu2'] = "Construcción";
            $data['menu3'] = "";
            $this->template->write_view('content', '/administracion/en_construccion', $data, true);
            $this->template->render();
        }
    }

    function admin_crear_socio()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array( 'usuario' => trim($this->input->get('usuario')),
            'nombres' => trim($this->input->get('nombres')),
            'apellidos' => trim($this->input->get('apellidos')),
            'correo' => trim($this->input->get('correo')),
            'cedula' => trim($this->input->get('cedula')),
            'telefono' => trim($this->input->get('telefono')),
            'celular' => trim($this->input->get('celular')),
            'ciudad' => trim($this->input->get('ciudad')),
            'fecha_nace' => trim($this->input->get('fecha_nace')),
            'pagina' => trim($this->input->get('pagina')),
            'acerca' => trim($this->input->get('acerca')),
            'direccion' => trim($this->input->get('direccion'))
            );
            $respuesta = $this->Administracion_model->insertar_data_socio($data);
            echo json_encode($respuesta);
        }
    }

    function genera_clave()
    {
        $opc_letras = TRUE; //  FALSE para quitar las letras
        $opc_numeros = TRUE; // FALSE para quitar los números
        $opc_letrasMayus = TRUE; // FALSE para quitar las letras mayúsculas
        $opc_especiales = FALSE; // FALSE para quitar los caracteres especiales
        $longitud = 25;
        $password = "";

        $letras ="abcdefghijklmnopqrstuvwxyz";
        $numeros = "1234567890";
        $letrasMayus = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $especiales ="|@#~$%()=^*+[]{}-_";
        $listado = "";

        if ($opc_letras == TRUE) {
            $listado .= $letras; }
        if ($opc_numeros == TRUE) {
            $listado .= $numeros; }
        if($opc_letrasMayus == TRUE) {
            $listado .= $letrasMayus; }
        if($opc_especiales == TRUE) {
            $listado .= $especiales; }

        str_shuffle($listado);
        for( $i=0; $i<=$longitud; $i++) {
            $password[$i] = $listado[rand(0,strlen($listado))];
            str_shuffle($listado);
        }

        foreach ($password as $dato_password) {
            echo $dato_password;
        }
    die;
    }

    function crear_nueva_ruta()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array( 'nombre' => trim($this->input->get('nombre'))
            );
            $respuesta = $this->Administracion_model->cdu_data_carpetas($data, 1);
            echo json_encode($respuesta);
        }
    }

    function crear_nueva_ruta_hija()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array( 'nombre' => trim($this->input->get('nombre'))
            ,'opcion' => trim($this->input->get('opcion'))
            ,'nombre_texto' => trim($this->input->get('nombre_texto'))
            );
            $respuesta = $this->Administracion_model->cdu_data_carpetas($data, 2);
            echo json_encode($respuesta);
        }
    }

    function cargar_menu_socios()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array( 'id_usuario' => trim($this->input->get('id_usuario')));
            $resp = $this->Administracion_model->data_cargar_menu_socios($data);
            if($resp["op"] == 0){
                if(count($resp["res_menu"]) > 0){
                    $tabla = "<table class='table table-striped table-bordered table-hover dataTable no-footer'>";
                    $tabla .= "<thead>";
                    $tabla .= "<th style='text-align: center'>#</th>";
                    $tabla .= "<th style='text-align: center'>Grupo</th>";
                    $tabla .= "<th style='text-align: center'>Descripción</th>";
                    $tabla .= "<th style='text-align: center'>Activo</th>";
                    $tabla .= "</thead>";
                    $tabla .= "<tbody>";
                    $i = 1;
                    //var_dump($resp["res_menu_user"]); die;
                    foreach ($resp["res_menu"] as $row)
                    {
                        $tabla .="<tr>";
                        $tabla .="<td style='text-align: center'>";
                        $tabla .=$i;
                        $tabla .="</td>";
                        $tabla .="<td style='text-align: center'>";
                        $tabla .=$row["name"];
                        $tabla .="</td>";
                        $tabla .="<td style='text-align: center'>";
                        $tabla .=$row["slug"];
                        $tabla .="</td>";
                        $tabla .="<td style='text-align: center'>";
                        $band = false;
                        foreach ($resp["res_menu_user"] as $row2){
                            if($row["id"] == $row2["group_id"]){
                                $band = true;
                            }
                        }
                        if($band) $tabla .= "<input id='".$row["id"]."' type='checkbox' checked='checked' name='grupos[]' />";
                        else $tabla .= "<input id='".$row["id"]."' type='checkbox' name='grupos[]' id='grupos' />";
                        $tabla .="</td>";
                        $tabla .="</tr>";
                        $i++;
                    }
                    $tabla .= "</tbody>";
                }
            }
            $resp = array_merge(['tabla'=>$tabla], $resp);
            //var_dump($resp); die;
            echo json_encode($resp);
        }
    }

    function asignar_menu_socio()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array( 'socio_id' => trim($this->input->get('socio_id')),
                'id_group_t' => trim($this->input->get('id_group_t')),
                'id_group_f' => trim($this->input->get('id_group_f'))
            );
            //var_dump($data); die;
            $respuesta = $this->Administracion_model->guardar_asignar_menu_socio($data);
            echo json_encode($respuesta);
        }
    }

   /* function perfil_administrador($id)
    {
        if (!$this->session->userdata('logged_in')) {

            redirect('autenticacion/login', 'refresh');
        } else {

            $data['tittle'] = "Rotary - Perfil Socio";
            $data['menu'] = "Administración";
            $data['menu2'] = "Perfil";
            $data['menu3'] = "";
            //var_dump($this->session->userdata()); die;
            $data["informacion_usuario"] = $this->Socios_model->informacion_usuario($id);
            //var_dump($data["informacion_usuario"]); die;
            $this->template->write_view('content', '/administracion/perfil_admin', $data, true);
            $this->template->render();
        }
    }
*/
    function perfil_editar($id){
        if (!$this->session->userdata('logged_in')) {

            redirect('autenticacion/login', 'refresh');
        } else {

            $data['tittle'] = "Rotary - Perfil Socio";
            $data['menu'] = "Administración";
            $data['menu2'] = "Perfil";
            $data['menu3'] = "Editar Socio";
            //var_dump($this->session->userdata()); die;
            $data["informacion_usuario"] = $this->Administracion_model->informacion_usuario_admin($id);
            //var_dump($data["informacion_usuario"]); die;
            $this->template->write_view('content', '/administracion/edita_socios', $data, true);
            $this->template->render();
        }
    }

    function admin_editar_socio()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array(
                'id_usuario' => trim($this->input->get('id_usuario')),
                'nombres' => trim($this->input->get('nombres')),
                'apellidos' => trim($this->input->get('apellidos')),
                'correo' => trim($this->input->get('correo')),
                'telefono' => trim($this->input->get('telefono')),
                'celular' => trim($this->input->get('celular')),
                'ciudad' => trim($this->input->get('ciudad')),
                'fecha_nace' => trim($this->input->get('fecha_nace')),
                'pagina' => trim($this->input->get('pagina')),
                'acerca' => trim($this->input->get('acerca')),
                'direccion' => trim($this->input->get('direccion')),
                'id_usu_modi' => trim($this->session->userdata("id"))
            );

            $respuesta = $this->Administracion_model->editar_data_socio($data);
            echo json_encode($respuesta);
        }
    }

    function admin_desactiva_socio()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array(
                'id_socio_desactiva' => trim($this->input->get('id_socio_desactiva')),
                'id_usu_desactiva' => trim($this->session->userdata("id"))
            );

            $respuesta = $this->Administracion_model->desactiva_data_socio($data);
            echo json_encode($respuesta);
        }
    }

    function admin_carga_img_temporal()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array(
                'id_nuevo' => trim($_SESSION["dta_id_ruta"]),
                'nombre_archivo' => trim($_FILES['kv-explorer']["name"]),
                'tipo_archivo' => trim($_FILES['kv-explorer']["type"]),
                'tamano_archivo' => trim($_FILES['kv-explorer']["size"]),
                'tmp_archivo' => trim($_FILES['kv-explorer']["tmp_name"])
            );

            $respuesta = $this->Administracion_model->data_admin_carga_img_temporal($data);
            echo json_encode($respuesta);
        }
    }

    function admin_carga_img_en_rutas()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array(
                'id_nuevo' => trim($_SESSION["id_ruta_carga"]),
                'rtua_inserta' => trim($_SESSION["ruta"]),
                'nombre_archivo' => trim($_FILES['kv-explorer-2']["name"]),
                'tipo_archivo' => trim($_FILES['kv-explorer-2']["type"]),
                'tamano_archivo' => trim($_FILES['kv-explorer-2']["size"]),
                'tmp_archivo' => trim($_FILES['kv-explorer-2']["tmp_name"])
            );
            $respuesta = $this->Administracion_model->data_admin_carga_img_en_rutas($data);
            echo json_encode($respuesta);
        }
    }

    function setea_sesion_rutas()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {
            $data = array(
                'id_ruta_carga' => trim($this->input->get('id_ruta_carga')),
                'ruta' => trim($this->session->userdata("ruta"))
            );
            $_SESSION["id_ruta_carga"] = trim($this->input->get('id_ruta_carga'));
            $_SESSION["ruta"] = trim($this->input->get('ruta'));
            echo json_encode("ok");
        }
    }

    function buscar_ruta_texto()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {

            $data = array(
                'texto' => trim($this->input->get('texto')),
                'op' => trim($this->input->get('opcion'))
            );
            $respuesta = $this->Administracion_model->data_buscar_ruta_texto($data);
            echo json_encode($respuesta);
        }
    }

    function guarda_carpetas_en_ruta()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {

            $data = array(
                'id_ruta_carga' => trim($this->input->get('id_ruta_carga')),
                'ruta' => trim($this->input->get('ruta')),
                'nombre_carpeta' => trim($this->input->get('nombre_carpeta'))
            );

            $respuesta = $this->Administracion_model->data_guarda_carpetas_en_ruta($data);
            echo json_encode($respuesta);
        }
    }

    function admin_cambiar_nombre()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('autenticacion/login', 'refresh');
        } else {

            $data = array(
                'id_name' => trim($this->input->get('id_name')),
                'txt_nuevo_nombre' => trim($this->input->get('txt_nuevo_nombre'))
            );

            $respuesta = $this->Administracion_model->data_admin_cambiar_nombre($data);
            echo json_encode($respuesta);
        }
    }




}