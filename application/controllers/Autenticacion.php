<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacion extends MX_Controller
{

    function __construct()
    {
        parent::__construct();


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
        //	$this->template->add_js('assets/js/jquery-3.1.0.min.js');
        $this->template->add_js('assets/js/jquery.min.js');
        $this->template->add_js('assets/js/bootstrap.js');
        //$this->template->add_js('assets/js/fancywebsocket.js');
        $this->template->add_js('assets/js/script.js');

        $this->template->add_js('assets/js/plugins/datatables/jquery.dataTables.js');

        $this->template->add_js('assets/js/plugins/datatables/dataTables.bootstrap.js');

        $this->template->add_js('assets/js/AdminLTE/app.js');

        $this->template->add_js('assets/js/html5shiv.js');

        $this->template->add_js('assets/js/respond.min.js');

        $data['conectado'] = $this->ion_auth->get_user();

        //la secci?n header ser? el archivo views/registro/header_template
        $this->template->write_view('header', 'backend/header_template', $data);
        //desde aqu? tambi?n podemos setear el t?tulo


        $this->template->write_view('sidebar', 'backend/sidebar_template', $data);
        //la secci�n footer ser� el archivo views/registro/footer_template
        $this->template->write_view('footer', 'backend/footer_template');
        //con el m�todo render podemos renderizar y hacer que se visualice la template


    }


    function index()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('autenticacion/login', 'refresh');
        } else {
            redirect('autenticacion/users', 'refresh');
        }

    }

// redirect if needed, otherwise display the user list
    function users()
    {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('autenticacion/login', 'refresh');
        } /*elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{

			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}*/
        else {
            $data['title'] = "Users";
// add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Usuarios', '/autenticacion/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/users');

// unshift crumb
            // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
            // set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $data['users'] = $this->ion_auth->users()->result();
            $data['conectado'] = $this->ion_auth->get_user_id();
            foreach ($data['users'] as $k => $user) {
                $data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            //$this->_render_page('auth/users', $data);
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'auth/users', $data, true);
            $this->template->render();
        }
    }

    function groups()
    {

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('autenticacion/login', 'refresh');
        } /*elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
		{

			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}*/
        else {

            $data['title'] = "Groups";
            // add breadcrumbs
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Usuarios', '/autenticacion/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/groups');

// unshift crumb
            // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
            $data['breadcrumbs'] = $this->breadcrumbs->show();
            // set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $data['groups'] = $this->ion_auth->groups()->result();
            $data['conectado'] = $this->ion_auth->get_user_id();
            /*foreach ($data['users'] as $k => $user) {
                $data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }*/

            //$this->_render_page('auth/users', $data);
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'auth/groups', $data, true);
            $this->template->render();
        }
    }

    // log the user in
    function login()
    {
        $data['title'] = "Login";

        //validate form input
        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == true) {
            // check to see if the user is logging in
            // check for "remember me"
            $remember = (bool)$this->input->post('remember');
              //$correo = $this->input->post('identity'). "@controlsanitario.gob.ec";
              $correo = $this->input->post('identity');

            if ($this->ion_auth->login($correo, $this->input->post('password'), $remember)) {
                //if the login is successful
                //redirect them back to the home page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('/', 'refresh');
            } else {
                // if the login was un-successful
                // redirect them back to the login page
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('autenticacion/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
            }
        } else {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
            );

            $this->_render_page('../auth/login', $data);

        }
    }

    // log the user out
    function logout()
    {
        $data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('autenticacion/login', 'refresh');
    }

    // change password
    function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('autenticacion/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {
            // display the form
            // set the flash data error message if there is one
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
            );
            $data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
            );
            $data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
            );
            $data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $user->id,
            );

            // render
            $this->_render_page('auth/change_password', $data);
        } else {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('autenticacion/change_password', 'refresh');
            }
        }
    }

