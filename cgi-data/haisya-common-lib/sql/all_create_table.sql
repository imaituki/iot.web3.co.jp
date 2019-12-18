-- フレームワークが使用するセッション管理用テーブル
DROP TABLE IF EXISTS ci_sessions;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL COMMENT '未設定',
	ip_address varchar(16) DEFAULT '0' NOT NULL COMMENT '未設定',
	user_agent varchar(120) NOT NULL COMMENT '未設定',
	last_activity int(10) unsigned DEFAULT 0 NOT NULL COMMENT '未設定',
	user_data text NOT NULL COMMENT '未設定',
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);
ALTER TABLE `ci_sessions` CONVERT TO CHARACTER SET utf8;

-- 製品テーブル
DROP TABLE IF EXISTS m_item;
CREATE TABLE m_item (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '製品テーブル';
ALTER TABLE `m_item` CONVERT TO CHARACTER SET utf8;


-- 区分マスタ
DROP TABLE IF EXISTS m_kubun;
CREATE TABLE m_kubun (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	parent_kubun_id BIGINT NOT NULL DEFAULT 0 COMMENT '親区分ID',
	relation_data_type int COMMENT '関連データタイプ',
	kubun_type int COMMENT '区分コード',

	kubun_code int NOT NULL COMMENT '区分コード',
	kubun_value varchar(100) NOT NULL  COMMENT '区分値',
	description TEXT COMMENT '詳細',
	order_number int COMMENT 'ソート順',
	icon_file_name TEXT COMMENT 'アイコンファイル名',
	icon_file_name2 TEXT COMMENT 'アイコンファイル名2',
	valid_flg varchar(1) NOT NULL DEFAULT '0' COMMENT '有効フラグ',
	delete_forbidden_flg varchar(1) NOT NULL DEFAULT '0' COMMENT '削除不可フラグ',
	extra_code1 TEXT COMMENT '予備コード1',
	extra_code2 TEXT COMMENT '予備コード2',
	extra_code3 TEXT COMMENT '予備コード3',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '区分マスタ';
ALTER TABLE `m_kubun` CONVERT TO CHARACTER SET utf8;

-- 会員テーブル
DROP TABLE IF EXISTS m_member;
CREATE TABLE m_member (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	email TEXT COMMENT 'メールアドレス',
	password TEXT COMMENT 'パスワード',
	name TEXT COMMENT '氏名',
	furigana TEXT COMMENT 'フリガナ',
	phone_number TEXT COMMENT '電話番号',
	fax_number TEXT COMMENT 'FAX番号',
	position TEXT COMMENT '役職等',
	company_name TEXT COMMENT '企業・団体',
	place TEXT COMMENT '住所',
	member_type int NOT NULL COMMENT '会員種別',

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '会員テーブル';
ALTER TABLE `m_member` CONVERT TO CHARACTER SET utf8;

-- 表組みテーブル
DROP TABLE IF EXISTS m_setting;
CREATE TABLE m_setting (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',
	current_special_type int COMMENT '表示する特集カテゴリー',

	special_start_date DATE COMMENT '特集の表示開始日',
	special_end_date DATE COMMENT '特集の表示終了日',

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '表組みテーブル';
ALTER TABLE `m_setting` CONVERT TO CHARACTER SET utf8;

-- 店舗テーブル
DROP TABLE IF EXISTS m_shop;
CREATE TABLE m_shop (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	management_code TEXT COMMENT '管理コード', 
	place TEXT COMMENT '住所', 
	place2 TEXT COMMENT '住所2', 
	phone_number TEXT COMMENT 'TEL', 
	area bigint COMMENT 'エリア', 
	prefecture_code bigint COMMENT '都道府県', 
	latitude float COMMENT '緯度', 
	longitude float COMMENT '経度', 

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '店舗テーブル';
ALTER TABLE `m_shop` CONVERT TO CHARACTER SET utf8;


-- 共通_管理ユーザーマスタ
DROP TABLE IF EXISTS m_user;
CREATE TABLE m_user (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	user_code varchar(100) NOT NULL COMMENT 'ユーザーコード',
	password varchar(100) NOT NULL COMMENT 'パスワード',
	user_name  varchar(100) COMMENT 'ユーザー名',
	account_type int NOT NULL COMMENT 'アカウント種別',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '共通_管理ユーザーマスタ';
ALTER TABLE `m_user` CONVERT TO CHARACTER SET utf8;


-- 応募テーブル
-- DROP TABLE IF EXISTS t_apply;
CREATE TABLE t_apply (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',
	-- 追加カラムはここに記述

	free_form_id BIGINT NOT NULL COMMENT 'メールフォームID',
	name TEXT COMMENT '名前',
	furigana TEXT COMMENT 'フリガナ',
	company_name TEXT COMMENT '企業団体名',
	position TEXT COMMENT '役職等',
	email TEXT COMMENT 'Eメールアドレス',
	phone_number varchar(20) COMMENT '電話番号',
	postal_code1 varchar(10) COMMENT '郵便番号',
	postal_code2 varchar(10) COMMENT '郵便番号',
	place TEXT COMMENT '住所',
	other_inquiry TEXT COMMENT 'その他お問い合わせ',
	optional_form1  TEXT COMMENT '追加項目1',
	optional_form2  TEXT COMMENT '追加項目2',
	optional_form3  TEXT COMMENT '追加項目3',
	optional_form4  TEXT COMMENT '追加項目4',
	optional_form5  TEXT COMMENT '追加項目5',
	optional_form6  TEXT COMMENT '追加項目6',
	optional_form7  TEXT COMMENT '追加項目7',
	optional_form8  TEXT COMMENT '追加項目8',
	optional_form9  TEXT COMMENT '追加項目9',
	optional_form10 TEXT COMMENT '追加項目10',
	optional_form11 TEXT COMMENT '追加項目11',
	optional_form12 TEXT COMMENT '追加項目12',
	optional_form13 TEXT COMMENT '追加項目13',
	optional_form14 TEXT COMMENT '追加項目14',
	optional_form15 TEXT COMMENT '追加項目15',
	optional_form16 TEXT COMMENT '追加項目16',
	optional_form17 TEXT COMMENT '追加項目17',
	optional_form18 TEXT COMMENT '追加項目18',
	optional_form19 TEXT COMMENT '追加項目19',
	optional_form20 TEXT COMMENT '追加項目20',
	optional_form21 TEXT COMMENT '追加項目21',
	optional_form22 TEXT COMMENT '追加項目22',
	optional_form23 TEXT COMMENT '追加項目23',
	optional_form24 TEXT COMMENT '追加項目24',
	optional_form25 TEXT COMMENT '追加項目25',
	optional_form26 TEXT COMMENT '追加項目26',
	optional_form27 TEXT COMMENT '追加項目27',
	optional_form28 TEXT COMMENT '追加項目28',
	optional_form29 TEXT COMMENT '追加項目29',
	optional_form30 TEXT COMMENT '追加項目30',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '応募テーブル';
ALTER TABLE `t_apply` CONVERT TO CHARACTER SET utf8;

-- 緊急時用メッセージテーブル
DROP TABLE IF EXISTS t_emergency;
CREATE TABLE t_emergency (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データタイプ',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_date DATE COMMENT '登録日',
	post_datetime DATETIME COMMENT '登録日時',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	new_icon_end_date DATETIME COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATETIME COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '緊急時用メッセージテーブル';
ALTER TABLE `t_emergency` CONVERT TO CHARACTER SET utf8;


-- ファイルテーブル
DROP TABLE IF EXISTS t_file;
CREATE TABLE t_file (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	relation_data_type int COMMENT '関連データタイプ',
	relation_data_id bigint COMMENT '関連データID',
	seq_no int COMMENT '連番',
	order_num int COMMENT '並び順No',
	file_type int COMMENT 'ファイル種別',
	file_name TEXT COMMENT 'ファイル名',
	paragraph_title TEXT COMMENT '章タイトル',
	title TEXT COMMENT 'キャプションタイトル(未使用)',
	caption TEXT COMMENT 'キャプション',
	caption_position int COMMENT 'キャプション表示位置',
	image_size int COMMENT '画像表示サイズ',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT 'ファイルテーブル';
ALTER TABLE `t_file` CONVERT TO CHARACTER SET utf8;

-- 自由作成フォームテーブル
DROP TABLE IF EXISTS t_free_form;
CREATE TABLE t_free_form (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	to_email TEXT COMMENT '送信先メールアドレス', 
	to_email_2 TEXT COMMENT '送信先メールアドレス2', 
	from_email TEXT COMMENT '送信元メールアドレス', 
	from_label TEXT COMMENT '差出人', 
	mail_subject TEXT COMMENT 'メール件名', 
	confirm_message TEXT COMMENT '確認メール用メッセージ', 
	mail_signature TEXT COMMENT '署名', 

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '自由作成フォームテーブル';
ALTER TABLE `t_free_form` CONVERT TO CHARACTER SET utf8;

-- 自由作成フォーム用項目テーブル
DROP TABLE IF EXISTS t_free_form_item;
CREATE TABLE t_free_form_item (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	column_no int COMMENT '項目番号',
	column_type TEXT COMMENT 'カラム種別',
	title TEXT COMMENT '項目名',
	choices TEXT COMMENT '選択肢',
	form_type TEXT COMMENT 'フォーム部品種別',
	valid_flg int DEFAULT 0 COMMENT '有効フラグ',
	require_flg int DEFAULT 0 COMMENT '必須フラグ',

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '自由作成フォーム用項目テーブル';
ALTER TABLE `t_free_form_item` CONVERT TO CHARACTER SET utf8;

-- 固定ページテーブル
DROP TABLE IF EXISTS t_freetext;
CREATE TABLE t_freetext (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データタイプ',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_date DATE COMMENT '登録日',
	post_datetime DATETIME COMMENT '登録日時',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	new_icon_end_date DATETIME COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATETIME COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '固定ページテーブル';
ALTER TABLE `t_freetext` CONVERT TO CHARACTER SET utf8;

-- お知らせテーブル
DROP TABLE IF EXISTS t_info;
CREATE TABLE t_info (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',
	 -- site_type TEXT COMMENT '表示サイト', 

	post_link2 TEXT COMMENT 'リンク2', 
	post_link_text2 TEXT COMMENT 'リンク用テキスト2', 
	post_link3 TEXT COMMENT 'リンク3', 
	post_link_text3 TEXT COMMENT 'リンク用テキスト3', 

	free_form_id BIGINT COMMENT '申し込みフォーム', 

	annual TEXT COMMENT '年度', 

	event_start_date DATE COMMENT '開催日', 
	event_date_text TEXT COMMENT '開催日補足テキスト', 
	event_time TEXT COMMENT '開催時間', 
	event_accept_end_date DATE COMMENT '申し込み締め切り日', 
	event_place TEXT COMMENT '会場', 
	instructor TEXT COMMENT '講師', 
	target_person TEXT COMMENT '対象', 

	event_accept_flg TEXT COMMENT '募集有無', 

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT 'お知らせテーブル';
ALTER TABLE `t_info` CONVERT TO CHARACTER SET utf8;

-- キーワード検索履歴テーブル
DROP TABLE IF EXISTS t_keyword_search_result;
CREATE TABLE t_keyword_search_result (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',
	-- 追加カラムはここに記述
	
	search_count int COMMENT '検索カウント',
	last_update_datetime DATETIME COMMENT '最終更新日時',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT 'キーワード検索履歴テーブル';
ALTER TABLE `t_keyword_search_result` CONVERT TO CHARACTER SET utf8;

-- 会員ログイン履歴テーブル
DROP TABLE IF EXISTS t_login_result;
CREATE TABLE t_login_result (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',
	member_id TEXT COMMENT '会員ID',
	login_datetime DATETIME COMMENT 'ログイン日時',

	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '会員ログイン履歴テーブル';
ALTER TABLE `t_login_result` CONVERT TO CHARACTER SET utf8;

-- サンプルデータテーブル
DROP TABLE IF EXISTS t_ndssample;
CREATE TABLE t_ndssample (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	relation_data_type int NOT NULL COMMENT '関連データ種別',
	relation_data_id bigint NOT NULL COMMENT '関連データID',

	data_type int NOT NULL COMMENT 'データタイプ',
	post_title TEXT COMMENT '記事タイトル',
	post_sub_title TEXT COMMENT '記事サブタイトル',
	post_content TEXT COMMENT '記事本文',
	post_link TEXT COMMENT '記事リンク',
	post_link_text TEXT COMMENT '記事リンクテキスト',
	post_status int DEFAULT 0 COMMENT '記事ステータス',
	order_number int COMMENT 'ソート順',
	post_date DATE COMMENT '登録日',
	new_icon_end_date DATE COMMENT 'NEWアイコン表示終了日',
	publish_end_date DATE COMMENT '掲載終了日時',
	draft_flg varchar(1) DEFAULT '0' COMMENT '下書きフラグ',
	-- 追加カラムはここに記述

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT 'サンプルデータテーブル';
ALTER TABLE `t_ndssample` CONVERT TO CHARACTER SET utf8;


-- 関連紐付けテーブル
DROP TABLE IF EXISTS t_relation;
CREATE TABLE t_relation (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	parent_relation_data_type int NOT NULL COMMENT '親の関連データタイプ',
	parent_relation_data_id BIGINT NOT NULL COMMENT '親の関連データID',
	child_relation_data_type int NOT NULL COMMENT '子の関連データタイプ',
	child_kubun_type int COMMENT '子の区分コード',
	child_relation_data_id BIGINT NOT NULL COMMENT '子の関連データID',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '関連紐付けテーブル';
ALTER TABLE `t_relation` CONVERT TO CHARACTER SET utf8;


-- アクセスカウンターテーブル
DROP TABLE IF EXISTS t_simple_counter;
CREATE TABLE t_simple_counter (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	relation_data_type int COMMENT '関連データタイプ',
	relation_data_id bigint COMMENT '関連データID',
	access_count BIGINT  NOT NULL DEFAULT 0  COMMENT 'アクセスカウント',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT 'アクセスカウンターテーブル';
ALTER TABLE `t_simple_counter` CONVERT TO CHARACTER SET utf8;


-- 更新情報テーブル
DROP TABLE IF EXISTS t_wall;
CREATE TABLE t_wall (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	service_code varchar(20) NOT NULL COMMENT 'サービスコード',
	update_menu varchar(200) COMMENT '更新対象項目',
	update_data_id BIGINT COMMENT '更新対象データID',
	update_user_code varchar(200) COMMENT '更新実行ユーザーコード',
	post_date DATETIME COMMENT '更新実行日時',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '更新情報テーブル';
ALTER TABLE `t_wall` CONVERT TO CHARACTER SET utf8;


