
-- 工種マスタ
DROP TABLE IF EXISTS m_construction_type;
CREATE TABLE m_construction_type (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

	construction_category_id varchar(25) NOT NULL COMMENT '分類名ID',
	construction_type_code varchar(25) NOT NULL COMMENT '工種コード',
	construction_type_name varchar(25) NOT NULL COMMENT '工種名',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '工種マスタ';
ALTER TABLE `m_construction_type` CONVERT TO CHARACTER SET utf8;

SET NAMES utf8;
INSERT INTO m_construction_type values
(null, 1, 100, '残土処理', 0, 'nds', NOW(), null, NOW()),
(null, 2, 200, 'ジオセットGS-200', 0, 'nds', NOW(), null, NOW()),
(null, 2, 201, '高炉セメント', 0, 'nds', NOW(), null, NOW()),
(null, 2, 202, '普通セメント', 0, 'nds', NOW(), null, NOW()),
(null, 3, 300, '2tDTリース', 0, 'nds', NOW(), null, NOW()),
(null, 3, 301, 'CR-40', 0, 'nds', NOW(), null, NOW()),
(null, 3, 302, 'クラッシャーB40〜0', 0, 'nds', NOW(), null, NOW()),
(null, 3, 303, 'ゴミ運搬作業（仮置き）', 0, 'nds', NOW(), null, NOW()),
(null, 3, 304, 'ゴミ処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 305, 'ゴミ処理（埋設物）', 0, 'nds', NOW(), null, NOW()),
(null, 3, 306, 'コンガラ処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 307, 'コンガラ処理（石混じり）', 0, 'nds', NOW(), null, NOW()),
(null, 3, 308, 'コンガラ転石', 0, 'nds', NOW(), null, NOW()),
(null, 3, 309, 'ｽｷ取残土処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 310, '空袋処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 311, '合板類・混合処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 312, '砕石（アミ下）', 0, 'nds', NOW(), null, NOW()),
(null, 3, 313, '残土運搬処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 314, '場内処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 315, '真砂土', 0, 'nds', NOW(), null, NOW()),
(null, 3, 316, '鉄くず処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 317, '転石撤去処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 318, '同上運賃', 0, 'nds', NOW(), null, NOW()),
(null, 3, 319, '廃プラ処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 320, '舗装ガラ処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 321, '木くず・芝処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 322, '木くず処理', 0, 'nds', NOW(), null, NOW()),
(null, 3, 323, '転石', 0, 'nds', NOW(), null, NOW()),
(null, 3, 324, '先行掘削残土', 0, 'nds', NOW(), null, NOW()),
(null, 3, 325, '施工班応援', 0, 'nds', NOW(), null, NOW()),
(null, 4, 400, '倉出し', 0, 'nds', NOW(), null, NOW()),
(null, 4, 401, '空袋処理', 0, 'nds', NOW(), null, NOW()),
(null, 4, 402, 'スマイル応援', 0, 'nds', NOW(), null, NOW()),
(null, 4, 403, '点呼', 0, 'nds', NOW(), null, NOW()),
(null, 4, 404, 'ジオセットGS-200（仮置）', 0, 'nds', NOW(), null, NOW()),
(null, 4, 405, '高炉セメント（仮置）', 0, 'nds', NOW(), null, NOW()),
(null, 4, 406, '普通セメント（仮置）', 0, 'nds', NOW(), null, NOW()),
(null, 4, 408, '事務処理', 0, 'nds', NOW(), null, NOW()),
(null, 4, 409, '真砂土仮置き', 0, 'nds', NOW(), null, NOW());