function registro_proveedores()
    {

        $data['title'] = "Registro de Proveedores";


// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Usuarios', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/create_user');

        $data['array_areas'] = $this->ion_auth->categorias();

        $data['breadcrumbs'] = $this->breadcrumbs->show();


        $this->_render_page('auth/registro', $data);
   
    }
    
function contenedor()
    {

        $data['title'] = "Revisión de Contenedores";


// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Usuarios', '/autenticacion/');
      //  $this->breadcrumbs->push($data['title'], '/autenticacion/create_user');

     //   $data['array_areas'] = $this->ion_auth->categorias();

      //  $data['breadcrumbs'] = $this->breadcrumbs->show();


        $this->_render_page('auth/contenedor', $data);
   
    }
    
    // forgot password
    function forgot_password()
    {
        // setting validation rules by checking wheather identity is username or email
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('email', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false) {
            // setup the input
            $data['email'] = array('name' => 'email',
                'id' => 'email',
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_page('auth/forgot_password', $data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("autenticacion/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("autenticacion/login", 'refresh'); //we should display a confirmation page here instead of the login page
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("autenticacion/forgot_password", 'refresh');
            }
        }
    }

    // reset password - final step for forgotten password
    public function reset_password($code = NULL)
    {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {
                // display the form

                // set the flash data error message if there is one
                $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
                );
                $data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
                );
                $data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $data['csrf'] = $this->_get_csrf_nonce();
                $data['code'] = $code;

                // render
                $this->_render_page('auth/reset_password', $data);
            } else {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                } else {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("autenticacion/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('autenticacion/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("autenticacion/forgot_password", 'refresh');
        }
    }


    // activate the user
    function activate($id, $code = false)
    {
        $this->ion_auth->activate($id);
        redirect("autenticacion/users", 'refresh');

/*
        if ($code !== false) {
            $activation = $this->ion_auth->activate($id, $code);
        } else if ($this->ion_auth->is_admin()) {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation) {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            //redirect("autenticacion", 'refresh');
            redirect("autenticacion/users", 'refresh');
        } else {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("autenticacion/forgot_password", 'refresh');
        }  */
    }

    // deactivate the user
    function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() ) {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be an administrator to view this page.');
        }

        $id = (int)$id;
        $this->ion_auth->deactivate($id);
        /* $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE) {
            // insert csrf check
            $data['csrf'] = $this->_get_csrf_nonce();
            $data['user'] = $this->ion_auth->user($id)->row();

            $this->_render_page('auth/deactivate_user', $data);
        } else {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes') {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                    show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in() ) {
                    $this->ion_auth->deactivate($id);
                }
            }
            */
            // redirect them back to the auth page
            redirect('autenticacion/users', 'refresh');
        
    }

    // create a new user
    function create_user()
    {

        $data['title'] = "Create User";


// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Usuarios', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/create_user');

// unshift crumb
        // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        if (!$this->ion_auth->logged_in() ) {
            redirect('autenticacion', 'refresh');
        }

        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $data['identity_column'] = $identity_column;

        $groups = $this->ion_auth->groups()->result_array();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if ($identity_column !== 'email') {
            //$this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|autenticacion_is_unique[' . $tables['users'] . '.' . $identity_column . ']');
            $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        } else {
            //$this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|autenticacion_is_unique[' . $tables['users'] . '.email]');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true) {
            $email = strtolower($this->input->post('email'));
            $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'company' => $this->input->post('company'),
                'phone' => $this->input->post('phone'),
                'fotografia' => '9999999999.png'
            );
            $groups = $this->input->post('groups');
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data, $groups)) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            //redirect("autenticacion", 'refresh');
            redirect("autenticacion/users", 'refresh');
        } else {

            $data['groups'] = $groups;
            // display the create user form
            // set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $data['first_name'] = array(
                'name' => 'first_name',
                'id' => 'first_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $data['last_name'] = array(
                'name' => 'last_name',
                'id' => 'last_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $data['identity'] = array(
                'name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
            );
            $data['email'] = array(
                'name' => 'email',
                'id' => 'email',
                'type' => 'text',
                'value' => $this->form_validation->set_value('email'),
            );
            $data['company'] = array(
                'name' => 'company',
                'id' => 'company',
                'type' => 'text',
                'value' => $this->form_validation->set_value('company'),
            );
            $data['phone'] = array(
                'name' => 'phone',
                'id' => 'phone',
                'type' => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $data['password'] = array(
                'name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password'),
            );
            $data['password_confirm'] = array(
                'name' => 'password_confirm',
                'id' => 'password_confirm',
                'type' => 'password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            // $this->_render_page('auth/create_user', $data);
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'auth/create_user', $data, true);
            $this->template->render();
        }
    }

    // edit a user
    function edit_user($id)
    {

        $data['title'] = "Edit User";
// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Usuarios', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/edit_user');

// unshift crumb
        // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
        $data['breadcrumbs'] = $this->breadcrumbs->show();
      //  if (!$this->ion_auth->logged_in() || ( !($this->ion_auth->user()->row()->id == $id))) {
        //    redirect('autenticacion/users', 'refresh');
        //}

        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');

        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                );

                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }


                // Only allow updating groups if user is admin
               
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }

                    }
                

                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                     redirect('autenticacion/users', 'refresh');
                   // if ($this->ion_auth->is_admin()) {
                     //   redirect('autenticacion/users', 'refresh');
                   // } else {
                        //redirect('/', 'refresh');
                     //   redirect('autenticacion', 'refresh');

                    //}

                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                     redirect('autenticacion/users', 'refresh');
                    //if ($this->ion_auth->is_admin()) {
                      //  redirect('autenticacion/users', 'refresh');
                    //} else {
                        //redirect('/', 'refresh');
                      //  redirect('autenticacion', 'refresh');
                    //}

                }

            }
        }

        // display the edit user form
        $data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $data['user'] = $user;
        $data['groups'] = $groups;
        $data['currentGroups'] = $currentGroups;

        $data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $data['email'] = array(
            'name' => 'email',
            'id' => 'email',
            'type' => 'text',
            'value' => $this->form_validation->set_value('email', $user->email),
        );
        $data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );
        $this->template->write('title', $data['title'], true);
        $this->template->write_view('content', 'auth/edit_user', $data, true);
        $this->template->render();
        //$this->_render_page('auth/edit_user', $data);
    }

    // create a new group
    function create_group()
    {
        $data['title'] = $this->lang->line('create_group_title');


// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Grupos', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/create_group');

// unshift crumb
        // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        if (!$this->ion_auth->logged_in() ) {
            redirect('autenticacion/users', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('group_description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("autenticacion/create_group", 'refresh');
            }
        } else {
            // display the create group form
            // set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            /* $data['description'] = array(
                 'name' => 'description',
                 'id' => 'description',
                 'type' => 'text',
                 'value' => $this->form_validation->set_value('description'),
             );*/
            $data['group_description'] = array(
                'name' => 'group_description',
                'id' => 'group_description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_description'),
            );

            //$this->_render_page('auth/create_group', $data);
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'auth/create_group', $data, true);
            $this->template->render();
        }
    }

    // edit a group
    function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('autenticacion/users', 'refresh');
        }

        $data['title'] = $this->lang->line('edit_group_title');

        // add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Usuarios', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/edit_group');

