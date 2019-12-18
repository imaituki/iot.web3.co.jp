
-- 顧客マスタ
DROP TABLE IF EXISTS m_customer;
CREATE TABLE m_customer (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	company_name varchar(25) NOT NULL COMMENT '会社名',
	company_furi varchar(25) NOT NULL COMMENT '会社名フリガナ',
	name varchar(25) COMMENT '担当者',
	furi varchar(25) COMMENT '担当者フリガナ',
	position varchar(25) COMMENT '役職等',
	email varchar(50) COMMENT 'メールアドレス',
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
) ENGINE = InnoDB COMMENT '顧客マスタ';
ALTER TABLE `m_customer` CONVERT TO CHARACTER SET utf8;
