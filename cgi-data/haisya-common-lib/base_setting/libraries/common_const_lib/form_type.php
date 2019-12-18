<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * フォーム種別の定数クラス
 * @author ta-ando
 *
 */
class Form_type extends Base_const_lib
{
	const NONE = '';
	const TEXT = 'text';
	const TEXTAREA = 'textarea';
	const DROPDOWN = 'dropdown';
	const MULTI_CHECKBOX = 'multi_checkbox';
	const RADIOBUTTON = 'radiobutton';

	const FORM_USE = 'form_use';

	/** フォーム種別のリスト */
	static $CONST_ARRAY = array(
		self::NONE => '使用しない',
		self::TEXT => 'テキストボックス（1行の入力エリア）',
		self::TEXTAREA => 'テキストエリア（複数行の入力エリア）',
		self::DROPDOWN => 'ドロップダウン(複数選択不可)',
		self::RADIOBUTTON => 'ラジオボタン(ラジオボタンによる択一選択。未選択も可)',
		self::MULTI_CHECKBOX => 'チェックボックス（複数選択）',
	);

	/** フォーム種別のリスト */
	static $BASIC_CONST_ARRAY = array(
		self::FORM_USE => '使用する',
		self::NONE => '使用しない',
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
	 * 基本項目用のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_basic_label($key)
	{
		return parent::get_label(self::$BASIC_CONST_ARRAY, $key);
	}
}
