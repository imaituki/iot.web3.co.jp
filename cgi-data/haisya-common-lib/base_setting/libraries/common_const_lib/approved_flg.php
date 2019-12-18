<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 承認フラグの定数クラス
 * @author ta-ando
 *
 */
class Approved_flg extends Base_const_lib
{
	const APPROVED = '1';
	const NOT_APPROVED = '0';

	/** 承認フラグのリスト */
	static $CONST_ARRAY = array(
		self::APPROVED => '承認',
		self::NOT_APPROVED => '未承認',
	);

	/**
	 * 承認フラグのラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}

	/**
	 * ブランクを含むリストを取得する
	 */
	static function get_list_with_blank()
	{
		return array(
				'' => '--',
				self::APPROVED => '承認',
				self::NOT_APPROVED => '未承認',
		);
	}
}
