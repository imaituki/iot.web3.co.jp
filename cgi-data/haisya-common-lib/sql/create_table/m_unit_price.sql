
-- 単価マスタ
DROP TABLE IF EXISTS m_unit_price ;
CREATE TABLE m_unit_price (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	construction_type_id bigint NOT NULL COMMENT '工種ID',
	construction_detail_id bigint NOT NULL COMMENT '種別ID',
    disposal_id bigint NOT NULL COMMENT '処理場ID',
    car_class_id bigint NOT NULL COMMENT '車両扱いID',

	unit_price int NOT NULL COMMENT '単価',
	point float(7,6) NOT NULL COMMENT 'ポイント',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '単価マスタ';
ALTER TABLE `m_unit_price` CONVERT TO CHARACTER SET utf8;