// unshift crumb
        // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        if (!$this->ion_auth->logged_in() ) {
            redirect('autenticacion/users', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("auth", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $data['group'] = $group;


        $array_menu = $this->menu->get_menu();


        foreach ($array_menu as $menu) {
            $accesos[$menu['id']] = $menu;
            $submenu = $this->menu->get_menu($menu['id']);
            if (count($submenu) > 0) {
                foreach ($submenu as $sub) {
                    $accesos[$menu['id']]['childs'][$sub['id']] = $sub;
                }
            } else {
                $accesos[$menu['id']]['childs'] = null;
            }
        }
        //var_dump($accesos);
        $data['accesos'] = $accesos;

        $array_menu_activo = $this->menu->get_menu_x_groups($group->id);
        if (count($array_menu_activo) > 0) {
            foreach ($array_menu_activo as $menu_activo) {
                $accesos_activo[$menu_activo['id']] = $menu_activo;
                $submenu_activo = $this->menu->get_menu_x_groups($group->id, $menu_activo['id']);
                if (count($submenu_activo) > 0) {
                    foreach ($submenu_activo as $subact) {
                        $accesos_activo[$menu_activo['id']]['childs'][$subact['id']] = $subact;
                    }
                } else {
                    $accesos_activo[$menu_activo['id']]['childs'] = null;
                }

            }
        } else {
            $accesos_activo = null;
        }
        // var_dump($accesos_activo);
        $data['accesos_activos'] = $accesos_activo;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        //$this->_render_page('auth/edit_group', $data);
        $this->template->write('title', $data['title'], true);
        $this->template->write_view('content', 'auth/edit_group', $data, true);
        $this->template->render();
    }


    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
        ) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function create_menu()
    {
        // create a new group

        $data['title'] = "Crear Menu";


// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Menus', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/create_menu');

// unshift crumb
        // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        if (!$this->ion_auth->logged_in() ) {
            redirect('autenticacion/users', 'refresh');
        }

        // validate form input
         $this->form_validation->set_rules('parent', "Requerido este campo!!!", 'required');
      /*   $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');

         $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
         $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
         $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
         $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
 */
        if ($this->form_validation->run() == true) {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            //redirect("autenticacion", 'refresh');
            redirect("autenticacion/crear_menu", 'refresh');
        } else {


            // display the create user form
            // set the flash data error message if there is one
            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $data['parent'] = array(
                'name' => 'parent',
                'id' => 'parent',
                'type' => 'text',
                'value' => $this->form_validation->set_value('parent'),
            );

            $data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            //$this->_render_page('auth/edit_group', $data);

        }
        $this->template->write('title', $data['title'], true);
        $this->template->write_view('content', 'auth/crear_menu', $data, true);
        $this->template->render();
    }

    function _render_page($view, $data = null, $returnhtml = false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $data : $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }

        // create a new user por usuario
    function crear_usuario()
    {

        $data['title'] = "Create User";


// add breadcrumbs
        $this->breadcrumbs->push('Inicio', '/');
        $this->breadcrumbs->push('Usuarios', '/autenticacion/');
        $this->breadcrumbs->push($data['title'], '/autenticacion/create_user');

// unshift crumb
        // $this->breadcrumbs->unshift('Autenticacion', '/');

// output
        $data['array_areas'] = $this->ion_auth->areas();

        $data['breadcrumbs'] = $this->breadcrumbs->show();


        $this->_render_page('auth/create_user_user', $data);
        // $this->_render_page('auth/create_user', $data);
        /*$this->template->write('title', $data['title'], true);
        $this->template->write_view('content', 'auth/create_user_user', $data, true);
        $this->template->render();*/
    }

    function guardar_usuario()
    {
        $email = strtolower($this->input->post('email')) . "@controlsanitario.gob.ec";
        $identity = $email;
        $password = $this->input->post('password');
        
        $groups=$this->input->post('company');
        
        $additional_data = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'company' => $groups,
            'phone' => $this->input->post('phone'),
            'fotografia' => '/ensayos/assests/images/image.jpg'
        );
        //xavier    -- $groups = 10;
        
         
        //var_dump($additional_data); die;
        $mensaje = "";
        $respuesta = "";
        try{
            $this->ion_auth->register_nuevo($identity, $password, $email, $additional_data, $groups, $this->input->post('cedula'));
            $respuesta = ['error' => 0, 'mensaje' => 'Usuario creado con éxito, ya puede inciar sesión.'];
              $data_mail = array(
                'usuario' => $this->input->post('email'),
                'contraseña' => $password
            );
            if ($this->config->item("envio_email")) {
                $this->load->library("email");
                $this->email->from($this->config->item("correo_admin"));
                $this->email->to($email);
                $this->email->subject("Registro de Usuario");
                $message = $this->load->view('templates_mail/registro_usuario_exitoso', $data_mail, true);
                $this->email->message($message);
                $this->email->send();
            } 
        }catch (Exception $e){
            $respuesta = ['error' => 1, 'mensaje' => 'Ocurrio un error al guardar intentelo en unos momentos.'];
        }
        echo json_encode($respuesta);
    }

    

 function consulta_chart_3()
    {
        $data=$this->ion_auth->genera_chart_canteras_master();

      $i=0;
        foreach ($data as $valor) {
            $data[$i] = ['y' => $valor['detalle'], 'a' => $valor['total']];
            $i++;
                   }

        $array=[];
        $array[0]=$data;
        $respuesta = ['error' => 0, 'mensaje' => $array];

        echo json_encode($respuesta);

    }
    
