<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 下書きフラグの定数クラス
 * @author ta-ando
 *
 */
class Draft_flg extends Base_const_lib
{
	/** 下書きフラグ； 下書き */
	const DRAFT = '1';
	/** 下書きフラグ： 下書きではない */
	const NOT_DRAFT = '0';

	/** 下書きフラグのリスト */
	static $CONST_ARRAY = array(
		self::NOT_DRAFT => '公開',
		self::DRAFT => '非公開',
	);

	/**
	 * 企業種別のラベルを取得する
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
