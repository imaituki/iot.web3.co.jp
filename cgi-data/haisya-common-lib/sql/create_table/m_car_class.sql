
-- 車輌扱いマスタ
DROP TABLE IF EXISTS m_car_class;
CREATE TABLE m_car_class(
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	car_class_name varchar(40) NOT NULL COMMENT '車輌扱い名',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '車輌マスタ';
ALTER TABLE `m_car_class` CONVERT TO CHARACTER SET utf8;

SET NAMES utf8;
INSERT INTO m_car_class values
(null, '2t車の扱い', 0, 'nds', NOW(), null, NOW()),
(null, '4t車の扱い', 0, 'nds', NOW(), null, NOW()),
(null, '8t車の扱い', 0, 'nds', NOW(), null, NOW()),
(null, '10t車の扱い', 0, 'nds', NOW(), null, NOW()),
(null, '11t車の扱い', 0, 'nds', NOW(), null, NOW());
