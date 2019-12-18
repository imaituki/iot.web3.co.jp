<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * サービスコードの定数クラス
 * @author ta-ando
 *
 */
class Service_code extends Base_const_lib
{
	/** サービス */
	const COMMON = 'common';
	const APP1ST = 'app1st';
	const APP2ND = 'app2nd';

	/** 企業種別のリスト */
	static $CONST_ARRAY = array(
		self::APP1ST => '産業支援ネットワーク',
		self::APP2ND => 'アプリケーション2',
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

	/**
	 * サービスコードをラベルに変換した配列を取得する
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
}
