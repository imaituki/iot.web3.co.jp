<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 記事種別の定数クラス。
 * @author ta-ando
 *
 */
class Post_type extends Base_const_lib
{
	const POST = 1;	//記事
	const COLUMN = 2;	//コラム

	/** リスト */
	static $CONST_ARRAY = array(
		self::POST => '記事',
		self::COLUMN => 'コラム',
	);

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
