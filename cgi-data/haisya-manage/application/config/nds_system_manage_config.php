<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| システム名
|--------------------------------------------------------------------------
*/
$config['cms_system_name'] = '配車管理システム';

/*
|--------------------------------------------------------------------------
| エラー表示用タグ
|--------------------------------------------------------------------------
*/
$config['error_tag_start'] = '<div class="alert alert-error">';
$config['error_tag_end'] = '</div>';


/*
|--------------------------------------------------------------------------
| Web素材用パス
|--------------------------------------------------------------------------
| 
| 
*/

switch (ENVIRONMENT)
{
	case 'development':
	case 'testing':
		$config['material_url']	= '/admin/';
		break;
	case 'production':
		$config['material_url']	= '/haisya-manage/';
		break;
	default:
		exit('The application environment is not set correctly.');
}