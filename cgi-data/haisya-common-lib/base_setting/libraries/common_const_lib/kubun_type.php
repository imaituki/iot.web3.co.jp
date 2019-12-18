<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 区分タイプの定数クラス
 * @author ta-ando
 *
 */
class Kubun_type extends Base_const_lib
{
	const COMMON = 0;	//共通（デフォルト）
	const CATEGORY = 1;	//カテゴリー

	const OTHER_ATTRIBUTE = 3;	//その他属性
	const ITEM = 4;	//商品
	const LIMITED_DOWNLOAD_FILE = 5;	//特別会員限定のファイル
	const PARENT_CATEGORY = 6;	//カテゴリー
	const TECHNOLOGY = 7;	//技術
	const FREE_TABLE = 8;	//商品

	const ANNUAL_CODE = 30;

	static $CONST_ARRAY = array(
		self::CATEGORY => 'カテゴリー',
		self::ANNUAL_CODE => '年度',
	);

	/**
	 * サービスコードのラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
