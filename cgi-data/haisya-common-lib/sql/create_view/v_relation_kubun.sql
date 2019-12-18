
-- 関係テーブルに区分マスタをINNER JOIN したVIEW。
-- 区分コードがSELECTカラムに含まれるので使用しやくしています。
DROP VIEW IF EXISTS v_relation_kubun;
CREATE VIEW v_relation_kubun AS 
SELECT
        MAIN.*
		,KUBUN.relation_data_type AS kubun_relation_data_type
		,KUBUN.kubun_type
		,KUBUN.kubun_code
		,KUBUN.kubun_value
		,KUBUN.icon_file_name
		,KUBUN.icon_file_name2
    FROM
        t_relation AS MAIN 
        INNER JOIN m_kubun AS KUBUN
        	ON KUBUN.id = MAIN.child_relation_data_id
       		AND KUBUN.del_flg <> '1'

WHERE
	MAIN.del_flg <> '1'
	AND MAIN.child_relation_data_type = 5  -- 区分
;
