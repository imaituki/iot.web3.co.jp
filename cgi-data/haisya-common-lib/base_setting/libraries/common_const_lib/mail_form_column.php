<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * メールフォームの項目の定数クラス
 * @author ta-ando
 *
 */
class Mail_form_column extends Base_const_lib
{
	/** 項目No */
	const NAME = 1;
	const FURIGANA = 2;
	const COMPANY = 3;
	const POSITION = 4;
	const MAIL = 5;
	const PHONE = 6;
	const POSTAL_CODE = 7;
	const PLACE = 8;
	const OTHER_INQUIRY = 9;

	/** 基本項目Noのkey=>valueリスト */
	static $CONST_ARRAY = array(
		self::NAME => 'お名前',
		self::FURIGANA => 'フリガナ',
		self::COMPANY => '会社・団体名',
		self::POSITION => '役職等',
		self::MAIL => 'メールアドレス',
		self::PHONE => '電話番号',
		self::POSTAL_CODE => '郵便番号',
		self::PLACE => '所在地',
		self::OTHER_INQUIRY => 'その他お問い合わせ等',
	);

	/** 基本項目のcolumn_no */
	static $BASIC_COLUMN_ARRAY = array(
		self::NAME,
		self::FURIGANA,
		self::COMPANY,
		self::POSITION,
		self::MAIL,
		self::PHONE,
		self::POSTAL_CODE,
		self::PLACE,
		self::OTHER_INQUIRY,
	);

	/** 基本項目の必須項目 */
	static $REQUIRED_BASIC = array(
		self::NAME,
		self::FURIGANA,
		self::COMPANY,
		self::MAIL,
	);

	/**
	 * 基本項目の項目種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_basic_label($key)
	{
		switch ($key) {
			case self::NAME:
				return 'お名前';
			case self::FURIGANA:
				return 'フリガナ';
			case self::COMPANY:
				return '会社・団体名';
			case self::POSITION:
				return '役職等';
			case self::MAIL:
				return 'メールアドレス';
			case self::PHONE:
				return '電話番号';
			case self::POSTAL_CODE:
				return '郵便番号';
			case self::PLACE:
				return '所在地';
			case self::OTHER_INQUIRY:
				return 'その他お問い合わせ等';
		}
	}

	/**
	 * 項目種別のチェック内容を取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_check_description($key)
	{
		switch ($key) {
			case self::NAME:
				return '氏名用の項目。フリーフォーマット。';
			case self::FURIGANA:
				return 'フリガナの項目。カタカナのチェック有り。';
			case self::COMPANY:
				return '会社・団体名の項目。フリーフォーマット。';
			case self::POSITION:
				return '役職用の項目。フリーフォーマット。';
			case self::MAIL:
				return 'メールアドレスの項目。メール形式、確認用メールのチェック有り。';
			case self::PHONE:
				return '電話番号の項目。電話番号のチェック有り。';
			case self::POSTAL_CODE:
				return '郵便番号の項目。上3桁と下4桁に分かれたテキストボックス。桁と数字のチェック有り。';
			case self::PLACE:
				return '所在地の項目。郵便番号からの住所検索有り。';
			case self::OTHER_INQUIRY:
				return 'その他お問い合わせ用項目。複数行のテキストエリア。';
			default:
				return '';
		}
	}

	/**
	 * 企業種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_type_label($key)
	{
		return parent::get_label(self::$TYPE_ARRAY, $key);
	}
}
