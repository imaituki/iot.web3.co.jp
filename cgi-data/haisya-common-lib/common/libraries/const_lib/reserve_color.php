<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 配車の表示カラー定数クラス
 * @author ta-ando
 *
 */
class Reserve_color extends Base_const_lib
{
/*
	const LIGHT_CYAN = '#E0FFFF';
	const LIGHT_PINK = '#FFB6C1';
	const DARK_GRAY  = '#A9A9A9';
	const LIGHT_GREEN = '#90EE90';
	const GREEN_YELLOW = '#adff2f';
*/

	/** 工事種別のリスト */
/*
	static $COLOR_ARRAY = array(
		self::LIGHT_CYAN  => '残土（シアン）',
		self::LIGHT_PINK  => 'セメント（ピンク）',
		self::DARK_GRAY   => '運送（グレー）',
		self::LIGHT_GREEN => '社内（グリーン）',
		self::GREEN_YELLOW => '混載（イエロー）'
	);
*/
	static $COLOR_CODE_ARRAY = array(
	    1 => '#C6EEEA',
	    2 => '#FFE5EB',
	    3 => '#EBD5F4',
	    4 => '#B1DE9C',
	    5 => '#F8F7C5'
    );

	/** 工事種別のリスト */
	static $COLOR_ARRAY = array(
		1 => '残土(青)',
		2 => 'セメント(ピンク)',
		3 => '運送(紫)',
		4 => '社内(緑)',
		5 => '混載(黄)'
	);

	/**
	 * クライアント種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$COLOR_ARRAY, $key);
	}

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$COLOR_ARRAY);
	}

	/**
	 * ラベルを取得する（brank label なし)
	 * 
	 * @param unknown_type $key
	 */
    public static function get_dropdown_list_without_blank()
    {
        return self::$COLOR_ARRAY;
    }

}
