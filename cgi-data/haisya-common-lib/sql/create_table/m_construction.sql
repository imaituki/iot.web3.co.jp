
-- 工事マスタ
DROP TABLE IF EXISTS m_construction;
CREATE TABLE m_construction (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

    construction_status int(11) NOT NULL DEFAULT 0 COMMENT '状態',
    construction_code varchar(10) NOT NULL COMMENT '工事コード',
    customer_id BIGINT NOT NULL COMMENT '顧客ID',

    construction_name varchar(255) NOT NULL COMMENT '現場名',
    construction_address varchar(255) NOT NULL COMMENT '住所',
    latitude varchar(255) COMMENT '緯度',
    longitude varchar(255) COMMENT '経度',

    close_flg tinyint(1) NOT NULL DEFAULT 0 COMMENT '終了フラグ',
    close_date DATETIME COMMENT '終了日',
    close_user varchar(50) COMMENT '終了ユーザー',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '工事マスタ';
ALTER TABLE `m_construction` CONVERT TO CHARACTER SET utf8;
