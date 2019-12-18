<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 申し込み方法コードの定数クラス
 * @author ta-ando
 *
 */
class Inquiry_type extends Base_const_lib
{
	const FORM = 'form';
	const NOT_USE = 'none';

	/**  申し込みフォーム使用フラグのリスト */
	static $CONST_ARRAY = array(
		self::FORM => 'メールフォームを使用する',
		self::NOT_USE => '使用しない',
	);

	/**
	 * ラベルを取得する。
	 * 条件：コードの一致
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
