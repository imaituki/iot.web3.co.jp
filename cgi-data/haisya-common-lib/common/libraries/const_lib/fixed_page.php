<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 固定ページの定数クラス
 * @author ta-ando
 *
 */
class Fixed_page extends Base_const_lib
{
	const ITEM01 = 'item01';
	const ITEM02 = 'item02';
	const ITEM03 = 'item03';
	const ITEM04 = 'item04';
	const ITEM05 = 'item05';
	const ITEM06 = 'item06';
	const ITEM07 = 'item07';
	const ITEM08 = 'item08';
	const ITEM09 = 'item09';
	const ITEM10 = 'item10';
	const ITEM11 = 'item11';
	const ITEM12 = 'item12';
	const ITEM13 = 'item13';
	const ITEM14 = 'item14';
	const ITEM15 = 'item15';
	const ITEM16 = 'item16';
	const ITEM17 = 'item17';
	const ITEM18 = 'item18';
	const ITEM19 = 'item19';
	const ITEM20 = 'item20';
	const ITEM21 = 'item21';
	const ITEM22 = 'item22';
	const ITEM23 = 'item23';
	const ITEM24 = 'item24';
	const ITEM25 = 'item25';
	const ITEM26 = 'item26';
	const ITEM27 = 'item27';
	const ITEM28 = 'item28';
	const ITEM29 = 'item29';
	const ITEM30 = 'item30';
	const ITEM31 = 'item31';
	const ITEM32 = 'item32';
	const ITEM33 = 'item33';
	const ITEM34 = 'item34';
	const ITEM35 = 'item35';
	const ITEM36 = 'item36';
	const ITEM37 = 'item37';
	const ITEM38 = 'item38';
	const ITEM39 = 'item39';
	const ITEM40 = 'item40';
	const ITEM41 = 'item41';
	const ITEM42 = 'item42';
	const ITEM43 = 'item43';
	const ITEM44 = 'item44';
	const ITEM45 = 'item45';

	static $CONST_ARRAY =  array(
		self::ITEM01 => 'メディカルテクノおかやまについて',
		self::ITEM02 => '関連リンク',
		self::ITEM03 => 'プライバシーポリシー',
		//self::ITEM04 => '新聞記事',
		//self::ITEM05 => '補助金公募情報',
		self::ITEM06 => '交通アクセス',
		self::ITEM07 => 'パンフレット',
		//self::ITEM08 => '研究者シーズ',
		//self::ITEM09 => 'お役立ち情報',
		//self::ITEM10 => '登録会員募集',
		self::ITEM11 => 'サイトマップ',
		self::ITEM12 => '事業内容',
		//self::ITEM13 => '企業訪問レポート',
		//self::ITEM14 => 'メールマガジン発信情報',
		//self::ITEM15 => '役員名簿',
		self::ITEM16 => '自由ページ1',
		self::ITEM17 => '自由ページ2',
		self::ITEM18 => '自由ページ3',
		self::ITEM19 => '自由ページ4',
		self::ITEM20 => '自由ページ5',
		//self::ITEM21 => '自由ページ6',
		//self::ITEM22 => '自由ページ7',
		//self::ITEM23 => '自由ページ8',
		//self::ITEM24 => '自由ページ9',
		//self::ITEM25 => '自由ページ10',
	);

	/**
	 * 属性のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}

	/**
	 * 公開用の属性のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_released_label($key)
	{
		$fobidden_array =  array(
			self::ITEM16,
			self::ITEM17,
			self::ITEM18,
			self::ITEM19,
			self::ITEM20,
			self::ITEM21,
			self::ITEM22,
			self::ITEM23,
			self::ITEM24,
			self::ITEM25,
		);
		
		if (in_array($key, $fobidden_array))
		{
			return "";
		}

		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
