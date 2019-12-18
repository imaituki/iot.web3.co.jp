
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
