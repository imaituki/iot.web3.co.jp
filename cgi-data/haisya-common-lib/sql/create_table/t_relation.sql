
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
