<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * メールフォーム種別の定数クラス
 * @author ta-ando
 *
 */
class Mail_form_type extends Base_const_lib
{
	/** 項目種別 */
	const BASIC = 'basic';
	const OPTION = 'option';

	/** 項目種別のリスト */
	static $TYPE_ARRAY = array(
		self::BASIC => '基本項目',
		self::OPTION => '追加項目',
	);

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_type_label($key)
	{
		return parent::get_label(self::$TYPE_ARRAY, $key);
	}

	/**
	 * 項目数を取得する。
	 * 
	 * @param unknown_type $mail_form_type
	 */
	public static function get_max($mail_form_type)
	{
		switch ($mail_form_type) {
			case self::BASIC:
				return 9;
				break;
			case self::OPTION:
				return 20;
				break;
			default:
				0;
			break;
		}
	}
}
