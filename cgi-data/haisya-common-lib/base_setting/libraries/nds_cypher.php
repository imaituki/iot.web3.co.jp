<?php

/**
 * 
 * 可逆暗号化を操作するクラス
 * @author ta-ando
 *
 */
class Nds_cypher {

	//暗号解読表
	static private $a_tbl = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9','-','_');

	/**
	 * 暗号化された文字列を復元する
	 * 
	 * @param unknown_type $code
	 */
	public static function decode($code)
	{

		$a_code = str_split($code);//文字列を一文字づつ配列にセット
		$n_offset = array_search($a_code[0],self::$a_tbl);//最初の一文字目はオフセット値とする

		$s_temp = "";

		for($i=1;$i<count($a_code);$i++)
		{

			$n_tmp = array_search($a_code[$i],self::$a_tbl) - ($i - 1) - $n_offset;//連番を引いてオフセットを引く

			//マイナスなら0x40(64)を足す
			while($n_tmp < 0)
			{
				$n_tmp = $n_tmp + 0x40;
			}

			$s_temp .= sprintf("%06b",$n_tmp);
		}

		$result = "";

		for($i=0;$i<floor(strlen($s_temp) / 8);$i++)
		{
			$result .= chr(bindec(substr($s_temp,$i*8,8)));
		}

		return $result;
	
	}

	/**
	 * 暗号化を行う
	 * 
	 * @param unknown_type $code
	 */
	public static function encode($code)
	{
		$n_offset = self::$a_tbl[floor(rand(0,63))];

		$s_temp1 = $code;

		$s_temp2 = "";

		for($i=0;$i<strlen($s_temp1);$i++)
		{
			$n_temp1 = ord(substr($s_temp1,$i));//１文字づつアスキーコードにする
			
			$s_temp2 .= sprintf("%08b",$n_temp1);//アスキーコードを８桁の２進数にする(蓄積する)
		}
		
		$result = "";
		
		for($i=1;$i<=ceil(strlen($s_temp2)/6);$i++)
		{
			//６桁区切りで分割する。もし６桁に足らなければ、後ろを０埋めする。
			$s_temp3 = sprintf("%0-6s",substr($s_temp2,($i-1)*6,6));

			//２進数を１０進数に（別に１６進数でも良いけど）
			$n_temp2 = bindec($s_temp3);

			$n_temp2 = $n_temp2 + ($i-1) + array_search($n_offset,self::$a_tbl);

			while($n_temp2>63)
			{
				$n_temp2 = $n_temp2 - 0x40;
			}
			
			$result .= self::$a_tbl[$n_temp2];
		}

		return $n_offset . $result;
	}
}
