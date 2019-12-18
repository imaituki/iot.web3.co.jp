<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 更新種別の定数クラス
 * @author ta-ando
 *
 */
class Wall_menu extends Base_const_lib
{
	/** 更新アクションコード */
	const ORGANIZATION_REGISTER = 'organization_register';
	const ORGANIZATION_EDIT = 'organization_edit';
	const ORGANIZATION_DELETE = 'organization_delete';
	const ORGANIZATION_DOWNLOAD = 'organization_download';
	const EVENT_REGISTER = 'event_register';
	const EVENT_EDIT = 'event_edit';
	const EVENT_DELETE = 'event_delete';
	const EVENT_DOWNLOAD = 'event_download';
	const REPORT_REGISTER = 'report_register';
	const REPORT_EDIT = 'report_edit';
	const REPORT_DELETE = 'report_delete';
	const INFO_REGISTER = 'info_register';
	const INFO_EDIT = 'info_edit';
	const INFO_DELETE = 'info_delete';
	const INFO_CATEGORY_REGISTER = 'info_category_register';
	const INFO_CATEGORY_EDIT = 'info_category_edit';
	const INFO_CATEGORY_DELETE = 'info_category_delete';
	const USER_REGISTER = 'user_register';
	const USER_EDIT = 'user_edit';
	const USER_DELETE = 'user_delete';
	const USER_DOWNLOAD = 'user_download';
	const APPLICANT_REGISTER = 'applicant_register';
	const APPLICANT_EDIT = 'applicant_edit';
	const APPLICANT_DELETE = 'applicant_delete';
	const APPLICANT_DOWNLOAD = 'applicant_download';
	const INQUIRY_TARGET_REGISTER = 'inquiry_target_register';
	const INQUIRY_TARGET_EDIT = 'inquiry_target_edit';
	const INQUIRY_TARGET_DELETE = 'inquiry_target_delete';
	const EVENT_GROUP_REGISTER = 'event_group_register';
	const EVENT_GROUP_EDIT = 'event_group_edit';
	const EVENT_GROUP_DELETE = 'event_group_delete';
	const SETTING_EDIT = 'setting_edit';
	const ANNUAL_EDIT = 'annual_edit';
	const FIXED_PAGE_EDIT = 'fixed_page_edit';
	const PASSWORD_EDIT = 'password_edit';
	const BOOKING_EDIT = 'booking_edit';
	const ANNUAL_SCHEDULE_REGISTER = 'annual_schedule_register';
	const ANNUAL_SCHEDULE_EDIT = 'annual_schedule_edit';
	const ANNUAL_SCHEDULE_DELETE = 'annual_schedule_delete';

	const INTRODUCTION_REGISTER = 'introduction_register';
	const INTRODUCTION_EDIT = 'introduction_edit';
	const INTRODUCTION_DELETE = 'introduction_delete';
	const GALLERY_REGISTER = 'gallery_register';
	const GALLERY_EDIT = 'gallery_edit';
	const GALLERY_DELETE = 'gallery_delete';
	const COUPON_REGISTER = 'coupon_register';
	const COUPON_EDIT = 'coupon_edit';
	const COUPON_DELETE = 'coupon_delete';
	const RECRUIT_REGISTER = 'recruit_register';
	const RECRUIT_EDIT = 'recruit_edit';
	const RECRUIT_DELETE = 'recruit_delete';
	
	
	/** 更新種別のリスト */
	static $CONST_ARRAY = array(
		self::ORGANIZATION_REGISTER => '組織の新規登録',
		self::ORGANIZATION_EDIT => '組織の編集',
		self::ORGANIZATION_DELETE => '組織の削除',
		self::EVENT_REGISTER => 'イベントの新規登録',
		self::EVENT_EDIT => 'イベントの編集',
		self::EVENT_DELETE => 'イベントの削除',
		self::INFO_REGISTER => '新着情報の新規登録',
		self::INFO_EDIT => '新着情報の編集',
		self::INFO_DELETE => '新着情報の削除',
		self::INFO_CATEGORY_EDIT => '新着情報カテゴリーの編集',
		self::USER_REGISTER => 'ユーザーの新規登録',
		self::USER_EDIT => 'ユーザーの編集',
		self::USER_DELETE => 'ユーザーの削除',
		self::APPLICANT_REGISTER => '応募者の新規登録',
		self::APPLICANT_EDIT => '応募者の編集',
		self::APPLICANT_DELETE => '応募者の削除',
		self::INQUIRY_TARGET_REGISTER => '申し込み先の登録',
		self::INQUIRY_TARGET_EDIT => '申し込み先の編集',
		self::INQUIRY_TARGET_DELETE => '申し込み先の削除',
		self::SETTING_EDIT => 'システム設定変更',
	);

	/**
	 * 更新種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
