<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

/**
 * 配列に指定されたキーのエラーがセットされている場合にエラーメッセージ用タグを取得する
 * 
 * @param unknown_type $error_list
 * @param unknown_type $key
 */
function error_msg($error_list, $key)
{
	return isset($error_list[$key]) ? h_error($error_list[$key]) : '';
}

// --------------------------------------------------------------------

/**
 * SQL文内で使用するクエスチョンマークをカンマつなぎで出力する関数
 * 
 * @param unknown_type $arg_array
 */
function get_question_str($arg_array, $var = '?') 
{
	
	if ( ! is_array($arg_array))
	{
		return $var;
	}

	$questions = array();

	foreach ($arg_array as $value)
	{
		$questions[] = $var;
	}

	return implode(',', $questions);
}

// --------------------------------------------------------------------

/**
 * 数字を順序通りにデリミタで連結して取得する。
 * 
 * @param unknown_type $start_number
 * @param unknown_type $end_number
 * @param unknown_type $delimiter
 */
function get_cardinal_joined_str($start_number, $end_number, $delimiter = ',') 
{
		$list = array();

		//画像用フォーム部品名をセット
		for ($i = $start_number; $i <= $end_number; $i++)
		{
			//フォーム部品の並び順は1から
			$list[] = $i;
		}

		//並び順としてデリミタつなぎにした文字列を画面に渡す
		return implode($delimiter, $list);
}

// --------------------------------------------------------------------

/**
 * LIKE検索用に文字列を半角スペースで分割し、配列で返す。
 * 
 * @param unknown_type $str
 */
function explode_for_like($str)
{
	if (is_blank($str))
	{
		return array();
	}

	//連続スペースを1つの半角スペースに替えた上で検索
	$replaced = trim($str);
	$replaced = preg_replace('/ +/', ' ', $replaced);
	$replaced = preg_replace('/　+/', ' ', $replaced);

	return explode(' ', $replaced);
}

// --------------------------------------------------------------------

/**
 * 配列が指定した値のみを持つ配列かどうかを取得する。
 * 主として、ブランクのみを要素に持った配列を検知するために使用する。
 * 
 * @param unknown_type $arg_array
 * @param unknown_type $invalid_element 不正な要素（デフォルト:ブランク）
 */
