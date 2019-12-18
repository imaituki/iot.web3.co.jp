<?php
//-------------------------------------------------------------------
// 作成日：2013/07/29
// 作成者：松原
// 内  容：アップロードファイル表示
//-------------------------------------------------------------------
// SESSIONスタート
session_start();

// 出力
if( !empty( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]] ) ) {
	
	// 対象データのチェック
	if( file_exists( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["tmp_name"] ) && 
		!empty( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["type"] ) && 
		!empty( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["tmp_name"] ) && 
		!empty( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["fn"] ) ) {
		
		// function
		$function1 = "imagecreatefrom".$_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["fn"];
		$function2 = "image".$_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["fn"];
		
		// 画像リソースを取得
		$img = @$function1( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["tmp_name"] );
		
		// typeを調整
		$type = explode('/', $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["type"] );
		if( !empty( $type[1] ) ){
			header('Content-type: ' . $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["type"] . ';');
		} else{
			header('Content-type: ' . image_type_to_mime_type( $_SESSION["admin"][$_GET["dir"]]["preview"][$_GET["image"]]["type"] ) . ';');
		}
		$function2( $img );
		
		// 画像リソース・一時ファイル削除
		imagedestroy($img);
		exit;
		
	}
	
} else {
	
	print "リクエストされたファイルはありませんでした";
	exit;
	
}
?>
