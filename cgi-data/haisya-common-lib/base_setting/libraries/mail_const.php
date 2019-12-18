<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * メール送信で使用する定数やstatic変数を保持するクラス
 *
 * @author ta-ando
 *
 */
class mail_const 
{
	/** メールテンプレートのヘッダ用正規表現 */
	const HEADER_SUBJECT		 = "TEMPLATE_SUBJECT=";
	const HEADER_FROM_NAME		 = "TEMPLATE_FROM_NAME=";
	const HEADER_BODY			 = "TEMPLATE_BODY=";
}

?>
