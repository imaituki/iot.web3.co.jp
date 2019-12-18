<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ファイル種別の定数クラス
 * @author ta-ando
 *
 */
class File_type extends Base_const_lib
{
	/** 画像 */
	const IMAGE = 1;

	/** 添付ファイル(PDFなど) */
	const DOCUMENT = 2;

	/** 社員写真 */
	const SALES_PHOTO = 10;

	/**
	 * 接頭辞を取得する。
	 * 
	 * @param unknown_type $file_type
	 */
	static function get_prefix($file_type)
	{
		switch ($file_type) {
			case self::IMAGE:
				return 'image';
				break;
			case self::DOCUMENT:
				return 'doc';
				break;
			case self::SALES_PHOTO:
				return 'sales_photo';
				break;
			default:
				return 'image';
			break;
		}
	}
}
