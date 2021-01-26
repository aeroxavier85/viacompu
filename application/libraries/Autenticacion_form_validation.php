<?php if ( defined('BASEPATH') === FALSE ) exit('No direct script access allowed');
// this is used as to extend the base form validation class,

class Autenticacion_form_validation extends CI_Form_validation
{

    function __construct($rules = array())
    {
        parent::__construct($rules);
    }

    public function autenticacion_is_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.]', $table, $field);
        return isset($this->CI->autenticacion)
            ? ($this->CI->autenticacion->limit(1)->get_where($table, array($field => $str))->num_rows() === 0)
            : FALSE;
    }

}