function consulta_chart_2()
    {
        $data1 = $this->input->post('data1');
        $long = $this->input->post('long');

        for ($i = 0; $i <= $long-1; $i++) {
            $data[$i] = ['y' => $data1[$i]['nombre_contrato'], 'a' => $data1[$i]['total']];
        }

        $array=[];
        $array[0]=$data;
        $respuesta = ['error' => 0, 'mensaje' => $array];

        //var_dump($respuesta);            die;
        echo json_encode($respuesta);

    }
    function consulta_chart()
    {
           $data1 = $this->input->post('data1');
            $long = $this->input->post('long');
            
            for ($i = 0; $i <= $long-1; $i++) {
              $data[$i] = ['y' => $data1[$i]['asociacion'], 'a' => $data1[$i]['viajes']];
            }
        /*    $data[0] = ['y' => $data1[0]['asociacion'], 'a' => $data1[0]['viajes']];
            $data[1] = ['y' => $data1[1]['asociacion'], 'a' => $data1[1]['viajes']];
            $data[2] = ['y' => $data1[2]['asociacion'], 'a' => $data1[2]['viajes']];
            $data[3] = ['y' => $data1[3]['asociacion'], 'a' => $data1[3]['viajes']];
            $data[4] = ['y' => $data1[4]['asociacion'], 'a' => $data1[4]['viajes']];
            $data[5] = ['y' => $data1[5]['asociacion'], 'a' => $data1[5]['viajes']];
            $data[6] = ['y' => $data1[6]['asociacion'], 'a' => $data1[6]['viajes']];
            $data[7] = ['y' => $data1[7]['asociacion'], 'a' => $data1[7]['viajes']];
            $data[8] = ['y' => $data1[8]['asociacion'], 'a' => $data1[8]['viajes']];
            $data[9] = ['y' => $data1[9]['asociacion'], 'a' => $data1[9]['viajes']];
            $data[10] = ['y' => $data1[10]['asociacion'], 'a' => $data1[10]['viajes']];
            $data[11] = ['y' => $data1[11]['asociacion'], 'a' => $data1[11]['viajes']];
            $data[12] = ['y' => $data1[12]['asociacion'], 'a' => $data1[12]['viajes']];
            $data[13] = ['y' => $data1[13]['asociacion'], 'a' => $data1[13]['viajes']];
            $data[14] = ['y' => $data1[14]['asociacion'], 'a' => $data1[14]['viajes']];
*/
            $array=[];
            $array[0]=$data;
            $respuesta = ['error' => 0, 'mensaje' => $array];

            //var_dump($respuesta);            die;
            echo json_encode($respuesta);
    }

     function cambiar_password()
    {
        //var_dump("HOLA"); die;
        $this->_render_page('auth/reset_password', []);
    }

    function enviar_password()
    {
        try {
            //var_dump("hola"); die;
            $usuarioCorreo = $this->input->post('usuarioCorreo');
            $res = $this->ion_auth->enviar_password_data($usuarioCorreo);
            $respuesta = $res;
        } catch (Exception $e) {
            $respuesta = ['error' => 1, 'mensaje' => 'Ocurrio un error al consultar intentelo en unos momentos.'];
        }
        echo json_encode($respuesta);
    }

     function cambio_password()
    {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('autenticacion/login', 'refresh');
        } else {
            $data['title'] = "Cambio de contraseña";
            $this->breadcrumbs->push('Inicio', '/');
            $this->breadcrumbs->push('Menus', '/autenticacion/');
            $this->breadcrumbs->push($data['title'], '/autenticacion/create_menu');
            $data['breadcrumbs'] = $this->breadcrumbs->show();
            $data['usuarioNombre'] = $this->ion_auth->get_user();
            $this->load->model("Daf_model");
            $data['solicitudes'] = $this->Daf_model->consultar_data_ajustes_pagos_confirmados(0);
            $this->template->write('title', $data['title'], true);
            $this->template->write_view('content', 'auth/cambio_password', $data, true);
            $this->template->render();
        }
    }

    function nueva_password()
    {
        try {
            //var_dump("hola"); die;
            $nuevaContraseña = $this->input->post('nuevaContraseña');
            $res = $this->ion_auth->nueva_password_data($nuevaContraseña);
            $respuesta = $res;
        } catch (Exception $e) {
            $respuesta = ['error' => 1, 'mensaje' => 'Ocurrio un error al consultar intentelo en unos momentos.'];
        }
        echo json_encode($respuesta);
    }

