<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: Gabriel Guzman
 * Date: 14/10/2016
 * Time: 0:24
 */

$config['useragent'] = 'Codeigniter';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.softwaremonkey.com.ec';
$config['smtp_user'] = 'gguzman@softwaremonkey.com.ec';
$config['smtp_pass'] = 'Mealto708';
$config['smtp_port'] = 587;
$config['smtp_timeout'] = 7;
$config['smtp_crypto'] = 'tls';
$config['smtp_debug'] = 0;
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = TRUE;
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = false;
$config['bcc_batch_size'] = 200;