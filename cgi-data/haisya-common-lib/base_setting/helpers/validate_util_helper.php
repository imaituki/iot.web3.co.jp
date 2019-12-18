<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

/**
 * 日付チェック（半角数字と/と存在チェック）
 * $delimiter_flg=TRUE : /付きの日付　FALSE : 数字だけの日付（８桁以外の入力はエラー）
 * $n_typeのデフォルト値：0
 * @param unknown_type $s_data
 * @param unknown_type $n_type
 */
function is_date($s_data, $delimiter_flg = TRUE)
{
	if($delimiter_flg)
	{//数字とスラッシュの日付の場合（１０桁）

		if(strlen($s_data) == 0)
		{
			return FALSE;
		}

		if (preg_match('/^[0-9]{4}\/[0-9]{1,2}\/[0-9]{1,2}$/u', $s_data) == 0)
		{
			return FALSE;
		}

		$a_date = explode('/', $s_data);

		if(count($a_date) != 3)
		{
			return FALSE;
		}

		if(checkdate($a_date[1],$a_date[2],$a_date[0]))
		{
			return TRUE;
		}
	}
	else
	{//数字だけの日付の場合（８桁）

		if(strlen($s_data) != 8) 
		{
			return FALSE;
		}

		if (preg_match('/^[0-9]{8}$/u', $s_data) == 0)
		{
			return FALSE;
		}

		if(checkdate(substr($s_data,4,2),substr($s_data,6,2),substr($s_data,0,4)))
		{
			return TRUE;
		}
	}

	return FALSE;
}

// --------------------------------------------------------------------

/**
 * 半角英数字+アンダーバーかどうかのチェックを行います
 * 
 * @param unknown_type $str
 */
function is_alpha_numeric($str) 
{
	if (is_blank($str))
	{
		return TRUE;
	}

	if(preg_match('/^[a-zA-Z0-9_]+$/', $str))
	{
		return TRUE;
	}

	return FALSE;
}

// --------------------------------------------------------------------

/**
 * 半角英数字+symbolかどうかのチェックを行います
 * 
 * @param unknown_type $str
 */
function is_alpha_symbol($str) 
{
	if (is_blank($str))
	{
		return TRUE;
	}

	if((bool)preg_match("/^([a-z =･])+$/i", $str))
	{
		return TRUE;
	}

	return FALSE;
}

// --------------------------------------------------------------------

/**
 * URLかどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_url($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str);
}

// --------------------------------------------------------------------

/**
 * メールアドレスかどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_email($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str);
}

// --------------------------------------------------------------------

/**
 * 電話番号かどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_phone_number($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match('/^[0-9]{2,4}-?[0-9]{2,4}-?[0-9]{3,4}$/', $str);
}

// --------------------------------------------------------------------

/**
 * ひらがなかどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_hiragana($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match('/^[ぁ-ゞー　 ]+$/u', $str);
}

// --------------------------------------------------------------------

/**
 * カタカナかどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_katakana($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match('/^[ァ-ヶー　 ]+$/u', $str);
}

// --------------------------------------------------------------------

/**
 * 文字数が指定した長さ以下かどうかを取得する
 * 
 * @param unknown_type $str
 * @param unknown_type $length
 */
function is_length($str, $length)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (mb_strlen($str) <= $length);
}

// --------------------------------------------------------------------

/**
 * 数値かどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_num($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', $str);
}

// --------------------------------------------------------------------

/**
 * 郵便番号かどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_postal_code($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match( '/^[0-9]{3}-[0-9]{4}$/', $str);
}

// --------------------------------------------------------------------

/**
 * 時間かどうかを取得する
 * 
 * @param unknown_type $str
 */
function is_time($str)
{
	if (is_blank($str))
	{
		return TRUE;
	}

	return (bool)preg_match('/^[0-9]{2}:[0-9]{2}$/', $str);
}

// --------------------------------------------------------------------

/**
 * 整数又は小数かどうかのチェックを行います
 * 
 * @param unknown_type $str
 */
function is_decimal_point($str) 
{
	if (is_blank($str))
	{
		return TRUE;
	}

	if (preg_match('/^([1-9]\d*|0)(\.\d+)?$/', $str))
	{
		return TRUE;
	}

	return FALSE;
}

