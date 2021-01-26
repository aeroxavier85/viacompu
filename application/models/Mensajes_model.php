<?php
if ( ! defined('BASEPATH')) {
    exit( 'No direct script access allowed' );
}

/**
 * Created by PhpStorm.
 * User: Gabriel Guzman
 * Date: 16/09/2016
 * Time: 13:21
 */
class Mensajes_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    public function buscar()
    {

        $this->db->select('*');
        $this->db->from('user_usr');

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            //die("llego!!");
            return $query->result();
        }

        return false;


    }
}