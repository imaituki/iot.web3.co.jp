
-- 処理場マスタ
DROP TABLE IF EXISTS m_disposal;
CREATE TABLE m_disposal (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	disposal_name varchar(25) NOT NULL COMMENT '処理場',
	disposal_furigana varchar(25) NOT NULL COMMENT '処理場フリガナ',
	phone_number varchar(13) COMMENT '電話番号',
	fax_number varchar(13) COMMENT 'FAX番号',
	postal_code varchar(8) COMMENT '郵便番号',
	address varchar(100) COMMENT '住所',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '処理場マスタ';
ALTER TABLE `m_disposal` CONVERT TO CHARACTER SET utf8;
