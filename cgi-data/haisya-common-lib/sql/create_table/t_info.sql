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
