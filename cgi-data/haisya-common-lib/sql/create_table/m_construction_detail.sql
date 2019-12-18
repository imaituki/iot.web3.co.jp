
-- 種別マスタ
DROP TABLE IF EXISTS m_construction_detail;
CREATE TABLE m_construction_detail (
	id BIGINT NOT NULL AUTO_INCREMENT COMMENT 'ID',

    construction_detail_code BIGINT NOT NULL COMMENT '種別コード',
--    construction_type_id BIGINT NOT NULL COMMENT '工種ID',
	construction_detail_name varchar(255) NOT NULL COMMENT '種別',
	weight int NOT NULL COMMENT '重量',
	unit varchar(255) NOT NULL COMMENT '単位',

	del_flg varchar(1) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
	insert_user varchar(50) COMMENT '登録ユーザー',
	insert_datetime DATETIME COMMENT '登録日時',
	update_user varchar(50) COMMENT '更新ユーザー',
	update_datetime DATETIME COMMENT '更新日時',
	PRIMARY KEY(id)
) ENGINE = InnoDB COMMENT '種別マスタ';
ALTER TABLE `m_construction_detail` CONVERT TO CHARACTER SET utf8;
set names utf8;
INSERT INTO m_construction_detail values 
(null , 1 , '-----'                  , 0    , '台' , 0, 'nds', NOW(), null, NOW())  ,
(null , 2 , 'フレコン(500Kg)'        , 500  , '袋' , 0, 'nds', NOW(), null, NOW())  ,
(null , 3 , 'フレコン(250Kg)'        , 250  , '袋' , 0, 'nds', NOW(), null, NOW())  ,
(null , 4 , 'フレコン(1t)'           , 1000 , 'ton', 0, 'nds', NOW(), null, NOW()) ,
(null , 5 , 'セメント(25Kg)'         , 25   , '袋' , 0, 'nds', NOW(), null, NOW())  ,
(null , 6 , '作業費・運賃・処分料'   , 0    , '台' , 0, 'nds', NOW(), null, NOW())  ,
(null , 7 , '作業費・運賃・材料費'   , 0    , '台' , 0, 'nds', NOW(), null, NOW())  ,
(null , 8 , 'ゴミ運搬作業'           , 0    , '台' , 0, 'nds', NOW(), null, NOW())  ,
(null , 9 , '作業費'                 , 0    , '台' , 0, 'nds', NOW(), null, NOW())  ,
(null , 10 , '処分料'                 , 0    , 'Kg', 0, 'nds', NOW(), null, NOW())  ,
(null , 11 , '運搬'                   , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 12 , 'ギロチン(鉄)'           , 0    , 'Kg', 0, 'nds', NOW(), null, NOW())  ,
(null , 13 , '廃プラスチック類'       , 0    , 'Kg', 0, 'nds', NOW(), null, NOW())  ,
(null , 14 , '木くず'                 , 0    , 'Kg', 0, 'nds', NOW(), null, NOW())  ,
(null , 15 , '保管・運搬・手積作業費' , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 16 , '本社（事務所）'         , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 17 , '作業費・運賃'           , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 18 , '混合B'                  , 0    , 'Kg', 0, 'nds', NOW(), null, NOW())  ,
(null , 19 , 'コンガラ転石まじり'     , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 20 , 'コンガラ'               , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 21 , '残土'                   , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 22 , '応援'                   , 0    , 'H' , 0, 'nds', NOW(), null, NOW())   ,
(null , 23 , '合板類・混合処理'       , 0    , 'Kg', 0, 'nds', NOW(), null, NOW())  ,
(null , 24 , '転石'                   , 0    , '台', 0, 'nds', NOW(), null, NOW())  ,
(null , 25 , '作業'                   , 0    , '日', 0, 'nds', NOW(), null, NOW());
