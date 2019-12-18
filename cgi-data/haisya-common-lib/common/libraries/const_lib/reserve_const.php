<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 配車予約の定数クラス
 * @author ta-ando
 *
 */
class Reserve_const extends Base_const_lib
{
    // 時間を 10 倍、30 分は 5 として登録する（例：7時=70, 7時30分=75, 20時=200, 19時30分=195）
	const CALENDAR_START_TIME = 50;
	const CALENDAR_END_TIME   = 190;

	/** アカウントタイプのリスト */
	static $CONST_ARRAY = array(
		self::CALENDAR_START_TIME => '開始時刻',
		self::CALENDAR_END_TIME => '終了時刻',
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
