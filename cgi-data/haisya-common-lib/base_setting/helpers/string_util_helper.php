<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

/**
 * 文字列が空かどうかを判定します。
 * @param unknown_type $str
 */
function is_blank($str) 
{
	return !is_not_blank($str);
}

// --------------------------------------------------------------------

/**
 * 文字列が空ではないかどうかを判定します。
 * @param unknown_type $str
 */
function is_not_blank($str) 
{

	if (!is_array($str)) 
	{
		return (trim($str) == '') ? FALSE : TRUE;
	} 
	else 
	{
		return (!empty($str));
	}
}

// --------------------------------------------------------------------

/**
 * 画面表示用にエスケープした文字列を表示する
 * 
 * @param unknown_type $str
 * @param unknown_type $default_str
 */
function h($input_arg, $default_str = '')
{
	if (is_blank($input_arg)) {
		return $default_str;
	}

	if ( ! is_array($input_arg))
	{
		return htmlspecialchars($input_arg);
	}
	else
	{
		//配列の場合は要素を単純に連結する
		return htmlspecialchars(implode(',', $input_arg));
	}
}

// --------------------------------------------------------------------

/**
 * 改行コードをBRに変換した文字列を取得する。
 * $linkがTRUEの場合はURLをAタグに変換する。
 * 
 * @param unknown_type $str
 * @param unknown_type $link
 */
function h_br($str, $link = TRUE, $default_str = '')
{
	if (is_blank($str))
	{
		return $default_str;
	}

	if ($link)
	{
		return nl2br(url_to_link(htmlspecialchars($str)));
	}
	else
	{
		return nl2br(htmlspecialchars($str));
	}
}

// --------------------------------------------------------------------

/**
 * urlをリンクに変換します。
 *
 * @param unknown_type $content
 */
function url_to_link($content) 
{
	return preg_replace("/(https?:\/\/[-_\.!~*\'a-zA-Z0-9;\/?:\@&=+\$,%#]+)/", '<a href="$1" target="_blank">$1</a>', $content);
}

// --------------------------------------------------------------------

/**
 * エラーを表示します
 * 
 * @param unknown_type $str
 */
function h_error($str)
{
	//configから値を取得するため、Codeigniterのインスタンスの参照を取得
	$CI =& get_instance();

	return is_not_blank($str) ? "{$CI->config->item('error_tag_start')}{$str}{$CI->config->item('error_tag_end')}" : '';
}

/**
 * ブランクの場合に引数で渡されたデフォルト値を取得する。
 * 
 * @param unknown_type $str
 * @param unknown_type $default
 */
function get_default_str($str, $default = null)
{
	return (is_not_blank($str))
	       ? $str
	       : $default;
}

/**
 * HTMLタグと半角スペース、全角スペースを除去する。
 * 
 * @param unknown_type $str
 */
function trim_tags_spaces($str)
{
	return strip_tags(preg_replace('/(\s|　)/','',$str));
}

/**
 * タグと半角スペース、全角スペースを除去した後に、
 * 先頭から指定した文字数までに文字列をカットする。
 * 最後に追加文字を付与する。
 * 
 * @param unknown_type $str
 * @param unknown_type $end_index 2バイト文字の場合は2倍の数値を指定する。5文字⇒10
 * @param unknown_type $add_str
 */
function strimwidth_no_tags_spaces($str, $end_index, $add_str = '')
{
	$trimed_str = trim_tags_spaces($str);

	return mb_strimwidth(
	           $trimed_str,
	           0,
	           $end_index,
	           $add_str
	       );
}

/**
 * 変数に格納されている文字列から指定した数分の空行を除去する。
 * 
 * @param unknown_type $input
 * @param unknown_type $line_end
 * @param unknown_type $blank_lines_max
 */
function trim_lines_from_text($input, $line_end = "\n", $blank_lines_max = 2)
{
	$lines = explode($line_end, $input);

	$blank_count = 1;

	$ret = array();

	foreach ($lines as $line)
	{
		if (is_not_blank($line))
		{
			$blank_count = 1;
		}
		else
		{
			$blank_count++;
		}

		if ($blank_count > $blank_lines_max)
		{
			continue;
		}

		$ret[] = $line;
	}

	return implode($line_end, $ret);
}
