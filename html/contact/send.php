<?php
//-------------------------------------------------------------------
// 作成日： 2019/10/25
// 作成者： 岡田
// 内  容： お問い合わせ
//-------------------------------------------------------------------

//----------------------------------------
//  共通設定
//----------------------------------------
require "./config.ini";

//----------------------------------------
//  初期化
//----------------------------------------
$message = NULL;

// 操作クラス
$objManage  = new DB_manage( _DNS );
$objContact = new FT_contact( $_ARR_MAIL["contact"]["savePath"] );


//----------------------------------------
//  メール送信
//----------------------------------------
// エラーチェック
if( empty( $message["ng"] ) ) {

	// メール設定情報の取得
	$mail_conf = $objContact->GetDataXml( $objContact->GetArrayXml() );
	
	// データ変換
	if( !empty( $arr_post["mail"] ) ) {
		$arr_post["mail"] = mb_convert_kana( $arr_post["mail"], "a", "utf-8" );
	}

	//----------------------------------------
	//  文字コード設定
	//----------------------------------------
	// 言語設定
	mb_language("Japanese");

	// 内部エンコーディング
	mb_internal_encoding("UTF-8");


	//----------------------------------------
	//  メール生成
	//----------------------------------------
	// smarty設定
	$smarty = new MySmarty("front");
	$smarty->compile_dir .= "contact/";

	// テンプレートに設定
	$smarty->assign( "arr_post"  , $arr_post   );
	$smarty->assign( "mail_conf" , $mail_conf  );
	$smarty->assign( "message"   , $message    );



	// テンプレートの取得
	$mail = $smarty->fetch( "mail.tpl" );

	// お客様宛メール合体と改行
	$mail1 = str_replace( "\r", "\n", str_replace( "\r\n", "\n", ( $mail_conf["user"]["header"] . "\n\n" . $mail . "\n" . $mail_conf["user"]["footer"] ) ) );

	// 管理者宛てのメールにユーザーエージェントを記載
	$mail2 = $mail1. "\n\n--------------------------------------------------------
■ お客様の環境情報
--------------------------------------------------------
■ IPアドレス
". $_SERVER["REMOTE_ADDR"]. "
■ ユーザーエージェント
". $_SERVER["HTTP_USER_AGENT"]. "

--------------------------------------------------------";

	// 改行
	$mail2 = str_replace( "\r", "\n", str_replace( "\r\n", "\n", ( $mail_conf["master"]["header"] . "\n\n" . $mail2 . "\n" . $mail_conf["master"]["footer"] ) ) );

	//----------------------------------------
	//  お客様用
	//----------------------------------------
	// ヘッダー
	$header1  = "From: " . mb_encode_mimeheader( "ウェブクリエイティブ株式会社" ) . " <" . $mail_conf["info"]["admin_mail"] . ">\n";
	$header1 .= "Bcc: "  . $mail_conf["info"]["bcc_mail"] . "\n";
	$header1 .= "Content-Type: text/plain; charset=iso-2022-jp\n";
	$header1 .= "Content-Transfer-Encoding: 7bit\n";

	// お客様へ
//	$error_flg1 = mb_send_mail( $arr_post["mail"], $mail_conf["user"]["title"], $mail1, $header1 );


	//----------------------------------------
	//  管理宛
	//----------------------------------------
	// ヘッダー
	$header2  = "From: " . mb_encode_mimeheader( $arr_post["name"] ) . " <" . $arr_post["mail"] . ">\n";
	$header2 .= "Bcc: "  . $mail_conf["info"]["bcc_mail"] . "\n";
	$header2 .= "Content-Type: text/plain; charset=iso-2022-jp\n";
	$header2 .= "Content-Transfer-Encoding: 7bit\n";

	// お客様へ
//	$error_flg2 = mb_send_mail( $mail_conf["info"]["admin_mail"], $mail_conf["master"]["title"], $mail2, $header2 );


	// 送信チェック
	if( empty( $error_flg1 ) || empty( $error_flg2 ) ) {
		$message["ng"] = "メール送信に失敗しました。";
	}
}

// クラス削除
unset( $objManage  );
unset( $objContact );


//----------------------------------------
//  表示
//----------------------------------------
// エラーチェック
if( empty( $message["ng"] ) ) {

	// セッションスタート
	@session_start();

	// メールアドレス設定
	$_SESSION["front"]["contact"]["POST"]["mail"] = $arr_post["mail"];

	// 終了画面へ
	header( "Location: ./finish.php" );

} else {

	// フォームへ
	header( "Location: ./index.php" );

}
?>
