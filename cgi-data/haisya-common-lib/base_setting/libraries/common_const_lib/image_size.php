<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 画像サイズの定数クラス
 * @author ta-ando
 * 
 */
class Image_size extends Base_const_lib
{
	/** 位置 */
	const ONE_BOTTOM = 10;
	const ONE_RIGHT = 11;
	const ONE_LEFT = 12;
	const ONE_TOP = 13;
	const TWO_BOTTOM = 20;
	const TWO_RIGHT = 21;
	const TWO_LEFT = 22;
	const TWO_TOP = 23;
	const THREE_BOTTOM = 30;
	const THREE_TOP = 33;
	const FOUR_BOTTOM = 40;
	const FOUR_TOP = 43;

	/** key=>valueのリスト */
	static $CONST_ARRAY = array(
		self::ONE_BOTTOM => '1枚表示　下キャプション',
		self::ONE_RIGHT => '1枚表示　右キャプション',
		self::ONE_LEFT => '1枚表示　左キャプション',
		self::ONE_TOP => '1枚表示　上キャプション',
		self::TWO_BOTTOM => '2枚表示　下キャプション',
		self::TWO_RIGHT => '2枚表示　右キャプション',
		self::TWO_LEFT => '2枚表示　左キャプション',
		self::TWO_TOP => '2枚表示　上キャプション',
		self::THREE_BOTTOM => '3枚表示　下キャプション',
		self::THREE_TOP => '3枚表示　上キャプション',
		self::FOUR_BOTTOM => '4枚表示　下キャプション',
		self::FOUR_TOP => '4枚表示　上キャプション',
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
	 * 画像サイズによって何枚の画像をひとくくりとして表示するかの枚数を取得する。
	 * 
	 * @param unknown_type $image_size
	 */
	public static function get_image_group_count($image_size)
	{
		switch ($image_size) {
			case self::ONE_BOTTOM:
			case self::ONE_RIGHT:
			case self::ONE_LEFT:
			case self::ONE_TOP:
				return 1;
				break;
			case self::TWO_BOTTOM:
			case self::TWO_RIGHT:
			case self::TWO_LEFT:
			case self::TWO_TOP:
				return 2;
				break;
			case self::THREE_BOTTOM:
			case self::THREE_TOP:
				return 3;
				break;
			case self::FOUR_BOTTOM:
			case self::FOUR_TOP:
				return 4;
				break;
			default:
				return 1 ;
				break;
			}
	}
}
