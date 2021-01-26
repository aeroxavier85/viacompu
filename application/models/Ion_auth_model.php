<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Name:  Ion Auth Model
 *
 * Version: 2.5.2
 *
 * Author:  Ben Edmunds
 *           ben.edmunds@gmail.com
 * @benedmunds
 *
 * Added Awesomeness: Phil Sturgeon
 *
 * Location: http://github.com/benedmunds/CodeIgniter-Ion-Auth
 
 * Created:  10.01.2009
 *
 * Last Change: 3.22.13
 *
 * Changelog:
 * * 3-22-13 - Additional entropy added - 52aa456eef8b60ad6754b31fbdcc77bb
 *
 * Description:  Modified auth system based on redux_auth with extensive customization.  This is basically what Redux Auth 2 should be.
 * Original Author name has been kept but that does not mean that the method has not been modified.
 *
 * Requirements: PHP5 or above
 *
 */
class Ion_auth_model extends CI_Model
{
    /**
     * Holds an array of tables used
     *
     * @var array
     **/
    public $tables = array();

    /**
     * activation code
     *
     * @var string
     **/
    public $activation_code;

    /**
     * forgotten password key
     *
     * @var string
     **/
    public $forgotten_password_code;

    /**
     * new password
     *
     * @var string
     **/
    public $new_password;

    /**
     * Identity
     *
     * @var string
     **/
    public $identity;

    /**
     * Where
     *
     * @var array
     **/
    public $_ion_where = array();

    /**
     * Select
     *
     * @var array
     **/
    public $_ion_select = array();

    /**
     * Like
     *
     * @var array
     **/
    public $_ion_like = array();

    /**
     * Limit
     *
     * @var string
     **/
    public $_ion_limit = NULL;

    /**
     * Offset
     *
     * @var string
     **/
    public $_ion_offset = NULL;

    /**
     * Order By
     *
     * @var string
     **/
    public $_ion_order_by = NULL;

    /**
     * Order
     *
     * @var string
     **/
    public $_ion_order = NULL;

    /**
     * Hooks
     *
     * @var object
     **/
    protected $_ion_hooks;

    /**
     * Response
     *
     * @var string
     **/
    protected $response = NULL;

    /**
     * message (uses lang file)
     *
     * @var string
     **/
    protected $messages;

    /**
     * error message (uses lang file)
     *
     * @var string
     **/
    protected $errors;

    /**
     * error sstart delimiter
     *
     * @var string
     **/
    protected $error_start_delimiter;

    /**
     * error end delimiter
     *
     * @var string
     **/
    protected $error_end_delimiter;

    /**
     * caching of users and their groups
     *
     * @var array
     **/
    public $_cache_user_in_group = array();

    /**
     * caching of groups
     *
     * @var array
     **/
    protected $_cache_groups = array();

    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->db_autenticacion = $this->load->database('autenticacion', TRUE);
     //    $this->db_permisos_prod = $this->load->database('permisos_prod', TRUE);
     //   $this->db_siarc_prod = $this->load->database('siarc_prod', TRUE);
       // $this->db_vue_gateway = $this->load->database('vue_gateway_desarrollo', TRUE);
        $this->load->config('ion_auth', TRUE);
        $this->load->helper('cookie');
        $this->load->helper('date');
        $this->lang->load('ion_auth');

        // initialize db tables data
        $this->tables = $this->config->item('tables', 'ion_auth');

        //initialize data
        $this->identity_column = $this->config->item('identity', 'ion_auth');
        $this->store_salt = $this->config->item('store_salt', 'ion_auth');
        $this->salt_length = $this->config->item('salt_length', 'ion_auth');
        $this->join = $this->config->item('join', 'ion_auth');


        // initialize hash method options (Bcrypt)
        $this->hash_method = $this->config->item('hash_method', 'ion_auth');
        $this->default_rounds = $this->config->item('default_rounds', 'ion_auth');
        $this->random_rounds = $this->config->item('random_rounds', 'ion_auth');
        $this->min_rounds = $this->config->item('min_rounds', 'ion_auth');
        $this->max_rounds = $this->config->item('max_rounds', 'ion_auth');


        // initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $delimiters_source = $this->config->item('delimiters_source', 'ion_auth');

        // load the error delimeters either from the config file or use what's been supplied to form validation
        if ($delimiters_source === 'form_validation') {
            // load in delimiters from form_validation
            // to keep this simple we'll load the value using reflection since these properties are protected
            $this->load->library('form_validation');
            $form_validation_class = new ReflectionClass("CI_Form_validation");

            $error_prefix = $form_validation_class->getProperty("_error_prefix");
            $error_prefix->setAccessible(TRUE);
            $this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
            $this->message_start_delimiter = $this->error_start_delimiter;

            $error_suffix = $form_validation_class->getProperty("_error_suffix");
            $error_suffix->setAccessible(TRUE);
            $this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
            $this->message_end_delimiter = $this->error_end_delimiter;
        } else {
            // use delimiters from config
            $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
            $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
            $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
            $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');
        }


        // initialize our hooks object
        $this->_ion_hooks = new stdClass;

        // load the bcrypt class if needed
        if ($this->hash_method == 'bcrypt') {
            if ($this->random_rounds) {
                $rand = rand($this->min_rounds, $this->max_rounds);
                $params = array('rounds' => $rand);
            } else {
                $params = array('rounds' => $this->default_rounds);
            }

            $params['salt_prefix'] = $this->config->item('salt_prefix', 'ion_auth');
            $this->load->library('bcrypt', $params);
        }