function registro_lets_work(){
    
            $nombre = trim($this->input->post('first_name'));
            $apellido = trim($this->input->post('last_name'));
            $cedula = trim($this->input->post('cedula'));
            $n_comercial = trim($this->input->post('n_comercial'));
            $correo = trim($this->input->post('correo'));
            $phone = trim($this->input->post('phone'));
            $categoria = trim($this->input->post('cmb_categoria'));
            $subcategoria = trim($this->input->post('cmb_subcategoria'));
            $detalle = trim($this->input->post('detalle'));
 
            $rs = $this->ion_auth->inserta_registro_lets_work($nombre,$apellido,$cedula,$n_comercial,$correo,$phone,$categoria,$subcategoria,$detalle);
           echo json_encode($rs);
}
 
function combo_subcategoria_letswork(){
    
            $id = trim($this->input->post('id'));
            $rs = $this->ion_auth->cmb_subcategoria($id);
           echo json_encode($rs);
}


      function subir_foto()
    {
        try{
            $data = $this->ion_auth->get_user();
            $upload_folder = $this->config->item("dir_adjuntos") . "ensayos/fotos_usuarios";
            $nombre_archivo = $_FILES["img"]["name"];
            $tipo_archivo = $_FILES["img"]["type"];
            $tamano_archivo = $_FILES["img"]["size"];
            $tmp_archivo = $_FILES["img"]["tmp_name"];
            $data_f = explode(".",$nombre_archivo);
            $foto = $data["cedula"].".".$data_f["1"];
            $archivador = $upload_folder . "/" . $foto;
            //var_dump($archivador); die;
            //$archivador = str_replace("'", "", $archivador);
              if (!file_exists($upload_folder)) {
                        mkdir($upload_folder, 0777, true);
                    }
            move_uploaded_file($tmp_archivo, $archivador);
            $res = $this->ion_auth->subir_foto_data($archivador);
            $respuesta = $res;

        }catch(Exception $ex){
            $respuesta = ['error' => 1, 'mensaje' => 'Ocurrio un error al consultar intentelo en unos momentos.'];
        }
        echo json_encode($respuesta);
    }

}
