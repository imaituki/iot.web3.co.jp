
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
