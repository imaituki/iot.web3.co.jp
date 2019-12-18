<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

function get_temp_upload_dir($last_separator_flg = true)
{
	$upload_dir = 'tmp_images';

	$upload_dir = $last_separator_flg ? $upload_dir . DIRECTORY_SEPARATOR
									  : $upload_dir;

	return $upload_dir;
}

// --------------------------------------------------------------------

function create_before_name($filename)
{
	return 'before_' . time() . '_' . $filename;
}

// --------------------------------------------------------------------

function create_tmpfile_name($name)
{
	return date('U') . '-' . $name;
}

// --------------------------------------------------------------------

function is_old_image($file_name)
{
	if (strpos($file_name, 'before_') === FALSE)
	{
		return FALSE;
	}
	else
	{
		return TRUE;
	}
}


// --------------------------------------------------------------------

/**
 * ファイルアップロード時に一時的に作成したファイル名を元の名称に戻します。
 * 
 * @param unknown_type $file_name
 */
function convert_oldfilename_to_originalname($file_name)
{
	return preg_replace('/before_[0-9]+_/', '', $file_name);
}

// --------------------------------------------------------------------

/**
 * ドット付きで拡張子を取得する
 * 
 * @param unknown_type $filename
 */
function get_ext($filename)
{
	return '.' . end(explode('.', $filename));
}
