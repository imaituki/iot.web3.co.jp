<?php


class p_dbaccess
{

	//データベースOPEN
	function p_dbaccess_p_dbopen(){
	
		//dbに接続
		$db_conn = mysql_connect(_DB_SERVER, _DB_USER, _DB_PASSWD);
		if (!$db_conn)
		{
			die('Not connected : ' . mysql_error());
		}

		mysql_query("SET NAMES utf8",$db_conn);	//文字化けするので指定！！
		
		//カレントDBの設定
		$db_current = mysql_select_db(_DB_NAME, $db_conn);
		if (!$db_current)
		{
		    die ('Can\'t use currentdb : ' . mysql_error());
		}
		
		//返り値の設定
		return $db_conn;
	}

	//データベースOPEN ※一斉メール送信用
	function p_dbaccess_m_dbopen()
	{
		//dbに接続
		$db_conn = mysql_connect(_DM_DB_SERVER, _DM_DB_USER, _DM_DB_PASSWD);
		if (!$db_conn)
		{
			die('Not connected : ' . mysql_error());
		}

		mysql_query("SET NAMES utf8",$db_conn);	//文字化けするので指定！！
		
		//カレントDBの設定
		$db_current = mysql_select_db(_DM_DB_NAME, $db_conn);
		if (!$db_current)
		{
		    die ('Can\'t use currentdb : ' . mysql_error());
		}
		
		//返り値の設定
		return $db_conn;
	}


	//データベースCLOSE
	function p_dbaccess_p_dbclose($db_conn)
	{
		mysql_close($db_conn);
	}

//	//待ち人数の表示
//	public function p_dbaccess_u_wait_person()
//	{
//		$db_sql = "select count(RESERVE_NO) as rec_count from D_RESERVE where `SHOW` Is Null and `CANCEL` Is Null";
//		$db_rs = mysql_query($db_sql);
//		$db_record = mysql_fetch_assoc($db_rs);
//		
//		print "　　現在の待ち人数<br>\n";
//		if (_RESTRIC_PEOPLE == _FLG_NO)
//		{
//			print "<font color=\"#ff0000\">　　　　　" . $db_record["rec_count"] . "</font>人<br>\n";
//		}else{
//			print "<font color=\"#ff0000\">　　　　　" . $db_record["rec_count"] . "</font>組<br>\n";
//		}
//	}



	//グループごとの人数を取得する
	function p_dbaccess_u_select_sammary()
	{
		
		$db_sql = "SELECT `SELECT`, count( * ) AS `WAIT` FROM `D_RESERVE` WHERE `SHOW` IS NULL AND `CANCEL` IS NULL GROUP BY `SELECT`";
		
		$db_rs = mysql_query($db_sql);
		
		while($db_record = mysql_fetch_array($db_rs, MYSQL_ASSOC)){
			
			//echo $db_record["SELECT"] . "-" . $db_record["WAIT"];
			
			//$a_select_sammary[] = array('SELECT' => mb_convert_encoding($db_record["SELECT"], "SJIS", "UTF-8") ,'WAIT' => $db_record["WAIT"]);
			
			$a_select_sammary['SELECT'][] = mb_convert_encoding($db_record["SELECT"], "SJIS", "UTF-8");//
			$a_select_sammary['WAIT'][] = $db_record["WAIT"];
			
		}
		
		return $a_select_sammary;
	}

	//ログイン認証　正解なら会員情報を返す　ダメならfalse
	function p_dbaccess_u_login_check()
	{
		//会員テーブル読み込み
		$n_loop = 0;
		$db_sql = "select * from M_MEMBER where STATE = 'A' and MEMBER_NO = '" . $_POST["no"] .
					"' and PASSWD = '" . $_POST["passwd"] . "'";
		$db_rs = mysql_query($db_sql);
		
		while ($db_record = mysql_fetch_assoc($db_rs))
		{
			$n_loop++;

			$a_recdata["MEMBER_ID"] = $db_record["MEMBER_ID"];
			$a_recdata["MEMBER_NO"] = $db_record["MEMBER_NO"];
			$a_recdata["CIPHER"] = $db_record["CIPHER"];
			$a_recdata["PASSWD"] = $db_record["PASSWD"];
			$a_recdata["NAME"] = $db_record["NAME"];
			$a_recdata["TEL"] = $db_record["TEL"];
			$a_recdata["MAIL"] = $db_record["MAIL"];
			$a_recdata["SEX"] = $db_record["SEX"];
			$a_recdata["BIRTH"] = str_replace("-", "", $db_record["BIRTH"]);
			$a_recdata["NECESSARY"] = $db_record["NECESSARY"];
			$a_recdata["CONF_NEWMAIL"] = $db_record["CONF_NEWMAIL"];
		
		}

		//返り値の設定
		if($n_loop == 0)
		{
			return false;
		}else{
			return $a_recdata;
		}
	}


