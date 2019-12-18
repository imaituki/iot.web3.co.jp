<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 工事種別の定数クラス
 * @author ta-ando
 *
 */
class Construction_status extends Base_const_lib
{
	const PREPARATION = '0';
	const START = '1';
	const CLOSE = '2';

	/** 工事種別のリスト */
	static $CONST_ARRAY = array(
		self::PREPARATION => '準備',
		self::START => '開始',
		self::CLOSE => '終了'
	);

	/**
	 * クライアント種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$CONST_ARRAY);
	}
}
