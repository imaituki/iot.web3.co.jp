<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 配車の定数クラス
 * @author ta-ando
 *
 */
class Reserve_status extends Base_const_lib
{
	const SCHEDULE = '0';
	const START    = '1';
	const CLOSE    = '2';
	const COPY     = '9';

	/** 工事種別のリスト */
	static $CONST_ARRAY = array(
		self::SCHEDULE => '予定',
		self::START    => '作業中',
		self::CLOSE    => '終了',
		self::COPY     => '複製'
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

	/**
	 * ラベルを取得する（brank label なし)
	 * 
	 * @param unknown_type $key
	 */
    public static function get_dropdown_list_without_blank()
    {
        return self::$CONST_ARRAY;
    }
}
