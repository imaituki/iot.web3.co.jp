<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: information 新規登録
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  表示
//----------------------------------------
// smarty設定
$smarty = new MySmarty("admin");
$smarty->compile_dir .= _CONTENTS_DIR. "/";

// テンプレートに設定
if( !empty($_ARR_IMAGE) ){
	$smarty->assign( '_ARR_IMAGE', $_ARR_IMAGE );
}
if( !empty($_ARR_FILE) ){
	$smarty->assign( '_ARR_FILE', $_ARR_FILE );
}

// オプション設定
$smarty->assign( 'OptionInformationCategory' , $OptionInformationCategory  );


// 表示
$smarty->display( "new.tpl" );
?>