	//受付中か受付時間外かの表示
	function p_dbaccess_u_close_check()
	{
		$n_check1 = 0;
		$n_check2 = 0;
		$s_date = date('Y') . "-" . date('m') . "-". date('d');
		$s_time = date('H') . ":" . date('i') . ":00";

		////休日設定データのチェック
		$db_sql = "select * from D_CLOSE where `DELETE` Is Null and CLOSE_DATE = '" . $s_date . "'";
		$db_rs = mysql_query($db_sql);

		while ($db_record = mysql_fetch_assoc($db_rs))
		{
			if($db_record["CLOSE_TYPE"] == "A")
			{
				$n_check1++;
			}else{
				if($db_record["BRAKE_TIME_F"] <= $s_time && $db_record["BRAKE_TIME_T"] >= $s_time)
				{
					$n_check1++;
				}
			}
		}

		////受付時間マスタのチェック
		if ($n_check1 == 0)
		{
			$db_sql = "select * from M_OPEN where WEEK_CD = '" . date('w') . "'";
			$db_rs = mysql_query($db_sql);

			while ($db_record = mysql_fetch_assoc($db_rs))
			{
				if($db_record["OPEN_TIME1_F"] <= $s_time && $db_record["OPEN_TIME1_T"] >= $s_time)
				{
					$n_check2++;
				}
				if($db_record["OPEN_TIME2_F"] <= $s_time && $db_record["OPEN_TIME2_T"] >= $s_time)
				{
					$n_check2++;
				}
			}
		}

		//返り値の設定
		if ($n_check1 > 0)
		{
			//休日設定があれば trueを返す
			return true;
		}else{
			if ($n_check2 > 0)
			{
				//受付時間内であれば falseを返す
				return false;
			}else{
				//受付時間外であれば true を返す
				return true;
			}
		}

	}


	//漢字コード変換 SQLServer ⇒ PC
	function p_dbaccess_p_conv_sv_to_pc($s_data)
	{
		return mb_convert_encoding($s_data, "SJIS", "UTF-8");
		//★ここを変更するときは↓のp_dbaccess_u_send_notice_mailの中にある
		//mb_convert_encodingの部分も変更を加えてください。
		
		//★ここを変更するときは↑のp_dbaccess_u_select_sammaryの中にある
		//mb_convert_encodingの部分も変更を加えてください。
	}


	//漢字コード変換 PC ⇒ SQLServer
	function p_dbaccess_p_conv_pc_to_sv($s_data)
	{
		return mb_convert_encoding($s_data, "UTF-8", "SJIS");
	}
	
