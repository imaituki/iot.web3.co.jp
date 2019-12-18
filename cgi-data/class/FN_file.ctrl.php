<?php
class FN_file {
	
	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: なし
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct() {
		
	}
	
//********************************************************************************
//                            ファイル系の処理
//********************************************************************************
	
	//----------------------------------------------------------------------------
	// 関数名: upFile
	// 引  数: $arrFiles   - アップファイルデータ
	//       : $arrOption[]（配列）
	//       :  [fileName] - 配列要素
	//       :  [savePath] - 保存先
	//       : $arr_post   - POST値
	// 戻り値: $res - アップ情報
	// 内  容: ファイルアップロードを行う。
	//----------------------------------------------------------------------------
	function upFile( $arrFiles, $arrOption, &$arr_post = null ) {
		
		// チェック
		if( empty( $arrFiles ) || !is_array( $arrOption ) ) {
			return null;
		}
		
		// ファイル設定ループ
		foreach( $arrOption as $key => $val ) {
			
			// アップロード
			if( !empty( $arrFiles[$val["name"]]["tmp_name"] ) ) {
				
				// ファイル削除
				if( !empty( $arr_post["_" . $val["name"] . "_now"] ) ) {
					@unlink( $val["savePath"] . $arr_post["_" . $val["name"] . "_now"] );
				}
				
				// 拡張子を取得
				$parts = pathinfo( $arrFiles[$val["name"]]["name"] );
				
				// ファイルアップロード
				if( move_uploaded_file( $arrFiles[$val["name"]]["tmp_name"], $val["savePath"] . $val["fileName"] . "." . $parts["extension"] ) ) {
					chmod( $val["savePath"] . $val["fileName"] . "." . $parts["extension"], 0644 );
				}
				
				// ファイル名の設定
				//$res[$key][$val["name"]."_name"] = $arrFiles[$val["name"]]["name"];
				$res[$key][$val["name"]]         = $val["fileName"] . "." . $parts["extension"];
				
				// POST値
				//$arr_post[$val["name"]."_name"] = $arrFiles[$val["name"]]["name"];
				$arr_post[$val["name"]]         = $val["fileName"] . "." . $parts["extension"];
				
			}else{
				
				// ファイル名の設定
				$arr_post[$val["name"]] = $arr_post["_" . $val["name"] . "_now"];
				
			}
			
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: delFile
	//       : $arrOption[]（配列）
	//       :  [fileName] - 配列要素
	//       :  [savePath] - 保存先
	//       : $arrDelList - 削除ファイルリスト
	//       : $arr_post   - POST値
	// 戻り値: $res   - アップ情報
	// 内  容: ファイルアップロードを行う。
	//----------------------------------------------------------------------------
	function delFile( $arrOption, $arrDelList, &$arr_post = null ) {
		
		// チェック
		if( empty( $arrOption ) || !is_array( $arrDelList ) ) {
			return null;
		}
		
		// ファイル設定ループ
		foreach( $arrOption as $key => $val ) {
			
			// ファイルチェック
			if( !empty( $arrDelList[$val["name"]] ) ) {
				
				// 添付ファイル削除
				@unlink( $val["savePath"] . $arrDelList[$val["name"]] );
				
				// ファイル名の削除
				$arr_post["_" . $val["name"] . "_now"] = NULL;
				
			}
		}
		
	}
	
	
//********************************************************************************
//                              画像系の処理
//********************************************************************************
	
	//----------------------------------------------------------------------------
	// 関数名: upImage
	// 引  数: $arrFiles                    - アップファイルデータ
	//       : $arrImage[]（配列）
	//       :  [name]                      - 配列要素（$arrFiles）
	//       :  [option][*][savePath]       - 保存先
	//       :  [option][*][fileName]       - ファイル名
	//       :  [option][*][prefixFileName] - ファイル名（接頭辞）
	//       :  [option][*][width]          - 縮小サイズ（横ピクセル）
	//       :  [option][*][height]         - 縮小サイズ（縦ピクセル）
	//       :  [option][*][mode]           - リサイズモード（1: 横 2: 縦 3: 縦横）
	//       : $arr_post                    - POST値
	// 戻り値: $res - 画像アップ情報（リサイズサイズ等）
	// 内  容: 画像リサイズを行い保存する。
	//----------------------------------------------------------------------------
	function upImage( $arrFiles, $arrImage, &$arr_post = null ) {
		
		// チェック
		if( empty( $arrFiles ) || !is_array( $arrImage ) ) {
			return null;
		}
		
		// タイムアウト対策
		set_time_limit(0);
		
		// ファイルアップ処理
		foreach( $arrImage as $key => $val ) {
			
			// ファイルチェック
			if( !empty( $arrFiles[$val["name"]]["tmp_name"] ) && is_array( $val["option"] ) ) {
				
				// 写真リサイズ ＆ アップロード
				foreach( $val["option"] as $key2 => $val2 ) {
					
					// 画像ファイル削除
					if( !empty( $arr_post["_" . $val["name"] . "_now"] ) ) {
						@unlink( $val2["savePath"] . $val2["prefixFileName"] . $arr_post["_" . $val["name"] . "_now"] );
					}
					
					// リサイズ
					$res[$val["name"]] = $this->resizeImage( array( "inputPath" => $arrFiles[$val["name"]]["tmp_name"], "resizeOption" => $val2 ) );
					
					// ファイル名の設定
					$arr_post[$val["name"]] = $res[$val["name"]]["newImage"]["fileName"];
					
				}
				
			}else{
				
				// ファイル名の設定
				$arr_post[$val["name"]] = $arr_post["_" . $val["name"] . "_now"];
				
			}
			
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: copyImage
	// 引  数: $arrFiles                    - アップファイルデータ
	//       : $arrImage[]（配列）
	//       :  [name]                      - 配列要素（$arrFiles）
	//       :  [option][*][savePath]       - 保存先
	//       :  [option][*][fileName]       - ファイル名
	//       :  [option][*][prefixFileName] - ファイル名（接頭辞）
	//       :  [option][*][width]          - 縮小サイズ（横ピクセル）
	//       :  [option][*][height]         - 縮小サイズ（縦ピクセル）
	//       :  [option][*][mode]           - リサイズモード（1: 横 2: 縦 3: 縦横）
	//       : $arr_post                    - POST値
	// 戻り値: $res - 画像アップ情報（リサイズサイズ等）
	// 内  容: 画像リサイズを行い保存する。
	//----------------------------------------------------------------------------
	function copyImage( $arrFiles, $arrImage, &$arr_post ) {
		
		// チェック
		if( empty( $arr_post["_preview_image_dir"] ) || !is_array( $arrImage ) ) {
			return null;
		}
		
		// タイムアウト対策
		set_time_limit(0);
		
		// ファイルアップ処理
		foreach( $arrImage as $key => $val ) {
			
			// ファイルチェック
			if( !empty( $arr_post["_preview_image_" . $val["name"]] ) && is_array( $val["option"] ) ) {
				
				// 写真コピー
				foreach( $val["option"] as $key2 => $val2 ) {
					
					// 画像ファイル削除
					if( !empty( $arr_post["_" . $val["name"] . "_now"] ) ) {
						@unlink( $val2["savePath"] . $val2["prefixFileName"] . $arr_post["_" . $val["name"] . "_now"] );
					}
					
					// ファイルパス
					$res[$val["name"]]["newImage"]["fileName"] = $arr_post["_preview_image_" . $val["name"]];
					$res[$val["name"]]["newImage"]["savePath"] = $val2["savePath"] . $val2["prefixFileName"] . $res[$val["name"]]["newImage"]["fileName"];
					$res[$val["name"]]["inputPath"] = $arr_post["_preview_image_dir"] . "/" . $val2["prefixFileName"] . $res[$val["name"]]["newImage"]["fileName"];
					
					// コピー
					@copy( $res[$val["name"]]["inputPath"], $res[$val["name"]]["newImage"]["savePath"] );
					
					// パーミッション
					chmod( $res[$val["name"]]["newImage"]["savePath"], 0655 );
					
					// ファイル名の設定
					$arr_post[$val["name"]] = $res[$val["name"]]["newImage"]["fileName"];
					
					// /tmpのファイルを削除
					@unlink( $res[$val["name"]]["inputPath"] );
				}
				
			}else{
				
				// ファイル名の設定
				$arr_post[$val["name"]] = $arr_post["_" . $val["name"] . "_now"];
				
			}
			
		}
		
		// 戻り値
		return $res;
		
	}

	
	//----------------------------------------------------------------------------
	// 関数名: delImage
	// 引  数: $arrImage[]（配列）
	//       :  [name]                      - 配列要素（$arrFiles）
	//       :  [option][*][savePath]       - 保存先
	//       :  [option][*][fileName]       - ファイル名
	//       :  [option][*][prefixFileName] - ファイル名（接頭辞）
	//       : $arrDelList                  - 削除ファイルリスト
	//       : $arr_post                    - POST値
	// 戻り値: $res - 画像アップ情報（リサイズサイズ等）
	// 内  容: 画像リサイズを行い保存する。
	//----------------------------------------------------------------------------
	function delImage( $arrImage, $arrDelList, &$arr_post = null ) {
		
		// チェック
		if( empty( $arrImage ) || !is_array( $arrDelList ) ) {
			return null;
		}
		
		// ファイルアップ処理
		foreach( $arrImage as $key => $val ) {
			
			// ファイルチェック
			if( !empty( $arrDelList[$val["name"]] ) && is_array( $val["option"] ) ) {
				
				// 写真リサイズ ＆ アップロード
				foreach( $val["option"] as $key2 => $val2 ) {
					@unlink( $val2["savePath"] . $val2["prefixFileName"] . $arrDelList[$val["name"]] );
				}
				
				// 画像名の削除
				$arr_post[$val["name"]]                = NULL;
				$arr_post["_" . $val["name"] . "_now"] = NULL;
				
			}
			
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: resizeImage
	// 引  数: $option[]（配列）
	//       :  [inputPath]                    - 元画像のパス
	//       :  [resizeOption][width]          - 縮小サイズ（横ピクセル）
	//       :  [resizeOption][height]         - 縮小サイズ（縦ピクセル）
	//       :  [resizeOption][mode]           - リサイズモード（1: 横 2: 縦 3: 縦横）
	//       :  [resizeOption][savePath]       - 保存パス
	//       :  [resizeOption][fileName]       - ファイル名
	//       :  [resizeOption][prefixFileName] - ファイル名（接頭辞）
	// 戻り値: $option[]（配列）
	//       :  [inputPath]                    - 元画像のパス
	//       :  [resizeOption][width]          - 縮小サイズ（横ピクセル）
	//       :  [resizeOption][height]         - 縮小サイズ（縦ピクセル）
	//       :  [resizeOption][mode]           - リサイズモード（1: 横 2: 縦 3: 縦横）
	//       :  [resizeOption][savePath]       - 保存パス
	//       :  [resizeOption][fileName]       - ファイル名
	//       :  [resizeOption][prefixFileName] - ファイル名（接頭辞）
	//       :  [originImage][width]           - 元ファイルのサイズ（横ピクセル）
	//       :  [originImage][height]          - 元ファイルのサイズ（縦ピクセル） 
	//       :  [originImage][extension]       - 元ファイルの拡張子
	//       :  [newImage][width]              - リサイズ後のサイズ（横ピクセル）
	//       :  [newImage][height]             - リサイズ後のサイズ（縦ピクセル）
	//       :  [newImage][extension]          - リサイズ後の拡張子
	//       :  [newImage][savePath]           - リサイズ後の保存先
	//       :  [newImage][fileName]           - リサイズ後のファイル名（DB登録用）
	//       :  [newImage][fileRename]         - リサイズ後のファイル名
	//       :  [newImage][imageSrc]           - リサイズ後のイメージ情報
	//       :  [newImage][imageDst]           - リサイズ後のイメージ情報
	// 内  容: 画像リサイズを行い保存する。
	//----------------------------------------------------------------------------
	function resizeImage( $Option ) {
		
		// データチェック
		if( empty( $Option["inputPath"] ) ) {
			return NULL;
		}
		
		// 初期化
		if( empty( $Option["resizeOption"]["mode"] ) ) {
			$Option["resizeOption"]["mode"] = 1;
		}
		
		// ファイル情報の取得
		$this->getImageInfo( $Option );
		
		// 新しいサイズを計算（拡大）
		switch( $Option["resizeOption"]["mode"] ) {
			
			// 横サイズ基準でリサイズ
			case 1:
				$this->CalculatWidth( $Option );
			break;
			
			// 縦サイズ基準でリサイズ
			case 2:
				$this->CalculatHeight( $Option );
			break;
			
			// 縦横サイズ基準でリサイズ
			case 3:
				
				// 縦横基準でリサイズ計算
				$this->CalculatWidthHeight( $Option );
				
			break;
			
			default:
				return NULL;
			break;
			
		}
		
		// コピー先のイメージを作成（拡大）
		if( function_exists("ImageCreateTrueColor") ) {
			$Option["newImage"]["imageDst"] = imagecreatetruecolor( $Option["newImage"]["width"], $Option["newImage"]["height"] ) or die("errDst!\n");
		} else {
			$Option["newImage"]["imageDst"] = ImageCreate( $Option["newImage"]["width"], $Option["newImage"]["height"] ) or die("errDst!\n");
		}
		
		// イメージをコピーしてリサイズ（拡大）
		if( function_exists("ImageCopyResampled") ) {
			ImageCopyResampled( $Option["newImage"]["imageDst"], $Option["newImage"]["imageSrc"], 0, 0, 0, 0,
								$Option["newImage"]["width"], $Option["newImage"]["height"],
								$Option["originImage"]["width"], $Option["originImage"]["height"] ) or die("errResize!\n");
		} else {
			ImageCopyResized( $Option["newImage"]["imageDst"], $Option["newImage"]["imageSrc"], 0, 0, 0, 0,
							  $Option["newImage"]["width"], $Option["newImage"]["height"],
							  $Option["originImage"]["width"], $Option["originImage"]["height"] ) or die("errResize!\n");
		}
		
		// 画像のコピー
		switch( $Option["newImage"]["extension"] ) {
			case "png":
				ImagePNG( $Option["newImage"]["imageDst"], $Option["newImage"]["savePath"], 9 );
			break;
			case "jpg":
				ImageJPEG( $Option["newImage"]["imageDst"], $Option["newImage"]["savePath"], 100 );
			break;
			default:
				ImageGIF( $Option["newImage"]["imageDst"], $Option["newImage"]["savePath"] );
			break;
		}
		
		// パーミッションの切り替え
		chmod( $Option["newImage"]["savePath"], 0655 );
		
		// イメージデータの開放
		unset( $Option["newImage"]["imageSrc"] );
		unset( $Option["newImage"]["imageDst"] );
		
		// 戻り値
		return $Option;
		
	}


	// サポーター募集用
	function resizeImage2( $Option ) {
		
		// データチェック
		if( empty( $Option["inputPath"] ) ) {
			return NULL;
		}
		
		// 初期化
		if( empty( $Option["resizeOption"]["mode"] ) ) {
			$Option["resizeOption"]["mode"] = 1;
		}
		
		// ファイル情報の取得
		$this->getImageInfo( $Option );
		
		// 新しいサイズを計算（拡大）
		switch( $Option["resizeOption"]["mode"] ) {
			
			// 横サイズ基準でリサイズ
			case 1:
				$this->CalculatWidth( $Option );
			break;
			
			// 縦サイズ基準でリサイズ
			case 2:
				$this->CalculatHeight( $Option );
			break;
			
			// 縦横サイズ基準でリサイズ
			case 3:
				
				// 縦横基準でリサイズ計算
				$this->CalculatWidthHeight( $Option );
				
			break;
			
			default:
				return NULL;
			break;
			
		}

		// コピー先のイメージを作成（拡大）
		if( function_exists("ImageCreateTrueColor") ) {
			$Option["newImage"]["imageDst"] = imagecreatetruecolor( $Option["newImage"]["width"], $Option["newImage"]["height"] ) or die("errDst!\n");
		} else {
			$Option["newImage"]["imageDst"] = ImageCreate( $Option["newImage"]["width"], $Option["newImage"]["height"] ) or die("errDst!\n");
		}

		// イメージをコピーしてリサイズ（拡大）
		if( function_exists("ImageCopyResampled") ) {
			ImageCopyResampled( $Option["newImage"]["imageDst"], $Option["newImage"]["imageSrc"], 0, 0, 0, 0,
								$Option["newImage"]["width"], $Option["newImage"]["height"],
								$Option["originImage"]["width"], $Option["originImage"]["height"] ) or die("errResize!\n");
		} else {
			ImageCopyResized( $Option["newImage"]["imageDst"], $Option["newImage"]["imageSrc"], 0, 0, 0, 0,
							  $Option["newImage"]["width"], $Option["newImage"]["height"],
							  $Option["originImage"]["width"], $Option["originImage"]["height"] ) or die("errResize!\n");
		}
		
		// 画像のコピー
		switch( $Option["newImage"]["extension"] ) {
			case "png":
				ImagePNG( $Option["newImage"]["imageDst"], $Option["newImage"]["savePath"], 9 );
			break;
			case "jpg":
				ImageJPEG( $Option["newImage"]["imageDst"], $Option["newImage"]["savePath"], 100 );
			break;
			default:
				ImageGIF( $Option["newImage"]["imageDst"], $Option["newImage"]["savePath"] );
			break;
		}
		
		// パーミッションの切り替え
		chmod( $Option["newImage"]["savePath"], 0655 );
		
		// イメージデータの開放
		unset( $Option["newImage"]["imageSrc"] );
		unset( $Option["newImage"]["imageDst"] );
		
		// 戻り値
		return $Option;
		
	}


	//----------------------------------------------------------------------------
	// 関数名: getImageInfo
	// 引  数: $tmp_name  - アップ画像名
	//       : $file_name - ファイル名
	// 戻り値: 画像名
	// 内  容: DBへ登録する画像名(UNIXタイムスタンプ+拡張子)を作成する。
	//----------------------------------------------------------------------------
	function getImageInfo( &$Option ) {
		
		// ファイル名作成
		if( $Option["resizeOption"]["fileName"] == NULL ) {
			
			// 現在の時間取得
			list( $usec, $sec ) = explode( " ", microtime() );
			$Option["resizeOption"]["fileName"] = date( "YmdHis", $sec ) . str_replace( ".", "", ( (string)( ( float )$usec ) ) );
			
		}
		
		// サイズと拡張子を取得
		if( empty( $Option["originImage"]["extension"] ) ){
			list( $Option["originImage"]["width"], $Option["originImage"]["height"], $Option["originImage"]["extension"] ) = getimagesize( $Option["inputPath"] );
		}
		
		// 拡張子チェック
		if( empty( $Option["newImage"]["imageSrc"] ) ){
			switch( $Option["originImage"]["extension"] ) {
				case 1:
					$Option["newImage"]["imageSrc"]     = imagecreatefromgif( $Option["inputPath"] ) or die("errSrcGif!\n");
					$Option["newImage"]["extension"]    = "gif";
					$Option["originImage"]["extension"] = "gif";
					break;
					
				case 2:
					$Option["newImage"]["imageSrc"]     = imagecreatefromjpeg( $Option["inputPath"] ) or die("errSrcJpg!\n");
					$Option["newImage"]["extension"]    = "jpg";
					$Option["originImage"]["extension"] = "jpg";
					break;
					
				case 3:
					$Option["newImage"]["imageSrc"]     = imagecreatefrompng( $Option["inputPath"] ) or die("errSrcPng!\n");
					$Option["newImage"]["extension"]    = "png";
					$Option["originImage"]["extension"] = "png";
					break;
					
				default:
					echo "対応外のファイルが選択されました。(対応ファイル: jpeg/gif/png)";
					exit;
				break;
				
			}
		}
		
		// ファイル名
		$Option["newImage"]["fileName"] = $Option["resizeOption"]["fileName"] . "." . $Option["newImage"]["extension"];
		
		// リネーム名
		$Option["newImage"]["fileRename"] = $Option["resizeOption"]["prefixFileName"] . $Option["resizeOption"]["fileName"] . "." . $Option["newImage"]["extension"];
		
		// 保存先
		$Option["newImage"]["savePath"] = $Option["resizeOption"]["savePath"] . $Option["newImage"]["fileRename"];
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CalculatWidth
	// 引  数: $Option
	// 戻り値: なし
	// 内  容: 縮小サイズ計算
	//----------------------------------------------------------------------------
	function CalculatWidth( &$Option ) {
		
		if ( $Option["originImage"]["width"] > $Option["resizeOption"]["width"] ) {
			$Option["newImage"]["width"]  = $Option["resizeOption"]["width"];
			$Option["newImage"]["height"] = floor( $Option["originImage"]["height"] / ( $Option["originImage"]["width"] / $Option["newImage"]["width"] ) );
		} else {
			$Option["newImage"]["height"] = $Option["originImage"]["height"];
			$Option["newImage"]["width"]  = $Option["originImage"]["width"];
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CalculatHeight
	// 引  数: $Option
	// 戻り値: なし
	// 戻り値: 縮小サイズ（縦、横）
	// 内  容: 縮小サイズ計算
	//----------------------------------------------------------------------------
	function CalculatHeight( &$Option ) {
		
		if ( $Option["originImage"]["height"] > $Option["resizeOption"]["height"] ) {
			$Option["newImage"]["height"] = $Option["resizeOption"]["height"];
			$Option["newImage"]["width"]  = floor( $Option["originImage"]["width"] / ( $Option["originImage"]["height"] / $Option["newImage"]["height"] ) );
		} else {
			$Option["newImage"]["height"] = $Option["originImage"]["height"];
			$Option["newImage"]["width"]  = $Option["originImage"]["width"];
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CalculatWidthHeight
	// 引  数: $Option
	// 戻り値: なし
	// 戻り値: 縮小サイズ（縦、横）
	// 内  容: 縮小サイズ計算
	//----------------------------------------------------------------------------
	function CalculatWidthHeight( &$Option ) {
		
		// 横の計算
		if ( $Option["originImage"]["width"] > $Option["resizeOption"]["width"] ) {
			$Option["newImage"]["width"]  = $Option["resizeOption"]["width"];
			$Option["newImage"]["height"] = floor( $Option["originImage"]["height"] / ( $Option["originImage"]["width"] / $Option["newImage"]["width"] ) );
		} else {
			$Option["newImage"]["height"] = $Option["originImage"]["height"];
			$Option["newImage"]["width"]  = $Option["originImage"]["width"];
		}
		
		// 縦の計算
		if ( $Option["newImage"]["height"] > $Option["resizeOption"]["height"] ) {
			$Option["newImage"]["width"]  = floor( $Option["newImage"]["width"] / ( $Option["newImage"]["height"] / $Option["resizeOption"]["height"] ) );
			$Option["newImage"]["height"] = $Option["resizeOption"]["height"];
		}
		
	}
	
}
?>