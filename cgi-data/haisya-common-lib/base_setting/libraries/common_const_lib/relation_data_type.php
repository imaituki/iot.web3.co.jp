<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 関連データタイプの定数クラス
 * どういった種類のデータかを示すために使用する値を保持するクラスです。
 * [主な使用ケース]
 * ・親子関係を持たせる場合に、親データはどのようなデータかの指定。
 * @author ta-ando
 *
 */
class Relation_data_type extends Base_const_lib
{
	const COMMON = 0;	//共通（デフォルト）
	const EVENT = 1;	//イベント
	const INFO = 2;	//新着情報
	const REPORT = 3;	//事業報告など
	const ORGANIZATION = 4;	//組織
	const KUBUN = 5;	//区分マスタ
	const GROUP = 6;	//グループ
	const ITEM = 7;	//製品
	const GALLERY = 10;
	const RECRUIT = 11;
	const COUPON = 12;
	const INTRODUCTION = 13;
	const EMERGENCY = 14;
	const FREETEXT = 15;
	const APPLY = 16;
	const FREE_FORM = 100;
	const FREE_FORM_ITEM = 101;

	const MEMBER = 37;	//会員
	const TOPIC = 32;	//営業所トピックス
	const TECHNIC = 33;	//技術情報
	const SPECIAL = 34;	//特集
	const CRETOPIC = 35;	//クレトピ
	const DAISERA = 36;	//ダイセラサイン
	const ITEM_SEKOU_RESULTS = 50;	//施工実績
	const ITEM_CUTAWAY = 52;	//標準断面図
	const ITEM_DOWNLOAD = 53;	//ダウンロードファイル
	const ITEM_FREE = 54;	//その他
	const ITEM_KEYWORD = 55;	//検索用キーワード
	const CUTAWAY_FILE = 52;	//断面図ファイル
	const ITEM_FREE_TABLE = 63;	//表組み
	const SETTING = 20;	//表組み
	const DOWNLOAD = 21;	//ダウンロード履歴
	const KEYWORD_SEARCH_RESULT = 22;	//キーワード検索履歴
	const LOGIN_RESULT = 23;	//会員ログイン履歴
	const SHOP = 60;	//店舗
	const NDSSAMPLE = 200;	//サンプルデータ
	/* 定義に追加があればここに記述 */

	/** リスト */
	static $CONST_ARRAY = array(
		self::INFO => 'お知らせ',
		self::ITEM => '製品',
		self::EMERGENCY => '緊急メッセージ',
		self::FREETEXT => '固定ページ',
		self::MEMBER => '会員',
		self::TOPIC => '営業所トピックス',
		self::TECHNIC => '技術情報',
		self::SPECIAL => '特集',
		self::CRETOPIC => 'クレトピ',
		self::DAISERA => 'ダイセラサイン',
		self::ITEM_SEKOU_RESULTS => '施工実績',
		self::ITEM_CUTAWAY => '標準断面図',
		self::ITEM_DOWNLOAD => 'ダウンロードファイル',
		self::ITEM_FREE => '記事',
		self::ITEM_KEYWORD => '検索用キーワード',
		self::CUTAWAY_FILE => '断面図ファイル',
		self::ITEM_FREE_TABLE => '表組み',
		self::SETTING => '表組み',
		self::DOWNLOAD => 'ダウンロード履歴',
		self::KEYWORD_SEARCH_RESULT => 'キーワード検索履歴',
		self::LOGIN_RESULT => '会員ログイン履歴',
		self::SHOP => '店舗',
		self::NDSSAMPLE => 'サンプルデータ',
		/* ラベル変換に追加があればここに記述 */
	);

	/**
	 * 企業種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}

	/**
	 * ディレクトリ名を取得する。
	 * 
	 * @param unknown_type $type
	 */
	static function get_dir_name($type)
	{
		return "uploads_dir{$type}";
	}

	/**
	 * upload_imagesフォルダにデータ種別毎にファイルを持つか、データID毎にファイルを持つかを判定する。
	 * 
	 * @param unknown_type $key
	 */
	static function is_data_own_upload_dir_exists($key)
	{
		switch ($key)
		{
			case self::ITEM_CUTAWAY:
			case self::ITEM_DOWNLOAD:
			case self::ITEM_FREE:
			case self::ITEM_FREE_TABLE:
			case self::ITEM_KEYWORD:
			case self::ITEM_SEKOU_RESULTS:
				return TRUE;
			default:
				return FALSE;
		}
	}
}
