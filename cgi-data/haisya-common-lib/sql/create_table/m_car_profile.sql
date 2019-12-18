
-- 車輌プロフィール
DROP TABLE IF EXISTS m_car_profile;
CREATE TABLE m_car_profile (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	number_plate varchar(15) NOT NULL COMMENT 'ナンバープレート',
	registration_number varchar(40) NOT NULL COMMENT '許可番号',
    car_class_id BIGINT COMMENT '車輌扱いID',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '車輌プロフィール';
ALTER TABLE `m_car_profile` CONVERT TO CHARACTER SET utf8;