	//お知らせメールを送信します。
	function p_dbaccess_u_send_notice_mail($p_dbaccess)
	{
	
		if(_NOTICE_BY_TIME==_FLG_YES){//時間でおしらせメール送信の場合
			
			//セレクト文
			$db_sql = "SELECT *,`D_RESERVE`.`NECESSARY` as `NECESSARY1` FROM `D_RESERVE` LEFT JOIN `M_MEMBER` ON `D_RESERVE`.`MEMBER_ID` = `M_MEMBER`.`MEMBER_ID` WHERE `SHOW` IS NULL AND `CANCEL` IS NULL ORDER BY `RESERVE_NO`";
		
			$db_rs = mysql_query($db_sql);
			
			$n_counter = 1;
			
			while($db_record = mysql_fetch_array($db_rs, MYSQL_ASSOC)){
				
				if(($n_counter-1) * _RESTRIC_WAIT_TIME < $db_record['NECESSARY1']){
					//メール必要で、かつ、まだ送ってない
					if($db_record['MAIL_NEED']=="N" AND is_null($db_record['MAIL_SEND'])){
					
						//以下、メール送信
						$s_to = $db_record['MAIL'];
						$s_subject = _NOTICE_MAIL_TITLE;
						
						$s_text = _NOTICE_MAIL_TEXT;
							$s_text = str_replace("%%NAME%%", mb_convert_encoding($db_record['NAME'], "SJIS", "UTF-8"), $s_text);
							$s_text = str_replace("%%NAME_ID%%",$db_record['MEMBER_ID'], $s_text);
							$s_text = str_replace("%%MEMBER_NO%%", $db_record['MEMBER_NO'], $s_text);
							$s_text = str_replace("%%CIPHER%%", $db_record['CIPHER'], $s_text);
						$add_header = "From:" . _NOTICE_MAIL_ADDR;
						mb_language("Japanese");
						mb_internal_encoding("SJIS");
						mb_send_mail($s_to, $s_subject, $s_text, $add_header);
						//以上、メール送信
						
						
						
						//メール送ったよフラグ（＝送信時間）を立てる
						$db_sql = "UPDATE `D_RESERVE` SET `MAIL_SEND` = NOW(), UPD_DATE = NOW() WHERE `RESERVE_NO` = '" . $db_record['RESERVE_NO'] . "'";
						mysql_query($db_sql);
					
					}
				}
				
				$n_counter++;
				
			}
		}else{//時間でおしらせメール送信の場合ではない（＝人数でお知らせメール）
			
			//セレクト文
			$db_sql = "SELECT *, `D_RESERVE`.`NECESSARY` as `NECESSARY1` FROM `D_RESERVE` LEFT JOIN `M_MEMBER` ON `D_RESERVE`.`MEMBER_ID` = `M_MEMBER`.`MEMBER_ID` WHERE `SHOW` IS NULL AND `CANCEL` IS NULL ORDER BY `RESERVE_NO`";

			//取得するLIMITは_NOTICE_COUNTの個数分だけ。（時間でお知らせの場合は全件見る）
			//$db_sql .=  "LIMIT 0," . _NOTICE_COUNT . ";";
			//$db_sql .=  "LIMIT 0," . $db_record['NECESSARY1'] . ";";
			
			
			$db_rs = mysql_query($db_sql);
			
			$n_counter = 1;
			
			while($db_record = mysql_fetch_array($db_rs, MYSQL_ASSOC)){
			
				if(($n_counter-1) < $db_record['NECESSARY1']){
					//メール必要で、かつ、まだ送ってない
					if($db_record['MAIL_NEED']=="N" AND is_null($db_record['MAIL_SEND'])){
					
						//以下、メール送信
						$s_to = $db_record['MAIL'];
						$s_subject = _NOTICE_MAIL_TITLE;
						$s_text = _NOTICE_MAIL_TEXT;
							$s_text = str_replace("%%NAME%%", mb_convert_encoding($db_record['NAME'], "SJIS", "UTF-8"), $s_text);
							$s_text = str_replace("%%NAME_ID%%",$db_record['MEMBER_ID'], $s_text);
							$s_text = str_replace("%%MEMBER_NO%%", $db_record['MEMBER_NO'], $s_text);
							$s_text = str_replace("%%CIPHER%%", $db_record['CIPHER'], $s_text);
						$add_header = "From:" . _NOTICE_MAIL_ADDR;
						mb_language("Japanese");
						mb_internal_encoding("SJIS");
						mb_send_mail($s_to, $s_subject, $s_text, $add_header);
						//以上、メール送信
						
						//メール送ったよフラグ（＝送信時間）を立てる
						$db_sql = "UPDATE `D_RESERVE` SET `MAIL_SEND` = NOW(), UPD_DATE = NOW() WHERE `RESERVE_NO` = '" . $db_record['RESERVE_NO'] . "'";
						mysql_query($db_sql);
					
					}
				}
				
				$n_counter++;
				
			}

			
		}
	}
}




?>