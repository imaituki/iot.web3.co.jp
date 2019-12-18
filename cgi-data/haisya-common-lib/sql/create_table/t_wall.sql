
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

