<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$template['active_template'] = 'backend';


/*$template['default']['template'] = 'template';
$template['default']['regions'] = array(
    'header' => array('content' => array('<h1>Templates en codeigniter</h1>')),
    'title',
    'content',
    'sidebar',
    'footer'=>array('content' => array('<p id="copyright">Uno de piera</p>')),
);
$template['default']['parser'] = 'parser';
$template['default']['parser_method'] = 'parse';
$template['default']['parse_template'] = FALSE;*/

//definimos una plantilla para el backend
$template['backend']['template'] = 'backend/template';
$template['backend']['regions'] = array(
    'header',
    'title',
    'content',
    'sidebar',
    'footer',
);
$template['backend']['parser'] = 'parser';
$template['backend']['parser_method'] = 'parse';
$template['backend']['parse_template'] = FALSE;


/* End of file template.php */
/* Location: ./system/application/config/template.php */