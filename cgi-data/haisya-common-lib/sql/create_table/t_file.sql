
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
