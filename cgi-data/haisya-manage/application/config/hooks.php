<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

//メンテナンス画面表示用のフック
$hook['pre_system'] = array(
	'class'    => 'Maintenance',
	'function' => 'maintenance',
	'filename' => 'nds_maintenance.php',
	'filepath' => 'hooks',
);


/* End of file hooks.php */
/* Location: ./application/config/hooks.php */