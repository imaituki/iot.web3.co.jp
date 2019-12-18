DELETE FROM m_kubun;

/* 固定ページのカテゴリーの区分コード（親区分：なし） */ 
INSERT INTO m_kubun 
(parent_kubun_id,relation_data_type,kubun_type,kubun_code,kubun_value,description,icon_file_name,icon_file_name2,order_number,valid_flg,delete_forbidden_flg,extra_code1,extra_code2,extra_code3,del_flg,insert_user,insert_datetime,update_user,update_datetime) VALUES 
(0,15,1,1,'団体について',null,null,null, 50,'1','1','','','','0',null,null,null,null), 
(0,15,1,2,'Q&A',null,null,null, 60,'1','1','','','','0',null,null,null,null), 
(0,15,1,3,'プライバシーポリシー',null,null,null, 70,'1','1','','','','0',null,null,null,null), 
(0,15,1,4,'ビジネスマナーTOP',null,null,null, 80,'1','1','','','','0',null,null,null,null), 
(0,15,1,5,'1 仕事への思い入れ',null,null,null, 90,'1','1','','','','0',null,null,null,null), 
(0,15,1,6,'2 挨拶、身だしなみ',null,null,null, 100,'1','1','','','','0',null,null,null,null), 
(0,15,1,7,'3 敬語',null,null,null, 110,'1','1','','','','0',null,null,null,null), 
(0,15,1,8,'4 ビジネス文書の書き方',null,null,null, 120,'1','1','','','','0',null,null,null,null), 
(0,15,1,9,'5 電話応対',null,null,null, 130,'1','1','','','','0',null,null,null,null), 
(0,15,1,10,'6 eメールの留意点',null,null,null, 140,'1','1','','','','0',null,null,null,null), 
(0,15,1,11,'7 訪問時、来客時の対応',null,null,null, 150,'1','1','','','','0',null,null,null,null);


/* 共通の年度の区分コード（親区分：なし） */ 
INSERT INTO m_kubun 
(parent_kubun_id,relation_data_type,kubun_type,kubun_code,kubun_value,description,icon_file_name,icon_file_name2,order_number,valid_flg,delete_forbidden_flg,extra_code1,extra_code2,extra_code3,del_flg,insert_user,insert_datetime,update_user,update_datetime) VALUES 
(0,0,30,1,'H22',null,null,null, 50,'1','1','','','','0',null,null,null,null), 
(0,0,30,2,'H23',null,null,null, 60,'1','1','','','','0',null,null,null,null), 
(0,0,30,3,'H24',null,null,null, 70,'1','1','','','','0',null,null,null,null), 
(0,0,30,4,'H25',null,null,null, 80,'1','1','','','','0',null,null,null,null), 
(0,0,30,5,'H26',null,null,null, 90,'1','1','','','','0',null,null,null,null), 
(0,0,30,6,'H27',null,null,null, 100,'1','1','','','','0',null,null,null,null), 
(0,0,30,7,'H28',null,null,null, 110,'1','1','','','','0',null,null,null,null), 
(0,0,30,8,'H29',null,null,null, 120,'1','1','','','','0',null,null,null,null), 
(0,0,30,9,'H30',null,null,null, 130,'1','1','','','','0',null,null,null,null);


/* 共通のカテゴリーの区分コード（親区分：なし） */ 
INSERT INTO m_kubun 
(parent_kubun_id,relation_data_type,kubun_type,kubun_code,kubun_value,description,icon_file_name,icon_file_name2,order_number,valid_flg,delete_forbidden_flg,extra_code1,extra_code2,extra_code3,del_flg,insert_user,insert_datetime,update_user,update_datetime) VALUES 
(0,2,1,1,'セミナー',null,'icon_seminar.png',null, 50,'1','1','','','','0',null,null,null,null), 
(0,2,1,2,'イベント',null,'icon_event.png',null, 60,'1','1','','','','0',null,null,null,null), 
(0,2,1,3,'お知らせ',null,'icon_info.png',null, 70,'1','1','','','','0',null,null,null,null);