        $this->trigger_events('model_constructor');
    }

    /**
     * Misc functions
     *
     * Hash password : Hashes the password to be stored in the database.
     * Hash password db : This function takes a password and validates it
     * against an entry in the users table.
     * Salt : Generates a random salt value.
     *
     * @author Mathew
     */

    /**
     * Hashes the password to be stored in the database.
     *
     * @return void
     * @author Mathew
     **/
    public function hash_password($password, $salt = false, $use_sha1_override = FALSE)
    {
        if (empty($password)) {
            return FALSE;
        }

        // bcrypt
        if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
            return $this->bcrypt->hash($password);
        }


        if ($this->store_salt && $salt) {
            return sha1($password . $salt);
        } else {
            $salt = $this->salt();
            return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
        }
    }

    /**
     * This function takes a password and validates it
     * against an entry in the users table.
     *
     * @return void
     * @author Mathew
     **/
    public function hash_password_db($id, $password, $use_sha1_override = FALSE)
    {
        if (empty($id) || empty($password)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        $query = $this->db_autenticacion->select('password, salt')
            ->where('id', $id)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        $hash_password_db = $query->row();

        if ($query->num_rows() !== 1) {
            return FALSE;
        }

        // bcrypt
        if ($use_sha1_override === FALSE && $this->hash_method == 'bcrypt') {
            if ($this->bcrypt->verify($password, $hash_password_db->password)) {
                return TRUE;
            }

            return FALSE;
        }

        // sha1
        if ($this->store_salt) {
            $db_password = sha1($password . $hash_password_db->salt);
        } else {
            $salt = substr($hash_password_db->password, 0, $this->salt_length);

            $db_password = $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
        }

        if ($db_password == $hash_password_db->password) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


    public function hash_code($password)
    {
        return $this->hash_password($password, FALSE, TRUE);
    }


    public function salt()
    {

        $raw_salt_len = 16;

        $buffer = '';
        $buffer_valid = false;

        if (function_exists('mcrypt_create_iv') && !defined('PHALANGER')) {
            $buffer = mcrypt_create_iv($raw_salt_len, MCRYPT_DEV_URANDOM);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && function_exists('openssl_random_pseudo_bytes')) {
            $buffer = openssl_random_pseudo_bytes($raw_salt_len);
            if ($buffer) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid && @is_readable('/dev/urandom')) {
            $f = fopen('/dev/urandom', 'r');
            $read = strlen($buffer);
            while ($read < $raw_salt_len) {
                $buffer .= fread($f, $raw_salt_len - $read);
                $read = strlen($buffer);
            }
            fclose($f);
            if ($read >= $raw_salt_len) {
                $buffer_valid = true;
            }
        }

        if (!$buffer_valid || strlen($buffer) < $raw_salt_len) {
            $bl = strlen($buffer);
            for ($i = 0; $i < $raw_salt_len; $i++) {
                if ($i < $bl) {
                    $buffer[$i] = $buffer[$i] ^ chr(mt_rand(0, 255));
                } else {
                    $buffer .= chr(mt_rand(0, 255));
                }
            }
        }

        $salt = $buffer;

        // encode string with the Base64 variant used by crypt
        $base64_digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/';
        $bcrypt64_digits = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $base64_string = base64_encode($salt);
        $salt = strtr(rtrim($base64_string, '='), $base64_digits, $bcrypt64_digits);

        $salt = substr($salt, 0, $this->salt_length);


        return $salt;

    }

   public function activate($id, $code = false)
    {
        $this->trigger_events('pre_activate');

        if ($code !== FALSE) {
            $query = $this->db_autenticacion->select($this->identity_column)
                ->where('activation_code', $code)
                ->where('id', $id)
                ->limit(1)
                ->order_by('id', 'desc')
                ->get($this->tables['users']);

            $result = $query->row();

            if ($query->num_rows() !== 1) {
                $this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
                $this->set_error('activate_unsuccessful');
                return FALSE;
            }

            $data = array(
                'activation_code' => NULL,
                'active' => 1
            );

            $this->trigger_events('extra_where');
            $this->db_autenticacion->update($this->tables['users'], $data, array('id' => $id));
        } else {
            $data = array(
                'activation_code' => NULL,
                'active' => 1
            );


            $this->trigger_events('extra_where');
            $this->db_autenticacion->update($this->tables['users'], $data, array('id' => $id));
        }


        $return = $this->db_autenticacion->affected_rows() == 1;
        if ($return) {
            $this->trigger_events(array('post_activate', 'post_activate_successful'));
            $this->set_message('activate_successful');
        } else {
            $this->trigger_events(array('post_activate', 'post_activate_unsuccessful'));
            $this->set_error('activate_unsuccessful');
        }


        return $return;
    }

    public function deactivate($id = NULL)
    {
        $this->trigger_events('deactivate');

        if (!isset($id)) {
            $this->set_error('deactivate_unsuccessful');
            return FALSE;
        }

        $activation_code = sha1(md5(microtime()));
        $this->activation_code = $activation_code;

        $data = array(
            'activation_code' => $activation_code,
            'active' => 0
        );

        $this->trigger_events('extra_where');
        $this->db_autenticacion->update($this->tables['users'], $data, array('id' => $id));

        $return = $this->db_autenticacion->affected_rows() == 1;
        if ($return)
            $this->set_message('deactivate_successful');
        else
            $this->set_error('deactivate_unsuccessful');

        return $return;
    }

    public function clear_forgotten_password_code($code)
    {

        if (empty($code)) {
            return FALSE;
        }

        $this->db_autenticacion->where('forgotten_password_code', $code);

        if ($this->db_autenticacion->count_all_results($this->tables['users']) > 0) {
            $data = array(
                'forgotten_password_code' => NULL,
                'forgotten_password_time' => NULL
            );

            $this->db_autenticacion->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

            return TRUE;
        }

        return FALSE;
    }

    public function reset_password($identity, $new)
    {
        $this->trigger_events('pre_change_password');

        if (!$this->identity_check($identity)) {
            $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
            return FALSE;
        }

        $this->trigger_events('extra_where');

        $query = $this->db_autenticacion->select('id, password, salt')
            ->where($this->identity_column, $identity)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        if ($query->num_rows() !== 1) {
            $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
            $this->set_error('password_change_unsuccessful');
            return FALSE;
        }

        $result = $query->row();

        $new = $this->hash_password($new, $result->salt);

        // store the new password and reset the remember code so all remembered instances have to re-login
        // also clear the forgotten password code
        $data = array(
            'password' => $new,
            'remember_code' => NULL,
            'forgotten_password_code' => NULL,
            'forgotten_password_time' => NULL,
        );

        $this->trigger_events('extra_where');
        $this->db_autenticacion->update($this->tables['users'], $data, array($this->identity_column => $identity));

        $return = $this->db_autenticacion->affected_rows() == 1;
        if ($return) {
            $this->trigger_events(array('post_change_password', 'post_change_password_successful'));
            $this->set_message('password_change_successful');
        } else {
            $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
            $this->set_error('password_change_unsuccessful');
        }

        return $return;
    }

   public function change_password($identity, $old, $new)
    {
        $this->trigger_events('pre_change_password');

        $this->trigger_events('extra_where');

        $query = $this->db_autenticacion->select('id, password, salt')
            ->where($this->identity_column, $identity)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        if ($query->num_rows() !== 1) {
            $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
            $this->set_error('password_change_unsuccessful');
            return FALSE;
        }

        $user = $query->row();

        $old_password_matches = $this->hash_password_db($user->id, $old);

        if ($old_password_matches === TRUE) {
            // store the new password and reset the remember code so all remembered instances have to re-login
            $hashed_new_password = $this->hash_password($new, $user->salt);
            $data = array(
                'password' => $hashed_new_password,
                'remember_code' => NULL,
            );

            $this->trigger_events('extra_where');

            $successfully_changed_password_in_db = $this->db_autenticacion->update($this->tables['users'], $data, array($this->identity_column => $identity));
            if ($successfully_changed_password_in_db) {
                $this->trigger_events(array('post_change_password', 'post_change_password_successful'));
                $this->set_message('password_change_successful');
            } else {
                $this->trigger_events(array('post_change_password', 'post_change_password_unsuccessful'));
                $this->set_error('password_change_unsuccessful');
            }

            return $successfully_changed_password_in_db;
        }

        $this->set_error('password_change_unsuccessful');
        return FALSE;
    }

    public function username_check($username = '')
    {
        $this->trigger_events('username_check');

        if (empty($username)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        return $this->db_autenticacion->where('username', $username)
                ->group_by("id")
                ->order_by("id", "ASC")
                ->limit(1)
                ->count_all_results($this->tables['users']) > 0;
    }


    public function email_check($email = '')
    {
        $this->trigger_events('email_check');

        if (empty($email)) {
            return FALSE;
        }

        $this->trigger_events('extra_where');

        return $this->db_autenticacion->where('email', $email)
                ->group_by("id")
                ->order_by("id", "ASC")
                ->limit(1)
                ->count_all_results($this->tables['users']) > 0;
    }


    public function identity_check($identity = '')
    {
        $this->trigger_events('identity_check');

        if (empty($identity)) {
            return FALSE;
        }

        return $this->db_autenticacion->where($this->identity_column, $identity)
                ->count_all_results($this->tables['users']) > 0;
    }


    public function forgotten_password($identity)
    {
        if (empty($identity)) {
            $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));
            return FALSE;
        }

        // All some more randomness
        $activation_code_part = "";
        if (function_exists("openssl_random_pseudo_bytes")) {
            $activation_code_part = openssl_random_pseudo_bytes(128);
        }

        for ($i = 0; $i < 1024; $i++) {
            $activation_code_part = sha1($activation_code_part . mt_rand() . microtime());
        }

        $key = $this->hash_code($activation_code_part . $identity);

        // If enable query strings is set, then we need to replace any unsafe characters so that the code can still work
        if ($key != '' && $this->config->item('permitted_uri_chars') != '' && $this->config->item('enable_query_strings') == FALSE) {
            // preg_quote() in PHP 5.3 escapes -, so the str_replace() and addition of - to preg_quote() is to maintain backwards
            // compatibility as many are unaware of how characters in the permitted_uri_chars will be parsed as a regex pattern
            if (!preg_match("|^[" . str_replace(array('\\-', '\-'), '-', preg_quote($this->config->item('permitted_uri_chars'), '-')) . "]+$|i", $key)) {
                $key = preg_replace("/[^" . $this->config->item('permitted_uri_chars') . "]+/i", "-", $key);
            }
        }

        $this->forgotten_password_code = $key;

        $this->trigger_events('extra_where');

        $update = array(
            'forgotten_password_code' => $key,
            'forgotten_password_time' => time()
        );

        $this->db_autenticacion->update($this->tables['users'], $update, array($this->identity_column => $identity));

        $return = $this->db_autenticacion->affected_rows() == 1;

        if ($return)
            $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_successful'));
        else
            $this->trigger_events(array('post_forgotten_password', 'post_forgotten_password_unsuccessful'));

        return $return;
    }


    public function forgotten_password_complete($code, $salt = FALSE)
    {
        $this->trigger_events('pre_forgotten_password_complete');

        if (empty($code)) {
            $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
            return FALSE;
        }

        $profile = $this->where('forgotten_password_code', $code)->users()->row(); //pass the code to profile

        if ($profile) {

            if ($this->config->item('forgot_password_expiration', 'ion_auth') > 0) {
                //Make sure it isn't expired
                $expiration = $this->config->item('forgot_password_expiration', 'ion_auth');
                if (time() - $profile->forgotten_password_time > $expiration) {
                    //it has expired
                    $this->set_error('forgot_password_expired');
                    $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
                    return FALSE;
                }
            }

            $password = $this->salt();

            $data = array(
                'password' => $this->hash_password($password, $salt),
                'forgotten_password_code' => NULL,
                'active' => 1,
            );

            $this->db_autenticacion->update($this->tables['users'], $data, array('forgotten_password_code' => $code));

            $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_successful'));
            return $password;
        }

        $this->trigger_events(array('post_forgotten_password_complete', 'post_forgotten_password_complete_unsuccessful'));
        return FALSE;
    }


    public function register($identity, $password, $email, $additional_data = array(), $groups = array())
    {
        $this->trigger_events('pre_register');

        $manual_activation = $this->config->item('manual_activation', 'ion_auth');

        if ($this->identity_check($identity)) {
            $this->set_error('account_creation_duplicate_identity');
            return FALSE;
        } elseif (!$this->config->item('default_group', 'ion_auth') && empty($groups)) {
            $this->set_error('account_creation_missing_default_group');
            return FALSE;
        }
        /*
                // check if the default set in config exists in database
                $query = $this->db_autenticacion->get_where($this->tables['groups'],array('name' => $this->config->item('default_group', 'ion_auth')),1)->row();
                if( !isset($query->id) && empty($groups) )
                {
                    $this->set_error('account_creation_invalid_default_group');
                    return FALSE;
                }

                // capture default group details
                $default_group = $query;
        */
        // IP Address
        $ip_address = $this->_prepare_ip($this->input->ip_address());
        $salt = $this->store_salt ? $this->salt() : FALSE;
        $password = $this->hash_password($password, $salt);

        // Users table.
        $data = array(
            $this->identity_column => $identity,
            'password' => $password,
            'email' => $email,
            'ip_address' => $ip_address,
            'created_on' => time(),
            'active' => ($manual_activation === false ? 1 : 0)
        );

        if ($this->store_salt) {
            $data['salt'] = $salt;
        }

        // filter out any data passed that doesnt have a matching column in the users table
        // and merge the set user data and the additional data
        $user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

        $this->trigger_events('extra_set');

        $this->db_autenticacion->insert($this->tables['users'], $user_data);

        $id = $this->db_autenticacion->insert_id();

        /*
         *
         // add in groups array if it doesn't exits and stop adding into default group if default group ids are set
        if( isset($default_group->id) && empty($groups) )
        {
            $groups[] = $default_group->id;
        }
*/
        if (!empty($groups)) {
            // add to groups
            foreach ($groups as $group) {
                $this->add_to_group($group, $id);
            }
        }

        $this->trigger_events('post_register');

        return (isset($id)) ? $id : FALSE;
    }
    
    public function categorias()
 {
        $sql="SELECT id_categoria,nombre FROM falixso_lets_work.tbl_categoria where estado=1;  ";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
 }
 
   public function inserta_registro_lets_work($nombre,$apellido,$cedula,$n_comercial,$correo,$phone,$categoria,$subcategoria,$detalle)
 {
        $sql="INSERT INTO falixso_lets_work.tbl_usuarios
(nombres,apellido,cedula,nombre_comercial,correo,telefono,id_categoria,id_subcategoria,detalle)
VALUES('$nombre','$apellido','$cedula','$n_comercial','$correo','$phone','$categoria','$subcategoria','$detalle'); ";
   //     $query = $this->db_autenticacion->query($sql);
        
    if ($this->db_autenticacion->query($sql)== TRUE) {
        $last_id = $this->db_autenticacion->insert_id();
        $sql2=" INSERT INTO falixso_lets_work.tbl_oficios(id_usuarios,id_categoria,id_subcategoria) VALUES('$last_id','$categoria','$subcategoria');";
        $this->db_autenticacion->query($sql2);
        return 1;
    
        } else {
        return 0;
        }
 }
 
    public function cmb_subcategoria($id)
 {
        $sql="SELECT * FROM falixso_lets_work.tbl_subcategoria where cat_padre='$id' and estado=1 ;  ";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
 }
 
 
 
    public function login($identity, $password, $remember = FALSE)
    {
        $this->trigger_events('pre_login');

        if (empty($identity) || empty($password)) {
            $this->set_error('login_unsuccessful');
            return FALSE;
        }

        $this->trigger_events('extra_where');

        $query = $this->db_autenticacion->select($this->identity_column . ', users.email, users.id, password, users.active, users.last_login,persona.nombres,persona.apellidos,persona.fotografia,persona.cedula')
            ->join('persona', 'persona.user_id = users.id', 'inner')
            ->where($this->identity_column, $identity)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        if ($this->is_time_locked_out($identity)) {
            // Hash something anyway, just to take up time
            $this->hash_password($password);

            $this->trigger_events('post_login_unsuccessful');
            $this->set_error('login_timeout');

            return FALSE;
        }

        if ($query->num_rows() === 1) {
            $user = $query->row();

            $password = $this->hash_password_db($user->id, $password);

            if ($password === TRUE) {
                if ($user->active == 0) {
                    $this->trigger_events('post_login_unsuccessful');
                    $this->set_error('login_unsuccessful_not_active');

                    return FALSE;
                }

                $this->set_session($user);

                $this->update_last_login($user->id);

                $this->clear_login_attempts($identity);

                if ($remember && $this->config->item('remember_users', 'ion_auth')) {
                    $this->remember_user($user->id);
                }

                $this->trigger_events(array('post_login', 'post_login_successful'));
                $this->set_message('login_successful');

                return TRUE;
            }
        }

        // Hash something anyway, just to take up time
        $this->hash_password($password);

        $this->increase_login_attempts($identity);

        $this->trigger_events('post_login_unsuccessful');
        $this->set_error('login_unsuccessful');

        return FALSE;
    }


    public function is_max_login_attempts_exceeded($identity)
    {
        if ($this->config->item('track_login_attempts', 'ion_auth')) {
            $max_attempts = $this->config->item('maximum_login_attempts', 'ion_auth');
            if ($max_attempts > 0) {
                $attempts = $this->get_attempts_num($identity);
                return $attempts >= $max_attempts;
            }
        }
        return FALSE;
    }


    function get_attempts_num($identity)
    {
        if ($this->config->item('track_login_attempts', 'ion_auth')) {
            $ip_address = $this->_prepare_ip($this->input->ip_address());
            $this->db_autenticacion->select('1', FALSE);
            if ($this->config->item('track_login_ip_address', 'ion_auth')) {
                $this->db_autenticacion->where('ip_address', $ip_address);
                $this->db_autenticacion->where('login', $identity);
            } else if (strlen($identity) > 0) $this->db_autenticacion->or_where('login', $identity);
            $qres = $this->db_autenticacion->get($this->tables['login_attempts']);
            return $qres->num_rows();
        }
        return 0;
    }


    public function is_time_locked_out($identity)
    {

        return $this->is_max_login_attempts_exceeded($identity) && $this->get_last_attempt_time($identity) > time() - $this->config->item('lockout_time', 'ion_auth');
    }


    public function get_last_attempt_time($identity)
    {
        if ($this->config->item('track_login_attempts', 'ion_auth')) {
            $ip_address = $this->_prepare_ip($this->input->ip_address());

            $this->db_autenticacion->select_max('time');
            if ($this->config->item('track_login_ip_address', 'ion_auth')) $this->db_autenticacion->where('ip_address', $ip_address);
            else if (strlen($identity) > 0) $this->db_autenticacion->or_where('login', $identity);
            $qres = $this->db_autenticacion->get($this->tables['login_attempts'], 1);

            if ($qres->num_rows() > 0) {
                return $qres->row()->time;
            }
        }

        return 0;
    }

    /**
     * increase_login_attempts
     * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
     *
     * @param string $identity
     **/
    public function increase_login_attempts($identity)
    {
        if ($this->config->item('track_login_attempts', 'ion_auth')) {
            $ip_address = $this->_prepare_ip($this->input->ip_address());
            return $this->db_autenticacion->insert($this->tables['login_attempts'], array('ip_address' => $ip_address, 'login' => $identity, 'time' => time()));
        }
        return FALSE;
    }

    /**
     * clear_login_attempts
     * Based on code from Tank Auth, by Ilya Konyukhov (https://github.com/ilkon/Tank-Auth)
     *
     * @param string $identity
     **/
    public function clear_login_attempts($identity, $expire_period = 86400)
    {
        if ($this->config->item('track_login_attempts', 'ion_auth')) {
            $ip_address = $this->_prepare_ip($this->input->ip_address());

            $this->db_autenticacion->where(array('ip_address' => $ip_address, 'login' => $identity));
            // Purge obsolete login attempts
            $this->db_autenticacion->or_where('time <', time() - $expire_period, FALSE);

            return $this->db_autenticacion->delete($this->tables['login_attempts']);
        }
        return FALSE;
    }

    public function limit($limit)
    {
        $this->trigger_events('limit');
        $this->_ion_limit = $limit;

        return $this;
    }

    public function offset($offset)
    {
        $this->trigger_events('offset');
        $this->_ion_offset = $offset;

        return $this;
    }

    public function where($where, $value = NULL)
    {
        $this->trigger_events('where');

        if (!is_array($where)) {
            $where = array($where => $value);
        }

        array_push($this->_ion_where, $where);

        return $this;
    }

    public function like($like, $value = NULL, $position = 'both')
    {
        $this->trigger_events('like');

        if (!is_array($like)) {
            $like = array($like => array(
                'value' => $value,
                'position' => $position,
            ));
        }

        array_push($this->_ion_like, $like);

        return $this;
    }

    public function select($select)
    {
        $this->trigger_events('select');

        $this->_ion_select[] = $select;

        return $this;
    }

    public function order_by($by, $order = 'desc')
    {
        $this->trigger_events('order_by');

        $this->_ion_order_by = $by;
        $this->_ion_order = $order;

        return $this;
    }

    public function row()
    {
        $this->trigger_events('row');

        $row = $this->response->row();

        return $row;
    }

    public function row_array()
    {
        $this->trigger_events(array('row', 'row_array'));

        $row = $this->response->row_array();

        return $row;
    }

    public function result()
    {
        $this->trigger_events('result');

        $result = $this->response->result();

        return $result;
    }

    public function result_array()
    {
        $this->trigger_events(array('result', 'result_array'));

        $result = $this->response->result_array();

        return $result;
    }

    public function num_rows()
    {
        $this->trigger_events(array('num_rows'));

        $result = $this->response->num_rows();

        return $result;
    }

    /**
     * users
     *
     * @return object Users
     * @author Ben Edmunds
     **/
    public function users($groups = NULL)
    {
        $this->trigger_events('users');

        if (isset($this->_ion_select) && !empty($this->_ion_select)) {
            foreach ($this->_ion_select as $select) {
                $this->db_autenticacion->select($select);
            }

            $this->_ion_select = array();
        } else {
            //default selects
            $this->db_autenticacion->select(array(
                $this->tables['users'] . '.*',
                $this->tables['users'] . '.id as id',
                $this->tables['users'] . '.id as user_id'
            ));
        }

        // filter by group id(s) if passed
        if (isset($groups)) {
            // build an array if only one group was passed
            if (!is_array($groups)) {
                $groups = Array($groups);
            }

            // join and then run a where_in against the group ids
            if (isset($groups) && !empty($groups)) {
                $this->db_autenticacion->distinct();
                $this->db_autenticacion->join(
                    $this->tables['users_groups'],
                    $this->tables['users_groups'] . '.' . $this->join['users'] . '=' . $this->tables['users'] . '.id',
                    'inner'
                );
            }

            // verify if group name or group id was used and create and put elements in different arrays
            $group_ids = array();
            $group_names = array();
            foreach ($groups as $group) {
                if (is_numeric($group)) $group_ids[] = $group;
                else $group_names[] = $group;
            }
            $or_where_in = (!empty($group_ids) && !empty($group_names)) ? 'or_where_in' : 'where_in';
            // if group name was used we do one more join with groups
            if (!empty($group_names)) {
                $this->db_autenticacion->join($this->tables['groups'], $this->tables['users_groups'] . '.' . $this->join['groups'] . ' = ' . $this->tables['groups'] . '.id', 'inner');
                $this->db_autenticacion->where_in($this->tables['groups'] . '.name', $group_names);
            }
            if (!empty($group_ids)) {
                $this->db_autenticacion->{$or_where_in}($this->tables['users_groups'] . '.' . $this->join['groups'], $group_ids);
            }
        }

        $this->trigger_events('extra_where');

        // run each where that was passed
        if (isset($this->_ion_where) && !empty($this->_ion_where)) {
            foreach ($this->_ion_where as $where) {
                $this->db_autenticacion->where($where);
            }

            $this->_ion_where = array();
        }

        if (isset($this->_ion_like) && !empty($this->_ion_like)) {
            foreach ($this->_ion_like as $like) {
                $this->db_autenticacion->or_like($like);
            }

            $this->_ion_like = array();
        }

        if (isset($this->_ion_limit) && isset($this->_ion_offset)) {
            $this->db_autenticacion->limit($this->_ion_limit, $this->_ion_offset);

            $this->_ion_limit = NULL;
            $this->_ion_offset = NULL;
        } else if (isset($this->_ion_limit)) {
            $this->db_autenticacion->limit($this->_ion_limit);

            $this->_ion_limit = NULL;
        }

        // set the order
        if (isset($this->_ion_order_by) && isset($this->_ion_order)) {
            $this->db_autenticacion->order_by($this->_ion_order_by, $this->_ion_order);

            $this->_ion_order = NULL;
            $this->_ion_order_by = NULL;
        }

        $this->response = $this->db_autenticacion->get($this->tables['users']);

        return $this;
    }

    /**
     * user
     *
     * @return object
     * @author Ben Edmunds
     **/
    public function user($id = NULL)
    {
        $this->trigger_events('user');

        // if no id was passed use the current users id
        $id || $id = $this->session->userdata('user_id');

        $this->limit(1);
        $this->order_by($this->tables['users'] . '.id', 'desc');
        $this->where($this->tables['users'] . '.id', $id);

        $this->users();

        return $this;
    }

    /**
     * get_users_groups
     *
     * @return array
     * @author Ben Edmunds
     **/
    public function get_users_groups($id = FALSE)
    {
        $this->trigger_events('get_users_group');

        // if no id was passed use the current users id
        $id || $id = $this->session->userdata('user_id');

        $rs = $this->db_autenticacion->select($this->tables['users_groups'] . '.' . $this->join['groups'] . ' as id, ' . $this->tables['groups'] . '.name, ' . $this->tables['groups'] . '.description')
            ->where($this->tables['users_groups'] . '.' . $this->join['users'], $id)
            ->join($this->tables['groups'], $this->tables['users_groups'] . '.' . $this->join['groups'] . '=' . $this->tables['groups'] . '.id')
            ->get($this->tables['users_groups']);
        // var_dump($this->db_autenticacion->last_query());
        return $rs;
    }

    /**
     * add_to_group
     *
     * @return bool
     * @author Ben Edmunds
     **/
    public function add_to_group($group_ids, $user_id = false)
    {
        $this->trigger_events('add_to_group');

        // if no id was passed use the current users id
        $user_id || $user_id = $this->session->userdata('user_id');

        if (!is_array($group_ids)) {
            $group_ids = array($group_ids);
        }

        $return = 0;

        // Then insert each into the database
        foreach ($group_ids as $group_id) {
            if ($this->db_autenticacion->insert($this->tables['users_groups'], array($this->join['groups'] => (int)$group_id, $this->join['users'] => (int)$user_id))) {
                if (isset($this->_cache_groups[$group_id])) {
                    $group_name = $this->_cache_groups[$group_id];
                } else {
                    $group = $this->group($group_id)->result();
                    $group_name = $group[0]->name;
                    $this->_cache_groups[$group_id] = $group_name;
                }
                $this->_cache_user_in_group[$user_id][$group_id] = $group_name;

                // Return the number of groups added
                $return += 1;
            }
        }

        return $return;
    }

    /**
     * remove_from_group
     *
     * @return bool
     * @author Ben Edmunds
     **/
    public function remove_from_group($group_ids = false, $user_id = false)
    {
        $this->trigger_events('remove_from_group');

        // user id is required
        if (empty($user_id)) {
            return FALSE;
        }

        // if group id(s) are passed remove user from the group(s)
        if (!empty($group_ids)) {
            if (!is_array($group_ids)) {
                $group_ids = array($group_ids);
            }

            foreach ($group_ids as $group_id) {
                $this->db_autenticacion->delete($this->tables['users_groups'], array($this->join['groups'] => (int)$group_id, $this->join['users'] => (int)$user_id));
                if (isset($this->_cache_user_in_group[$user_id]) && isset($this->_cache_user_in_group[$user_id][$group_id])) {
                    unset($this->_cache_user_in_group[$user_id][$group_id]);
                }
            }

            $return = TRUE;
        } // otherwise remove user from all groups
        else {
            if ($return = $this->db_autenticacion->delete($this->tables['users_groups'], array($this->join['users'] => (int)$user_id))) {
                $this->_cache_user_in_group[$user_id] = array();
            }
        }
        return $return;
    }

    /**
     * groups
     *
     * @return object
     * @author Ben Edmunds
     **/
    public function groups()
    {
        $this->trigger_events('groups');

        // run each where that was passed
        if (isset($this->_ion_where) && !empty($this->_ion_where)) {
            foreach ($this->_ion_where as $where) {
                $this->db_autenticacion->where($where);
            }
            $this->_ion_where = array();
        }

        if (isset($this->_ion_limit) && isset($this->_ion_offset)) {
            $this->db_autenticacion->limit($this->_ion_limit, $this->_ion_offset);

            $this->_ion_limit = NULL;
            $this->_ion_offset = NULL;
        } else if (isset($this->_ion_limit)) {
            $this->db_autenticacion->limit($this->_ion_limit);

            $this->_ion_limit = NULL;
        }

        // set the order
        if (isset($this->_ion_order_by) && isset($this->_ion_order)) {
            $this->db_autenticacion->order_by($this->_ion_order_by, $this->_ion_order);
        }

        $this->response = $this->db_autenticacion->get($this->tables['groups']);

        return $this;
    }

    /**
     * group
     *
     * @return object
     * @author Ben Edmunds
     **/
    public function group($id = NULL)
    {
        $this->trigger_events('group');

        if (isset($id)) {
            $this->where($this->tables['groups'] . '.id', $id);
        }

        $this->limit(1);
        $this->order_by('id', 'desc');

        return $this->groups();
    }

    /**
     * update
     *
     * @return bool
     * @author Phil Sturgeon
     **/
    public function update($id, array $data)
    {
        $this->trigger_events('pre_update_user');

        $user = $this->user($id)->row();

        $this->db_autenticacion->trans_begin();

        if (array_key_exists($this->identity_column, $data) && $this->identity_check($data[$this->identity_column]) && $user->{$this->identity_column} !== $data[$this->identity_column]) {
            $this->db_autenticacion->trans_rollback();
            $this->set_error('account_creation_duplicate_identity');

            $this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
            $this->set_error('update_unsuccessful');

            return FALSE;
        }

        // Filter the data passed
        $data = $this->_filter_data($this->tables['users'], $data);

        if (array_key_exists($this->identity_column, $data) || array_key_exists('password', $data) || array_key_exists('email', $data)) {
            if (array_key_exists('password', $data)) {
                if (!empty($data['password'])) {
                    $data['password'] = $this->hash_password($data['password'], $user->salt);
                } else {
                    // unset password so it doesn't effect database entry if no password passed
                    unset($data['password']);
                }
            }
        }

        $this->trigger_events('extra_where');
        $this->db_autenticacion->update($this->tables['users'], $data, array('id' => $user->id));

        if ($this->db_autenticacion->trans_status() === FALSE) {
            $this->db_autenticacion->trans_rollback();

            $this->trigger_events(array('post_update_user', 'post_update_user_unsuccessful'));
            $this->set_error('update_unsuccessful');
            return FALSE;
        }

        $this->db_autenticacion->trans_commit();

        $this->trigger_events(array('post_update_user', 'post_update_user_successful'));
        $this->set_message('update_successful');
        return TRUE;
    }

    /**
     * delete_user
     *
     * @return bool
     * @author Phil Sturgeon
     **/
    public function delete_user($id)
    {
        $this->trigger_events('pre_delete_user');

        $this->db_autenticacion->trans_begin();

        // remove user from groups
        $this->remove_from_group(NULL, $id);

        // delete user from users table should be placed after remove from group
        $this->db_autenticacion->delete($this->tables['users'], array('id' => $id));

        // if user does not exist in database then it returns FALSE else removes the user from groups
        if ($this->db_autenticacion->affected_rows() == 0) {
            return FALSE;
        }

        if ($this->db_autenticacion->trans_status() === FALSE) {
            $this->db_autenticacion->trans_rollback();
            $this->trigger_events(array('post_delete_user', 'post_delete_user_unsuccessful'));
            $this->set_error('delete_unsuccessful');
            return FALSE;
        }

        $this->db_autenticacion->trans_commit();

        $this->trigger_events(array('post_delete_user', 'post_delete_user_successful'));
        $this->set_message('delete_successful');
        return TRUE;
    }

    /**
     * update_last_login
     *
     * @return bool
     * @author Ben Edmunds
     **/
    public function update_last_login($id)
    {
        $this->trigger_events('update_last_login');

        $this->load->helper('date');

        $this->trigger_events('extra_where');

        $this->db_autenticacion->update($this->tables['users'], array('last_login' => time()), array('id' => $id));

        return $this->db_autenticacion->affected_rows() == 1;
    }

    /**
     * set_lang
     *
     * @return bool
     * @author Ben Edmunds
     **/
    public function set_lang($lang = 'en')
    {
        $this->trigger_events('set_lang');

        // if the user_expire is set to zero we'll set the expiration two years from now.
        if ($this->config->item('user_expire', 'ion_auth') === 0) {
            $expire = (60 * 60 * 24 * 365 * 2);
        } // otherwise use what is set
        else {
            $expire = $this->config->item('user_expire', 'ion_auth');
        }

        set_cookie(array(
            'name' => 'lang_code',
            'value' => $lang,
            'expire' => $expire
        ));

        return TRUE;
    }

    /**
     * set_session
     *
     * @return bool
     * @author jrmadsen67
     **/
    public function set_session($user)
    {

        $this->trigger_events('pre_set_session');

        $session_data = array(
            'identity' => $user->{$this->identity_column},
            $this->identity_column => $user->{$this->identity_column},
            'email' => $user->email,
            'user_id' => $user->id, //everyone likes to overwrite id so we'll use user_id
            'old_last_login' => $user->last_login,
            'nombres' => $user->nombres,
            'apellidos' => $user->apellidos,
            'fotografia' => $user->fotografia,
            'cedula' => $user->cedula
        );

        $this->session->set_userdata($session_data);

        $this->trigger_events('post_set_session');

        return TRUE;
    }

    /**
     * remember_user
     *
     * @return bool
     * @author Ben Edmunds
     **/
    public function remember_user($id)
    {
        $this->trigger_events('pre_remember_user');

        if (!$id) {
            return FALSE;
        }

        $user = $this->user($id)->row();

        $salt = $this->salt();

        $this->db_autenticacion->update($this->tables['users'], array('remember_code' => $salt), array('id' => $id));

        if ($this->db_autenticacion->affected_rows() > -1) {
            // if the user_expire is set to zero we'll set the expiration two years from now.
            if ($this->config->item('user_expire', 'ion_auth') === 0) {
                $expire = (60 * 60 * 24 * 365 * 2);
            } // otherwise use what is set
            else {
                $expire = $this->config->item('user_expire', 'ion_auth');
            }

            set_cookie(array(
                'name' => $this->config->item('identity_cookie_name', 'ion_auth'),
                'value' => $user->{$this->identity_column},
                'expire' => $expire
            ));

            set_cookie(array(
                'name' => $this->config->item('remember_cookie_name', 'ion_auth'),
                'value' => $salt,
                'expire' => $expire
            ));

            $this->trigger_events(array('post_remember_user', 'remember_user_successful'));
            return TRUE;
        }

        $this->trigger_events(array('post_remember_user', 'remember_user_unsuccessful'));
        return FALSE;
    }

    /**
     * login_remembed_user
     *
     * @return bool
     * @author Ben Edmunds
     **/
    public function login_remembered_user()
    {
        $this->trigger_events('pre_login_remembered_user');

        // check for valid data
        if (!get_cookie($this->config->item('identity_cookie_name', 'ion_auth'))
            || !get_cookie($this->config->item('remember_cookie_name', 'ion_auth'))
            || !$this->identity_check(get_cookie($this->config->item('identity_cookie_name', 'ion_auth')))
        ) {
            $this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
            return FALSE;
        }

        // get the user
        $this->trigger_events('extra_where');
        $query = $this->db_autenticacion->select($this->identity_column . ', id, email, last_login')
            ->where($this->identity_column, get_cookie($this->config->item('identity_cookie_name', 'ion_auth')))
            ->where('remember_code', get_cookie($this->config->item('remember_cookie_name', 'ion_auth')))
            ->limit(1)
            ->order_by('id', 'desc')
            ->get($this->tables['users']);

        // if the user was found, sign them in
        if ($query->num_rows() == 1) {
            $user = $query->row();

            $this->update_last_login($user->id);

            $this->set_session($user);

            // extend the users cookies if the option is enabled
            if ($this->config->item('user_extend_on_login', 'ion_auth')) {
                $this->remember_user($user->id);
            }

            $this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_successful'));
            return TRUE;
        }

        $this->trigger_events(array('post_login_remembered_user', 'post_login_remembered_user_unsuccessful'));
        return FALSE;
    }


    /**
     * create_group
     *
     * @author aditya menon
     */
    public function create_group($group_name = FALSE, $group_description = '', $additional_data = array())
    {
        // bail if the group name was not passed
        if (!$group_name) {
            $this->set_error('group_name_required');
            return FALSE;
        }

        // bail if the group name already exists
        $existing_group = $this->db_autenticacion->get_where($this->tables['groups'], array('name' => $group_name))->num_rows();
        if ($existing_group !== 0) {
            $this->set_error('group_already_exists');
            return FALSE;
        }

        $data = array('name' => $group_name, 'description' => $group_description);

        // filter out any data passed that doesnt have a matching column in the groups table
        // and merge the set group data and the additional data
        if (!empty($additional_data)) $data = array_merge($this->_filter_data($this->tables['groups'], $additional_data), $data);

        $this->trigger_events('extra_group_set');

        // insert the new group
        $this->db_autenticacion->insert($this->tables['groups'], $data);
        $group_id = $this->db_autenticacion->insert_id();

        // report success
        $this->set_message('group_creation_successful');
        // return the brand new group id
        return $group_id;
    }

    /**
     * update_group
     *
     * @return bool
     * @author aditya menon
     **/
    public function update_group($group_id = FALSE, $group_name = FALSE, $additional_data = array())
    {
        if (empty($group_id)) return FALSE;

        $data = array();

        if (!empty($group_name)) {
            // we are changing the name, so do some checks

            // bail if the group name already exists
            $existing_group = $this->db_autenticacion->get_where($this->tables['groups'], array('name' => $group_name))->row();
            if (isset($existing_group->id) && $existing_group->id != $group_id) {
                $this->set_error('group_already_exists');
                return FALSE;
            }

            $data['name'] = $group_name;
        }

        // restrict change of name of the admin group
        $group = $this->db_autenticacion->get_where($this->tables['groups'], array('id' => $group_id))->row();
        if ($this->config->item('admin_group', 'ion_auth') === $group->name && $group_name !== $group->name) {
            $this->set_error('group_name_admin_not_alter');
            return FALSE;
        }


        // IMPORTANT!! Third parameter was string type $description; this following code is to maintain backward compatibility
        // New projects should work with 3rd param as array
        if (is_string($additional_data)) $additional_data = array('description' => $additional_data);


        // filter out any data passed that doesnt have a matching column in the groups table
        // and merge the set group data and the additional data
        if (!empty($additional_data)) $data = array_merge($this->_filter_data($this->tables['groups'], $additional_data), $data);


        $this->db_autenticacion->update($this->tables['groups'], $data, array('id' => $group_id));

        $this->set_message('group_update_successful');

        return TRUE;
    }

    /**
     * delete_group
     *
     * @return bool
     * @author aditya menon
     **/
    public function delete_group($group_id = FALSE)
    {
        // bail if mandatory param not set
        if (!$group_id || empty($group_id)) {
            return FALSE;
        }
        $group = $this->group($group_id)->row();
        if ($group->name == $this->config->item('admin_group', 'ion_auth')) {
            $this->trigger_events(array('post_delete_group', 'post_delete_group_notallowed'));
            $this->set_error('group_delete_notallowed');
            return FALSE;
        }

        $this->trigger_events('pre_delete_group');

        $this->db_autenticacion->trans_begin();

        // remove all users from this group
        $this->db_autenticacion->delete($this->tables['users_groups'], array($this->join['groups'] => $group_id));
        // remove the group itself
        $this->db_autenticacion->delete($this->tables['groups'], array('id' => $group_id));

        if ($this->db_autenticacion->trans_status() === FALSE) {
            $this->db_autenticacion->trans_rollback();
            $this->trigger_events(array('post_delete_group', 'post_delete_group_unsuccessful'));
            $this->set_error('group_delete_unsuccessful');
            return FALSE;
        }

        $this->db_autenticacion->trans_commit();

        $this->trigger_events(array('post_delete_group', 'post_delete_group_successful'));
        $this->set_message('group_delete_successful');
        return TRUE;
    }

    public function set_hook($event, $name, $class, $method, $arguments)
    {
        $this->_ion_hooks->{$event}[$name] = new stdClass;
        $this->_ion_hooks->{$event}[$name]->class = $class;
        $this->_ion_hooks->{$event}[$name]->method = $method;
        $this->_ion_hooks->{$event}[$name]->arguments = $arguments;
    }

    public function remove_hook($event, $name)
    {
        if (isset($this->_ion_hooks->{$event}[$name])) {
            unset($this->_ion_hooks->{$event}[$name]);
        }
    }

    public function remove_hooks($event)
    {
        if (isset($this->_ion_hooks->$event)) {
            unset($this->_ion_hooks->$event);
        }
    }

    protected function _call_hook($event, $name)
    {
        if (isset($this->_ion_hooks->{$event}[$name]) && method_exists($this->_ion_hooks->{$event}[$name]->class, $this->_ion_hooks->{$event}[$name]->method)) {
            $hook = $this->_ion_hooks->{$event}[$name];

            return call_user_func_array(array($hook->class, $hook->method), $hook->arguments);
        }

        return FALSE;
    }

    public function trigger_events($events)
    {
        if (is_array($events) && !empty($events)) {
            foreach ($events as $event) {
                $this->trigger_events($event);
            }
        } else {
            if (isset($this->_ion_hooks->$events) && !empty($this->_ion_hooks->$events)) {
                foreach ($this->_ion_hooks->$events as $name => $hook) {
                    $this->_call_hook($events, $name);
                }
            }
        }
    }

    /**
     * set_message_delimiters
     *
     * Set the message delimiters
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function set_message_delimiters($start_delimiter, $end_delimiter)
    {
        $this->message_start_delimiter = $start_delimiter;
        $this->message_end_delimiter = $end_delimiter;

        return TRUE;
    }

    /**
     * set_error_delimiters
     *
     * Set the error delimiters
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function set_error_delimiters($start_delimiter, $end_delimiter)
    {
        $this->error_start_delimiter = $start_delimiter;
        $this->error_end_delimiter = $end_delimiter;

        return TRUE;
    }

    /**
     * set_message
     *
     * Set a message
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function set_message($message)
    {
        $this->messages[] = $message;

        return $message;
    }


    /**
     * messages
     *
     * Get the messages
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function messages()
    {
        $_output = '';
        foreach ($this->messages as $message) {
            $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
            $_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
        }

        return $_output;
    }

    /**
     * messages as array
     *
     * Get the messages as an array
     *
     * @return array
     * @author Raul Baldner Junior
     **/
    public function messages_array($langify = TRUE)
    {
        if ($langify) {
            $_output = array();
            foreach ($this->messages as $message) {
                $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
                $_output[] = $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
            }
            return $_output;
        } else {
            return $this->messages;
        }
    }


    /**
     * clear_messages
     *
     * Clear messages
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function clear_messages()
    {
        $this->messages = array();

        return TRUE;
    }


    /**
     * set_error
     *
     * Set an error message
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function set_error($error)
    {
        $this->errors[] = $error;

        return $error;
    }

    /**
     * errors
     *
     * Get the error message
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function errors()
    {
        $_output = '';
        foreach ($this->errors as $error) {
            $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
            $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
        }

        return $_output;
    }

    /**
     * errors as array
     *
     * Get the error messages as an array
     *
     * @return array
     * @author Raul Baldner Junior
     **/
    public function errors_array($langify = TRUE)
    {
        if ($langify) {
            $_output = array();
            foreach ($this->errors as $error) {
                $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
                $_output[] = $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
            }
            return $_output;
        } else {
            return $this->errors;
        }
    }


    /**
     * clear_errors
     *
     * Clear Errors
     *
     * @return void
     * @author Ben Edmunds
     **/
    public function clear_errors()
    {
        $this->errors = array();

        return TRUE;
    }


 function genera_chart_canteras_master(){
        $sql=" select round(sum(m.cubicaje_total),2) as total,c.detalle
from tbl_movimientos  m
inner join tbl_canteras c on c.idtbl_canteras=m.origen
where m.estado!=0  and m.origen!=7 and m.origen!=8 and m.material=2
group by m.origen
order by total ASC ";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();

    }

    protected function _filter_data($table, $data)
    {
        $filtered_data = array();
        $columns = $this->db_autenticacion->list_fields($table);

        if (is_array($data)) {
            foreach ($columns as $column) {
                if (array_key_exists($column, $data))
                    $filtered_data[$column] = $data[$column];
            }
        }

        return $filtered_data;
    }

    protected function _prepare_ip($ip_address)
    {
        // just return the string IP address now for better compatibility
        return $ip_address;
    }

    
    /**
     * register
     *
     * @return bool
     * @author Mathew
     **/
    public function register_nuevo($identity, $password, $email, $additional_data = array(), $groups)
    {
        $this->trigger_events('pre_register');

        $manual_activation = $this->config->item('manual_activation', 'ion_auth');

        if ($this->identity_check($identity)) {
            $this->set_error('account_creation_duplicate_identity');
            return FALSE;
        } elseif (!$this->config->item('default_group', 'ion_auth') && empty($groups)) {
            $this->set_error('account_creation_missing_default_group');
            return FALSE;
        }

        // IP Address
        $ip_address = $this->_prepare_ip($this->input->ip_address());
        $salt = $this->store_salt ? $this->salt() : FALSE;
        $password = $this->hash_password($password, $salt);

        // Users table.
        $data = array(
            $this->identity_column => $identity,
            'password' => $password,
            'email' => $email,
            'ip_address' => $ip_address,
            'created_on' => time(),
            'active' => ($manual_activation === false ? 1 : 0)
        );

        if ($this->store_salt) {
            $data['salt'] = $salt;
        }

        // filter out any data passed that doesnt have a matching column in the users table
        // and merge the set user data and the additional data
        $user_data = array_merge($this->_filter_data($this->tables['users'], $additional_data), $data);

        $this->trigger_events('extra_set');

        $this->db_autenticacion->insert($this->tables['users'], $user_data);

        $id = $this->db_autenticacion->insert_id();

        $data = array(
            'user_id' => $id,
            'group_id' => $groups
        );

        $this->db_autenticacion->insert($this->tables['users_groups'], $data);

        $this->trigger_events('post_register');

        return (isset($id)) ? $id : FALSE;
    }

    function areas()
    {
        $sql = "SELECT * FROM falixso_master.groups";
        $query = $this->db_autenticacion->query($sql);
        return $query->result_array();
    }

    function tipo_solicitudes()
    {
        $sql = "(SELECT count(*) as a
        FROM vue_gateway.tn_eld_edoc_last_stat ls
        INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
        WHERE ls.rgs_dt>='20170101' AND (al.dcm_no LIKE '%AL-001%' OR al.dcm_no LIKE '%AL-002%' OR al.dcm_no LIKE '%AL-003%'))
        UNION
        (SELECT count(*) as a
        FROM vue_gateway.tn_eld_edoc_last_stat ls
        INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
        WHERE ls.rgs_dt>='20170101' AND (al.dcm_no LIKE '%ME-001%' OR al.dcm_no LIKE '%ME-002%' OR al.dcm_no LIKE '%ME-003%'))
        UNION
        (SELECT count(*) as a
        FROM vue_gateway.tn_eld_edoc_last_stat ls
        INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
        WHERE ls.rgs_dt>='20170101' AND (al.dcm_no LIKE '%DM-001%' OR al.dcm_no LIKE '%DM-002%' OR al.dcm_no LIKE '%DM-003%'))
        UNION
        (SELECT count(*) as a
        FROM vue_gateway.tn_eld_edoc_last_stat ls
        INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
        WHERE ls.rgs_dt>='20170101' AND (al.dcm_no LIKE '%CO-001%' OR al.dcm_no LIKE '%CO-002%' OR al.dcm_no LIKE '%CO-003%' OR al.dcm_no LIKE '%CO-005%'))";
        $query = $this->db_vue_gateway->query($sql);
        return $query->result_array();
    }

    function consulta_detalle_solicitudes_data($solicitud)
    {
        if ($solicitud == "A") {
            //--ALIMENTOS
            $sql = "(SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Notificación Sanitaria o Inscripción%') AND
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS INSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Notificación Sanitaria o Inscripción%') AND
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS INSCRIPCIONES
                    UNION                  
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Modificación%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS MODIFICACIONES                                        
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Modificación%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS MODIFICACIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reinscripción%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS REINSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_al_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reinscripción%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS REINSCRIPCIONES";
            $query = $this->db_vue_gateway->query($sql);
            return $query->result_array();
        }
        if ($solicitud == "M") {
            //--Medicamentos
            $sql = "(SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Inscripción%') AND
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS INSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Inscripción%') AND
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS INSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Modificación%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS MODIFICACIONES                    
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Modificación%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS MODIFICACIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reinscripción%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS REINSCRIPCIONES                     
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_me_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reinscripción%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS REINSCRIPCIONES";
            $query = $this->db_vue_gateway->query($sql);
            return $query->result_array();
        }
        if ($solicitud == "DM") {
            //--Dispositivos Médicos
            $sql = "(SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Inscripción%') AND
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS INSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Inscripción%') AND
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS INSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Modificación%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS MODIFICACIONES 
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Modificación%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS MODIFICACIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reinscripción%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS REINSCRIPCIONES                    
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_dm_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reinscripción%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --NO APROBADAS REINSCRIPCIONES";
            $query = $this->db_vue_gateway->query($sql);
            return $query->result_array();
        }
        if ($solicitud == "C") {
            //--Cósmeticos
            $sql = "(SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Notificación%') AND
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS INSCRIPCIONES 
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Notificación%') AND
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --APROBADAS INSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Información de cambios%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS MODIFICACIONES 
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Reconocimiento%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS MODIFICACIONES                     
                     UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Renovación%') AND 
                    ls.afr_prst_cd='510' AND ls.ntfc_cfm_cd='22') --APROBADAS REINSCRIPCIONES
                    UNION
                    (SELECT count(*) 
                    FROM vue_gateway.tn_eld_edoc_last_stat ls
                    INNER JOIN vue_gateway.tn_inh_co_001_it al ON ls.req_no=al.req_no
                    WHERE ls.rgs_dt>='20170101' AND (al.dcm_nm LIKE 'Solicitud de Renovación%') AND 
                    ls.afr_prst_cd='310' AND ls.ntfc_cfm_cd='22') --APROBADAS REINSCRIPCIONES";
            $query = $this->db_vue_gateway->query($sql);
            return $query->result_array();
        }
    }

     function consulta_chart_data()
    {
        //var_dump("HOLA"); die;
        //--Cósmeticos
        $sql = "--SOLICITUDES ALIMENTOS APROBADAS/NO APROBADAS X MESES 
        WITH aprobadas AS(
         SELECT to_char(s.tag,'mm') AS mes,count(t.req_no) AS aprobadas--,count(p.req_no) AS no_aprobadas
         FROM(
           SELECT generate_series(min(rgs_dt)::date,max(rgs_dt)::date,interval '1 day')::date AS tag
           FROM vue_gateway.tn_eld_edoc_last_stat ls WHERE ls.rgs_dt>='20170101'
           ) s
         INNER JOIN vue_gateway.tn_eld_edoc_last_stat t ON (s.tag=t.rgs_dt::date AND t.afr_prst_cd='510' AND t.ntfc_cfm_cd='22' AND 
         (t.dcm_cd LIKE '%AL-001%' OR t.dcm_cd LIKE '%AL-002%' OR t.dcm_cd LIKE '%AL-003%'))
         GROUP BY 1
         ORDER BY 1)
        ,no_aprobadas AS(
         SELECT to_char(s.tag,'mm') AS mes,count(t.req_no) AS no_aprobadas
         FROM(
           SELECT generate_series(min(rgs_dt)::date,max(rgs_dt)::date,interval '1 day')::date AS tag
           FROM vue_gateway.tn_eld_edoc_last_stat ls WHERE ls.rgs_dt>='20170101'
           ) s
         INNER JOIN vue_gateway.tn_eld_edoc_last_stat t ON (s.tag=t.rgs_dt::date AND t.afr_prst_cd='310' AND t.ntfc_cfm_cd='22' AND 
         (t.dcm_cd LIKE '%AL-001%' OR t.dcm_cd LIKE '%AL-002%' OR t.dcm_cd LIKE '%AL-003%'))
         GROUP BY 1
         ORDER BY 1
        )
        SELECT a.mes,a.aprobadas,b.no_aprobadas FROM aprobadas a INNER JOIN no_aprobadas b ON a.mes=b.mes;";
        $query = $this->db_vue_gateway->query($sql);
        $datos = $query->result_array();
        //var_dump($datos); die;
        if (count($datos) > 0) {
            $i = 0;
            foreach ($datos as $valores) {
                if ($datos[$i]["mes"] == "01") {
                    $datos[$i]["mes"] = "Enero";
                }
                if ($datos[$i]["mes"] == "02") {
                    $datos[$i]["mes"] = "Febrero";
                }
                if ($datos[$i]["mes"] == "03") {
                    $datos[$i]["mes"] = "Marzo";
                }
                if ($datos[$i]["mes"] == "04") {
                    $datos[$i]["mes"] = "Abril";
                }
                if ($datos[$i]["mes"] == "05") {
                    $datos[$i]["mes"] = "Mayo";
                }
                if ($datos[$i]["mes"] == "06") {
                    $datos[$i]["mes"] = "Junio";
                }
                if ($datos[$i]["mes"] == "07") {
                    $datos[$i]["mes"] = "Julio";
                }
                if ($datos[$i]["mes"] == "08") {
                    $datos[$i]["mes"] = "Agosto";
                }
                if ($datos[$i]["mes"] == "09") {
                    $datos[$i]["mes"] = "Septiembre";
                }
                if ($datos[$i]["mes"] == "10") {
                    $datos[$i]["mes"] = "Octubre";
                }
                if ($datos[$i]["mes"] == "11") {
                    $datos[$i]["mes"] = "Noviembre";
                }
                if ($datos[$i]["mes"] == "12") {
                    $datos[$i]["mes"] = "Diciembre";
                }
                $i++;
            }
        }

        $sql2 = "WITH finalizadas AS(
             SELECT to_char(s.tag,'mm') AS mes,count(t.numero_permiso) AS finalizadas
             FROM(
               SELECT generate_series(min(pf.fecha_solicitud)::date,max(pf.fecha_solicitud)::date,interval '1 day')::date AS tag
               FROM permisos.permiso_funcionamiento pf WHERE pf.fecha_solicitud>='20170101'
               ) s
             INNER JOIN permisos.permiso_funcionamiento t ON (s.tag=t.fecha_solicitud::date AND t.cat_estado='54' AND t.fecha_vigencia>now())
             GROUP BY 1
             ORDER BY 1)
            ,en_proceso AS(
             SELECT to_char(s.tag,'mm') AS mes,count(t.numero_permiso) AS en_proceso
             FROM(
               SELECT generate_series(min(pf.fecha_solicitud)::date,max(pf.fecha_solicitud)::date,interval '1 day')::date AS tag
               FROM permisos.permiso_funcionamiento pf WHERE pf.fecha_solicitud>='20170101'
               ) s
             INNER JOIN permisos.permiso_funcionamiento t ON (s.tag=t.fecha_solicitud::date AND t.cat_estado IN ('53','57','98','99') AND 
             t.fecha_vigencia>now())
             GROUP BY 1
             ORDER BY 1)
            ,no_finalizadas AS(
             SELECT to_char(s.tag,'mm') AS mes,count(t.numero_permiso) AS no_finalizadas
             FROM(
               SELECT generate_series(min(pf.fecha_solicitud)::date,max(pf.fecha_solicitud)::date,interval '1 day')::date AS tag
               FROM permisos.permiso_funcionamiento pf WHERE pf.fecha_solicitud>='20170101'
               ) s
             INNER JOIN permisos.permiso_funcionamiento t ON (s.tag=t.fecha_solicitud::date AND t.cat_estado IN ('55','64') AND 
             t.fecha_vigencia>now())
             GROUP BY 1
             ORDER BY 1
            )
            SELECT a.mes,a.finalizadas,b.en_proceso,c.no_finalizadas
            FROM finalizadas a 
            LEFT JOIN en_proceso b ON a.mes=b.mes
            LEFT JOIN no_finalizadas c ON a.mes=c.mes;";
        //$query2 = $this->db_permisos_prod->query($sql2);
        //$datos_permisos = $query2->result_array();
        if (count($datos_permisos) > 0) {
            $i = 0;
            foreach ($datos_permisos as $valores) {
                if ($datos_permisos[$i]["mes"] == "01") {
                    $datos_permisos[$i]["mes"] = "Enero";
                }
                if ($datos_permisos[$i]["mes"] == "02") {
                    $datos_permisos[$i]["mes"] = "Febrero";
                }
                if ($datos_permisos[$i]["mes"] == "03") {
                    $datos_permisos[$i]["mes"] = "Marzo";
                }
                if ($datos_permisos[$i]["mes"] == "04") {
                    $datos_permisos[$i]["mes"] = "Abril";
                }
                if ($datos_permisos[$i]["mes"] == "05") {
                    $datos_permisos[$i]["mes"] = "Mayo";
                }
                if ($datos_permisos[$i]["mes"] == "06") {
                    $datos_permisos[$i]["mes"] = "Junio";
                }
                if ($datos_permisos[$i]["mes"] == "07") {
                    $datos_permisos[$i]["mes"] = "Julio";
                }
                if ($datos_permisos[$i]["mes"] == "08") {
                    $datos_permisos[$i]["mes"] = "Agosto";
                }
                if ($datos_permisos[$i]["mes"] == "09") {
                    $datos_permisos[$i]["mes"] = "Septiembre";
                }
                if ($datos_permisos[$i]["mes"] == "10") {
                    $datos_permisos[$i]["mes"] = "Octubre";
                }
                if ($datos_permisos[$i]["mes"] == "11") {
                    $datos_permisos[$i]["mes"] = "Noviembre";
                }
                if ($datos_permisos[$i]["mes"] == "12") {
                    $datos_permisos[$i]["mes"] = "Diciembre";
                }
                $i++;
            }
        }

        $array = [];
        $array[0]  = $datos;
        $array[1]  = $datos_permisos;
        return $array;
    }

    function enviar_password_data($usuarioCorreo)
    {
        $email = $usuarioCorreo . "@controlsanitario.gob.ec";
        $sql = "select * from bd_sisarc.users where email = '" . $email . "' ";
        $query = $this->db_autenticacion->query($sql);
       // var_dump(count($query->result_array())); die;
        if (count($query->result_array()) > 0) {
            $salt = $this->store_salt ? $this->salt() : FALSE;
            $password = $this->hash_password("12345678", $salt);
            $sql = "update bd_sisarc.users set password = '" . $password . "'  where email = '" . $email . "' ";
            $this->db_autenticacion->query($sql);
            if ($this->config->item("envio_email")) {
                $data_mail = array(
                    'contraseña' => "12345678"
                );
                $this->load->library("email");
                $this->email->from($this->config->item("correo_admin"));
                $this->email->to($email);
                $this->email->subject("Cambio de contraseña");
                $message = $this->load->view('templates_mail/reset_password', $data_mail, true);
                $this->email->message($message);
                $this->email->send();
                $respuesta = ['error' => 0, 'mensaje' => "Contraseña ha sido enviada a su correo electrónico"];
            }
        } else {
            $respuesta = ['error' => 1, 'mensaje' => "No se econtro un email asociado con el nombre de usuario ".$usuarioCorreo];
        }
        return $respuesta;
    }

    function nueva_password_data($password_nueva)
    {
        $data = $this->ion_auth->get_user();
        $salt = $this->store_salt ? $this->salt() : FALSE;
        $password = $this->hash_password($password_nueva, $salt);
        $sql = "update bd_sisarc.users set password = '" . $password . "'  where id = '" . $data["user_id"] . "' ";
        $this->db_autenticacion->query($sql);
        if ($this->config->item("envio_email")) {
            $data_mail = array(
                'contraseña' => $password_nueva
            );
            $this->load->library("email");
            $this->email->from($this->config->item("correo_admin"));
            $this->email->to($data["email"]);
            $this->email->subject("Cambio de contraseña");
            $message = $this->load->view('templates_mail/cambiar_password', $data_mail, true);
            $this->email->message($message);
            $this->email->send();
            $respuesta = ['error' => 0, 'mensaje' => "Su contraseña se ha cambiado con éxito, ha sido enviado un correo electrónico con la misma"];
        }
        return $respuesta;
    }

      function subir_foto_data($ruta){
        try{
            $data = $this->ion_auth->get_user();
            $sql = "update bd_sisarc.persona set fotografia = '" . $ruta . "'  where user_id = '" . $data["user_id"] . "' ";
            $this->db_autenticacion->query($sql);
            $query = $this->db_autenticacion->select($this->identity_column . ', users.email, users.id, password, users.active, users.last_login,persona.nombres,persona.apellidos,persona.fotografia,persona.cedula')
                ->join('persona', 'persona.user_id = users.id', 'inner')
                ->where("users.id", $data["user_id"])
                ->limit(1)
                ->order_by('id', 'desc')
                ->get($this->tables['users']);
                $user = $query->row();
                $this->set_session($user);
            $respuesta = ['error' => 0, 'mensaje' => "Su foto ha sido cargada con éxito"];
        }catch(Exception $ex){
            $respuesta = ['error' => 1, 'mensaje' => $ex];
        }
        return $respuesta;
    }
}
