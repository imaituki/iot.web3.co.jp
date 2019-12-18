
-- 予約
DROP TABLE IF EXISTS t_reserve;
CREATE TABLE t_reserve(
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	staff_id BIGINT NOT NULL COMMENT '担当者ID',
    reserve_status int not null COMMENT 'ステータス',
    construction_id BIGINT not null COMMENT '工事ID',
    reserve_date date not null COMMENT '予約日',
    reserve_time_start time not null COMMENT '予約開始時刻',
    reserve_time_end time not null COMMENT '予約終了時刻',
    time_start time DEFAULT null COMMENT '開始時刻',
    time_end time DEFAULT null COMMENT '終了時刻',
    car_profile_id BIGINT COMMENT '利用車輌ID',
    memo text COMMENT '備考',
    color text COMMENT 'bgcolor or background-color',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '予約';
ALTER TABLE `t_reserve` CONVERT TO CHARACTER SET utf8;


