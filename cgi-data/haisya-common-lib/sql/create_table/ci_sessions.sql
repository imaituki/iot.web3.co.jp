-- フレームワークが使用するセッション管理用テーブル
DROP TABLE IF EXISTS ci_sessions;
CREATE TABLE IF NOT EXISTS `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL COMMENT '未設定',
	ip_address varchar(16) DEFAULT '0' NOT NULL COMMENT '未設定',
	user_agent varchar(120) NOT NULL COMMENT '未設定',
	last_activity int(10) unsigned DEFAULT 0 NOT NULL COMMENT '未設定',
	user_data text NOT NULL COMMENT '未設定',
	PRIMARY KEY (session_id),
	KEY `last_activity_idx` (`last_activity`)
);
ALTER TABLE `ci_sessions` CONVERT TO CHARACTER SET utf8;
