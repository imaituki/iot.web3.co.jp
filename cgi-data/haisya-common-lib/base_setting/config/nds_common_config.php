<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//ファイルアップロードの初期値
$config['upload_ext_img'] = 'jpg|jpeg|png';
$config['upload_ext_doc'] = 'pdf|jpg|jpeg|png|xls|mpg|mpeg|mp4';
$config['upload_form_prefix_doc'] = 'upload_doc';	//フォームから送られてくるファイルがドキュメントの場合の前置詞
$config['upload_max_size'] = '10000';
$config['upload_max_width'] = '1000';
$config['upload_max_height'] = '1000';

/*
|--------------------------------------------------------------------------
| 画像のアップロードフォルダ
| photo_base_url方は全体管理のURLをセットすること
|--------------------------------------------------------------------------
| 
| 
*/
switch (ENVIRONMENT)
{
	case 'development':
	case 'testing':
//		$config['photo_base_url']	= 'http://localhost/maniwa-manage';
//		$config['photo_base_path']	= '/eclipse/workspace/maniwa-manage/';
		$config['photo_base_url']	= '/admin';
		$config['photo_base_path']	= '/home/nds/www/html/admin/';
		break;
	case 'production':
		$config['photo_base_url']	= '/mnw-adminkanri-page';
		$config['photo_base_path']	= '/virtual/1.33.178.191/home/mnw-adminkanri-page/';
		break;
	default:
		exit('The application environment is not set correctly.');
}
