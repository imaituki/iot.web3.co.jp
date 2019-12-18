
-- 分類マスタ
DROP TABLE IF EXISTS m_construction_category;
CREATE TABLE m_construction_category (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	construction_category_code int NOT NULL COMMENT '分類コード',
	construction_category_name varchar(255) NOT NULL COMMENT '分類名',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '分類マスタ';
ALTER TABLE `m_construction_category` CONVERT TO CHARACTER SET utf8;

SET NAMES utf8;
INSERT INTO m_construction_category values
(null, 1, '残土', 0, 'nds', NOW(), null, NOW()),
(null, 2, 'セメント', 0, 'nds', NOW(), null, NOW()),
(null, 3, '運送', 0, 'nds', NOW(), null, NOW()),
(null, 4, '社内', 0, 'nds', NOW(), null, NOW());