function is_array_has_content($arg_array, $invalid_element = '')
{
	if ( ! is_array($arg_array))
	{
		return FALSE;
	}

	if (empty($arg_array))
	{
		return FALSE;
	}

	//不正な要素の数
	$invalid_count = 0;

	//不正な値の数をカウント
	foreach ($arg_array as $value)
	{
		if ($value === $invalid_element
		or $value === FALSE)
		{
			$invalid_count++;
		}
	}

	//全ての要素が許可しない要素であればFALSE、それ以外はTRUE
	if ($invalid_count === count($arg_array))
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
 * 配列かどうかを確認し、配列でなければ配列に変換する。
 * ・配列であり、中身があればそのまま取得
 * ・配列ではなく、中身があれば1要素の配列にして取得
 * ・それ以外はFALSE
 * 
 * @param unknown_type $param_value
 */
function create_array_param($param_value)
{
	if (is_array_has_content($param_value))
	{
		return $param_value;
	}
	else if ( ! is_array($param_value)
	&& is_not_blank($param_value))
	{
		return array($param_value);
	}
	else
	{
		return FALSE;
	}
}

// --------------------------------------------------------------------

/**
 * ファイルアイコンようの画像ファイル名を取得する
 * 
 * @param unknown_type $file_name
 */
function get_fileext_icon($file_name)
{
	$ext = get_ext($file_name);

	switch ($ext)
	{
		case '.xls':
		case '.xlsx':
			return 'icon_excel.png';
		case '.doc':
		case '.docx':
			return 'icon_word.png';
		case '.jpg':
		case '.jpeg':
		case '.png':
			return 'icon_image.png';
		case '.pdf':
		default:
			return 'icon_pdf.png';
	}
}

// --------------------------------------------------------------------

/**
 * 郵便番号の文字列を生成する。
 * 
 * @param unknown_type $postal_code1
 * @param unknown_type $postal_code2
 */
function create_postal_code_label($postal_code1, $postal_code2)
{
	if (is_not_blank($postal_code1)
	&& is_not_blank($postal_code2))
	{
		return $postal_code1 . '-' . $postal_code2;
	}
	else
	{
		return '';
	}
}

// --------------------------------------------------------------------

/**
 *  50音の行を返します。
 * 
 * @param unknown_type $str
 * @param unknown_type $hira
 */
function get_gyo($str, $hira = FALSE)
{
	$charset='utf-8';

	$hiragana=array(
		array('あ', 'あいうえお'),
		array('か', 'かきくけこがぎぐげご'),
		array('さ', 'さしすせそざじずぜぞ'),
		array('た', 'たちつてとだぢづでど'),
		array('な', 'なにぬねの'),
		array('は', 'はひふへほばびぶべぼぱぴぷぺぽ'),
		array('ま', 'まみむめも'),
		array('や', 'やゆよ'),
		array('ら', 'らりるれろ'),
		array('わ', 'わをん')
	);

	$katakana=array(
		array('ア', 'アイウエオヴ'),
		array('カ', 'カキクケコガギグゲゴ'),
		array('サ', 'サシスセソザジズゼゾ'),
		array('タ', 'タチツテトダヂヅデド'),
		array('ナ', 'ナニヌネノ'),
		array('ハ', 'ハヒフヘホバビブベボパピプペポ'),
		array('マ', 'マミムメモ'),
		array('ヤ', 'ヤユヨ'),
		array('ラ', 'ラリルレロワヲン'),
	);

	if($hira){
		$arr=$hiragana;
		$str=mb_convert_kana($str,"c",$charset);
	}else{
		$arr=$katakana;
		$str=mb_convert_kana($str,"C",$charset);
	}

	$head = mb_substr($str,0,1,$charset);

	foreach($arr as $v){
		if(preg_match("/{$head}/",$v[1])){
			return $v[0];
		}
	}
}

// --------------------------------------------------------------------

/**
 * 濁音、半濁音を含まないカタカナの最初の一字を取得する
 * 
 * @param unknown_type $str
 */
function get_simple_kana_first_letter($str)
{
	$charset='utf-8';

	$arr=array(
		array('ウ', 'ヴ'),

		array('カ', 'ガ'),
		array('キ', 'ギ'),
		array('ク', 'グ'),
		array('ケ', 'ゲ'),
		array('コ', 'ゴ'),

		array('サ', 'ザ'),
		array('シ', 'ジ'),
		array('ス', 'ズ'),
		array('セ', 'ゼ'),
		array('ソ', 'ゾ'),		
		
		array('タ', 'ダ'),
		array('チ', 'ヂ'),
		array('ツ', 'ヅ'),
		array('テ', 'デ'),
		array('ト', 'ド'),

		array('ハ', 'バパ'),
		array('ヒ', 'ビピ'),
		array('フ', 'ブプ'),
		array('ヘ', 'ベペ'),
		array('ホ', 'ボポ'),
	);

	$str=mb_convert_kana($str,"C",$charset);

	$head = mb_substr($str,0,1,$charset);

	foreach($arr as $v){
		if(preg_match("/{$head}/",$v[1])){
			return $v[0];
		}
	}

	return $head;
}

// --------------------------------------------------------------------

/**
 * オブジェクトを要素とする配列を配列を要素とする配列に変換する。
 * 
 * @param unknown_type $list
 */
function convert_objlist_to_arraylist($list)
{
	$ret = array();

	if ( ! $list
	or empty($list))
	{
		return $ret;
	}

	foreach ($list as $entity)
	{
		$tmp = (array)$entity;
		$ret[] = $tmp;
	}

	return $ret;
}

// --------------------------------------------------------------------

/*
 * 取得した数値を別の数値に加工して返す
 */
function create_new_id($bigint_id)
{
	//実際のレコード数をコードから察知されないようにする基準数
	$dummy_max = 7777;

	return is_num($bigint_id)
	       ? ($dummy_max + $bigint_id)
	       : 0;
}

// --------------------------------------------------------------------

/*
 * リストを取得する。
 * 要素：空の要素を含む、key(id) => value(company_name)の連想配列
 * 引数の$listは連想配列であること。
 * @param unknown_type $list
 * @param unknown_type $blank_label
 */
function create_blank_first_list($list, $blank_label = '--')
{
	$tmp = array();
	$tmp[''] = $blank_label;

	if ( ! $list)
	{
		return $tmp;
	}

	foreach ($list as $key => $value)
	{
		$tmp[$key] = $value;
	}

	return $tmp;
}

// --------------------------------------------------------------------

/*
 * 公開側の画像のActive,inactiveを入れ替える
 */
function get_current_navi_image($current_menu, $menu, $file_name)
{
	if ($current_menu == $menu){
		$ext = get_ext($file_name);
		return str_replace($ext, "_on{$ext}", $file_name);
	}
	else
	{
		return $file_name;
	}
}
