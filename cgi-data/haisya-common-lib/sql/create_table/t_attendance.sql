
-- 勤怠
DROP TABLE IF EXISTS t_attendance;
CREATE TABLE t_attendance(
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',
	staff_id BIGINT NOT NULL COMMENT 'スタッフID',
	datetime DATETIME COMMENT '出勤日時',

	soil_2t float(4,2) NOT NULL DEFAULT 0.00 COMMENT '残土(2tDT)',
	soil_4t float(4,2) NOT NULL DEFAULT 0.00 COMMENT '残土(4tDT)',
	soil_point float(7,6) NOT NULL DEFAULT 0 COMMENT '残土(P)',
	cement_1 float(4,2) NOT NULL DEFAULT 0.00 COMMENT 'セメント(高炉)',
	cement_2 float(4,2) NOT NULL DEFAULT 0.00 COMMENT 'セメント(GS200)',
	cement_point float(7,6) NOT NULL DEFAULT 0 COMMENT 'セメント(P)',
	other_point float(7,6) NOT NULL DEFAULT 0 COMMENT 'その他(P)',
	today_point float(7,6) NOT NULL DEFAULT 0 COMMENT '合計(P)',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '勤怠';
ALTER TABLE `t_attendance` CONVERT TO CHARACTER SET utf8;


