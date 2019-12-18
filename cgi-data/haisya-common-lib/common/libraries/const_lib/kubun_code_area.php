<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * サイト種別のカテゴリーコードの定数クラス
 * @author ta-ando
 *
 */
class Kubun_code_area extends Base_const_lib
{
	const HOKKAIDO = 1;	//	北海道・東北
	const TOHOKU = 2;	//	北海道・東北
	const KANTOU = 3;	//	関東
	const CHUUBU = 4;	//	甲信越
	const KINKI = 5;	//	近畿
	const CHUUGOKU = 6;	//	中国
	const SHIKOKU = 7;	//	四国
	const KYUUSYUU = 8;	//	九州
	const WEB = 9;	//	Web

	/**
	 * Aタグのname属性を取得する。
	 * 
	 * @param unknown_type $area_kubun_code
	 */
	public static function get_web_a_name($area_kubun_code)
	{
		switch ($area_kubun_code) {
			case self::HOKKAIDO: 
				return "map01";
			case self::TOHOKU: 
				return "map02";
			case self::KANTOU: 
				return "map03";
			case self::CHUUBU: 
				return "map04";
			case self::KINKI: 
				return "map05";
			case self::CHUUGOKU: 
				return "map06";
			case self::SHIKOKU: 
				return "map07";
			case self::KYUUSYUU: 
				return "map08";
			case self::WEB: 
				return "map09";
			default:
				return "";
			break;
		}
	}
}
