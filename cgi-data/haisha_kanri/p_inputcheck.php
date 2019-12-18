<?php
// 入力チェッククラス
// 入力OK時は""（空文字）を返す
// $s_dataは入力文字列
// $n_minimumlength    0 : 未入力可、$n_minimumlength = 1以上 : 必須入力で最低桁数指定

class p_inputcheck
{
	//数字のみ
	function p_inputcheck_p_n($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//最低桁数チェック
		{
			return "半角の数字で入力してください。";
		//桁数OKの場合場合
		}else{
			if(is_numeric($s_data) or $s_data=="")
			{
				return "";
			}else{
				return "半角の数字で入力してください。";
			}
		}
	}

	//半角英字（大小）のみ
	function p_inputcheck_p_a($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//最低桁数チェック
		{
			return "半角の英字で入力してください。";
		//桁数OKの場合場合
		}else{
			if(ctype_alpha($s_data))
			{
				return "";
			}else{
				return "半角の英字で入力してください。";
			}
		}
	}

	//半角英字（大小）と数字のみ
	function p_inputcheck_p_an($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//最低桁数チェック
		{
			return "半角の数字か英字で入力してください。";
		//桁数OKの場合場合
		}else{
			if(ctype_alnum($s_data))
			{
				return "";
			}else{
				return "半角の数字か英字で入力してください。";
			}
		}
	}
	

	//漢字チェックルーチン
	function p_inputcheck_p_japanese($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//最低桁数チェック
		{
			return "全角の日本語で入力してください。";
		//桁数OKの場合場合
		}else{
//			if(ereg("[\x41-\x5A|\x61-\x7A|\x30-\x39]+$", $s_data))
//			if(ereg("^[^\x01-\x7E\xA1-\xDF]+$", $s_data))
//			{
//				return "";
//			}else{
//				return "全角の日本語で入力してください。";
//			}
			if( preg_match('/^(?:[\x81-\x9F\xE0-\xFC][\x40-\x7E\x80-\xFC])*$/', $s_data) )
			{
				return "";
			} else {
				return "全角の日本語で入力してください。";
			}
		}
	}


	//電話番号（半角数字とハイフン）
	function p_inputcheck_p_tel($s_data, $n_minimumlength)
	{
		if (strlen($s_data) < $n_minimumlength)
		//最低桁数チェック
		{
			return "先頭が数字で、半角の数字か-(ハイフン)で入力してください。";
		//桁数OKで先頭が-の場合
		}else if(substr($s_data,0,1) == "-"){
			return "先頭が数字で、半角の数字か-(ハイフン)で入力してください。";
		//後はハイフンを除いて全部数字かどうか？
		}else{
			if(is_numeric(str_replace("-", "", $s_data)) or $s_data =="")
			{
				return "";
			}else{
				return "先頭が数字で、半角の数字か-(ハイフン)で入力してください。";
			}
		}
	}


	//日付（半角数字と/と存在チェック）
	//$n_type=0 : /付きの日付　n_type=1 : 数字だけの日付（８桁以外の入力はエラー）
	function p_inputcheck_p_date($s_data, $n_type)
	{
		if($n_type==0){//数字とスラッシュの日付の場合（１０桁）
			
			if(strlen($s_data)==0){
				return "";
			}else{
				
				$a_date = explode('/',$s_data);
				
				if(count($a_date)!=3){
					return "日付の入力形式に誤っているか存在しない日付です。";
				}
				
				if(checkdate($a_date[1],$a_date[2],$a_date[0])){
					return "";
				}else{
					return "日付の入力形式に誤っているか存在しない日付です。";
				}//*/
				
			}

		}else{//数字だけの日付の場合（８桁）
			
			if(strlen($s_data)==8){
			
				if(checkdate(substr($s_data,4,2),substr($s_data,6,2),substr($s_data,0,4))){
					return "";
				}else{
					return "日付の入力形式に誤っているか存在しない日付です。";
				}//*/
				
			}else{
			
				return "日付の入力形式に誤りがあります。";
				
			}
		
		}
	}	
	
	//時間（半角数字と:と存在HH:MM形式）
	function p_inputcheck_p_time($s_data)
	{
		
		if(strlen($s_data)==5 or strlen($s_data)==4){
		
			$pat = "^([0-1][0-9]|[2][0-3]|[0-9]):[0-5][0-9]$";
			if(ereg($pat,$s_data)){
				return "";
			}else{
				return "時刻の入力形式に誤りがあります。";
			}//*/
			
		}elseif(strlen($s_data)==0){
			
			return "";
			
		}else{
			
			return "時刻の入力形式に誤りがあります。";
			
		}

	}

	//カラーコード
	function p_inputcheck_p_color($s_data)
	{
		$pat = "^#[a-fA-F0-9][a-fA-F0-9][a-fA-F0-9][a-fA-F0-9][a-fA-F0-9][a-fA-F0-9]$";
		if(ereg($pat,$s_data)){
			return "";
		}else{
			return "カラーコードの入力形式に誤りがあります。";
		}//*/
		

	}

	//メール（メール形式（使える文字に注意して！））
	function p_inputcheck_p_mail($s_data, $n_minimumlength)
	{

		
		if (strlen($s_data) < $n_minimumlength)
		//最低桁数チェック
		{
			return "メールアドレスの形式に誤りがあります。";
		}else if($s_data == ""){
			return "";
		}else{
		
			$pat = "^[a-z0-9][a-z0-9._-]*@[a-z0-9_-]+\.[a-z0-9._-]*[a-z]$";
			if(ereg($pat,$s_data)){
				return "";
			}else{
				return "メールアドレスの形式に誤りがあります。";
			}
		}
	}	

}
?>