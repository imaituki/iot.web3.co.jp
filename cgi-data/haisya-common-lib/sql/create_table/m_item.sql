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
