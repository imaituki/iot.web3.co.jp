-- 予約作業
DROP TABLE IF EXISTS t_reserve_detail;
CREATE TABLE t_reserve_detail(
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	reserve_id BIGINT NOT NULL COMMENT '予約ID',
	detail_number INT NOT NULL COMMENT '作業番号',
    construction_type_id BIGINT not null COMMENT '工種ID',
    construction_detail_id BIGINT not null COMMENT '種別ID',
    disposal_id BIGINT not null COMMENT '処理場ID',
    unit_price_id BIGINT not null COMMENT '単価ID',
    car_class_id BIGINT not null COMMENT '車輌扱いID',
    count_estimate float(4,2) COMMENT '数量（予測）',
    count_actual float(4,2) COMMENT '数量（実績）',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '予約作業';
ALTER TABLE `t_reserve_detail` CONVERT TO CHARACTER SET utf8;


