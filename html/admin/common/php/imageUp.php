<?php
//-------------------------------------------------------------------
// 作成日：2013/07/29
// 作成者：松原
// 内  容：画像 アップロード
//-------------------------------------------------------------------
//----------------------------------------
//  初期化
//----------------------------------------
// HTML
unset( $html );


//----------------------------------------
//  データチェック
//----------------------------------------
// コンテンツ名＆ファイルアップ
if( empty( $_POST["_contents_conf_path"] ) || empty( $_FILES ) ) {

	// エラーメッセージ
	$html = "<span class=\"c_red err-img\"> ※ アップロードに失敗しました。（アップロードできない拡張子を選択された、画像容量が大き過ぎるなどの原因が考えられます。）</span>";

} else {

	//----------------------------------------
	//  共通設定
	//----------------------------------------
	// 設定ファイルパス
	$config = $_POST["_contents_conf_path"];

	// ファイルチェック
	if( file_exists( $config ) == true ) {

		// 読み込み
		require $config;

		// 画像操作クラス
		$FN_file = new FN_file();
		
		//----------------------------------------
		//  ファイルアップロード
		//----------------------------------------
		if( is_array( $_ARR_IMAGE ) ) {

			// ファイル設定ループ
			foreach( $_ARR_IMAGE as $key => $val ) {

				if( !empty( $_FILES[$val["name"]]["tmp_name"] ) ) {

					//配列かチェック
					if( is_array( $_FILES[$val["name"]]["tmp_name"] ) ){

						foreach ( $_FILES[$val["name"]]["tmp_name"] as $key3 => $val3) {

							// 拡張子を取得
							$originImage = array();
							list( $originImage["width"], $originImage["height"], $originImage["extension"] ) = getimagesize( $_FILES[$val["name"]]["tmp_name"][$key3] );

							// 拡張子チェック
							if( $originImage["extension"] < 1 || 3 < $originImage["extension"] ) {
								$html = "<span class=\"c_red err-img\"> ※ GIF／JPG／PNG以外のファイルはアップロードできません。</span>";

							} else {

								//----------------------------------------
								//  アップ画像の情報取得
								//----------------------------------------
								// アップ画像情報の整理
								$newImage    = array();
								switch( $originImage["extension"] ) {
									case 1:
										$newImage["imageSrc"]     = imagecreatefromgif( $_FILES[$val["name"]]["tmp_name"][$key3] ) or die("errSrcGif!\n");
										$newImage["extension"]    = "gif";
										$originImage["extension"] = "gif";
										$fn   = "gif";
										$ext  = ".gif";
									break;
									case 2:
										$newImage["imageSrc"]     = imagecreatefromjpeg( $_FILES[$val["name"]]["tmp_name"][$key3] ) or die("errSrcJpg!\n");
										$newImage["extension"]    = "jpg";
										$originImage["extension"] = "jpg";
										$fn   = "jpeg";
										$ext  = ".jpg";
									break;
									case 3:
										$newImage["imageSrc"]     = imagecreatefrompng( $_FILES[$val["name"]]["tmp_name"][$key3] ) or die("errSrcPng!\n");
										
										$newImage["extension"]    = "png";
										$originImage["extension"] = "png";
										$fn   = "png";
										$ext  = ".png";
									break;
									default:
										$html = "<span class=\"c_red err-img\"> ※ GIF／JPG／PNG以外のファイルはアップロードできません。</span>";
									break;
								}

								// ファイル名の分解
								$pathInfo = pathinfo( $_FILES[$val["name"]]["tmp_name"][$key3] . $ext );

								// アップロード
								if( is_array( $val["option"] ) ) {
									foreach( $val["option"] as $key2 => $val2 ){

										// アップロードパスの差し替え
										$val2["savePath"] = $pathInfo["dirname"] . "/";

										// 写真リサイズ
										$ImageInfo = $FN_file->resizeImage( array( "inputPath" => $_FILES[$val["name"]]["tmp_name"][$key3], "resizeOption" => $val2, "originImage" => $originImage, "newImage" => $newImage ) );

									}

									// ファイル名の置き換え
									$pathInfo["filename"] = $val["option"]["s"]["fileName"];

								}

								// 出力
								$html  = "<img src=\"/admin/common/php/imageDisp.php?dir=" . $arr_post["_contents_dir"] . "&image=" . $val["name"] . "&time=" . strtotime("now") . "\" />&nbsp;";
								$html .= "<span class=\"c_red\"> ※この画像はプレビュー用です。まだ保存されていません。 </span><br />";
								$html .= "<input type=\"hidden\" name=\"imagelist[" . $key3 . "][_preview_" . $val["name"] . "]\" value=\"" . $val["name"]  . "\" />";
								$html .= '<input type="hidden" name="imagelist[' . $key3 . '][_preview_image_' . $val["name"] . ']" value="' . $pathInfo["filename"] . $ext . '" />';
								$html .= '<input type="hidden" name="imagelist[' . $key3 . '][_preview_image_dir]" value="' . $pathInfo["dirname"] . '" />';

								// 画像をセッションに保存
								unset( $_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]] );
								$_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]]["type"]     = $_FILES[$val["name"]]["type"][$key3];
								$_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]]["tmp_name"] = $pathInfo["dirname"] . "/s_" . $pathInfo["filename"] . $ext;
								$_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]]["fn"]       = $fn;

							}

						}

					}else{
						// 拡張子を取得
						$originImage = array();
						list( $originImage["width"], $originImage["height"], $originImage["extension"] ) = getimagesize( $_FILES[$val["name"]]["tmp_name"] );

						// 拡張子チェック
						if( $originImage["extension"] < 1 || 3 < $originImage["extension"] ) {
							$html = "<span class=\"c_red err-img\"> ※ GIF／JPG／PNG以外のファイルはアップロードできません。</span>";

						} else {

							//----------------------------------------
							//  アップ画像の情報取得
							//----------------------------------------
							// アップ画像情報の整理
							$newImage    = array();
							switch( $originImage["extension"] ) {
								case 1:
									$newImage["imageSrc"]     = imagecreatefromgif( $_FILES[$val["name"]]["tmp_name"] ) or die("errSrcGif!\n");
									$newImage["extension"]    = "gif";
									$originImage["extension"] = "gif";
									$fn   = "gif";
									$ext  = ".gif";
								break;
								case 2:
									$newImage["imageSrc"]     = imagecreatefromjpeg( $_FILES[$val["name"]]["tmp_name"] ) or die("errSrcJpg!\n");
									$newImage["extension"]    = "jpg";
									$originImage["extension"] = "jpg";
									$fn   = "jpeg";
									$ext  = ".jpg";
								break;
								case 3:
									$newImage["imageSrc"]     = imagecreatefrompng( $_FILES[$val["name"]]["tmp_name"] ) or die("errSrcPng!\n");
									$newImage["extension"]    = "png";
									$originImage["extension"] = "png";
									$fn   = "png";
									$ext  = ".png";
								break;
								default:
									$html = "<span class=\"c_red err-img\"> ※ GIF／JPG／PNG以外のファイルはアップロードできません。</span>";
								break;
							}

							// ファイル名の分解
							$pathInfo = pathinfo( $_FILES[$val["name"]]["tmp_name"] . $ext );

							// アップロード
							if( is_array( $val["option"] ) ) {
								foreach( $val["option"] as $key2 => $val2 ){

									// アップロードパスの差し替え
									$val2["savePath"] = $pathInfo["dirname"] . "/";

									// 写真リサイズ
									$ImageInfo = $FN_file->resizeImage( array( "inputPath" => $_FILES[$val["name"]]["tmp_name"], "resizeOption" => $val2, "originImage" => $originImage, "newImage" => $newImage ) );

								}

								// ファイル名の置き換え
								$pathInfo["filename"] = $val["option"]["s"]["fileName"];

							}
							
							// 出力
							$html  = "<img src=\"/admin/common/php/imageDisp.php?dir=" . $arr_post["_contents_dir"] . "&image=" . $val["name"] . "&time=" . strtotime("now") . "\" />&nbsp;";
							$html .= "<span class=\"c_red\"> ※この画像はプレビュー用です。まだ保存されていません。 </span><br />";
							$html .= "<input type=\"hidden\" name=\"_preview_" . $val["name"] . "\" value=\"" . $val["name"]  . "\" />";
							$html .= '<input type="hidden" name="_preview_image_' . $val["name"] . '" value="' . $pathInfo["filename"] . $ext . '" />';
							$html .= '<input type="hidden" name="_preview_image_dir" value="' . $pathInfo["dirname"] . '" />';

							// 画像をセッションに保存
							unset( $_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]] );
							$_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]]["type"]     = $_FILES[$val["name"]]["type"];
							$_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]]["tmp_name"] = $pathInfo["dirname"] . "/s_" . $pathInfo["filename"] . $ext;
							$_SESSION["admin"][$arr_post["_contents_dir"]]["preview"][$val["name"]]["fn"]       = $fn;

						}

						// 離脱
						break;
					}
				}

			}
			// エラーメッセージ
			if( empty( $html ) ){
				$html = "<span class=\"c_red err-img\"> ※ ファイルのアップロードに失敗しました。</span>";
			}

		} else {
			// is_array( $_ARR_IMAGE )エラーメッセージ
			$html = "<span class=\"c_red err-img\"> ※ 画像設定ファイルが見つかりません。システム管理者へご連絡下さい。</span>";

		}

	} else {
		// file_exists( $config )エラーメッセージ
		$html = "<span class=\"c_red err-img\"> ※ 設定ファイルが見つかりません。システム管理者へご連絡下さい。</span>";

	}

}

echo "<html>";
echo "<body>";
echo "<div class=\"load_image\">";
echo $html;
echo "</div>";
echo "</body>";
echo "</html>";
?>
