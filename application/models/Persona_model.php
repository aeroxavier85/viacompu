<?php
if ( ! defined('BASEPATH')) {
    exit( 'No direct script access allowed' );
}
/**
 * Created by PhpStorm.
 * User: Gabriel Guzman
 * Date: 17/10/2016
 * Time: 15:33
 */
class Persona_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db_autenticacion = $this->load->database('autenticacion', TRUE);
    }



    public function registrar($persona_data){

        return $this->db_autenticacion->insert('persona', $persona_data);

    }


}