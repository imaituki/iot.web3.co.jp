
-- 共通_管理ユーザーマスタ
DROP TABLE IF EXISTS m_user;
CREATE TABLE m_user (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	user_code varchar(100) NOT NULL COMMENT 'ユーザーコード',
	password varchar(100) NOT NULL COMMENT 'パスワード',
	user_name  varchar(100) COMMENT 'ユーザー名',
	user_furigana  varchar(100) COMMENT 'ユーザー名（フリガナ）',
	account_type int NOT NULL COMMENT 'アカウント種別',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '共通_管理ユーザーマスタ';
ALTER TABLE `m_user` CONVERT TO CHARACTER SET utf8;
