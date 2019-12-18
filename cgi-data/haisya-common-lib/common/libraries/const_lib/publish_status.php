<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 掲載状態の定数クラス
 * @author ta-ando
 *
 */
class Publish_status extends Base_const_lib
{
	const PUBLISH = 'publish';
	const BACKNUMBER = 'backnumber';

	/** リスト */
	static $CONST_ARRAY = array(
		self::PUBLISH => '掲載期間中',
		self::BACKNUMBER => '掲載期間終了',
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

	/**
	 * コードをラベルに変換した配列を取得する
	 * 
	 * @param unknown_type $codes
	 */
	public static function conver_label($codes)
	{
		$tmp_labels = array();

		if ($codes && is_array($codes)) 
		{
			foreach ($codes as $key)
			{
				if (is_not_blank(self::get_label($key))) 
				{
					$tmp_labels[] = self::get_label($key);
				}
			}
		}

		return $tmp_labels;
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
