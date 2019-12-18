<?php

/**
 * テンプレートによるページの描画用クラス
 *
 * @author ta-ando
 *
 */
class p_template
{

	/**
	 * レイアウトファイルを使用してテンプレートを使用して画面情報を生成して表示します。
	 *
	 * @param unknown_type $filename
	 * @param unknown_type $_display
	 */
	public function convertLayoutTemplate($filename, $_display) {

		//テンプレート部品のHTMLを保持する配列
		$contentes = array();

		//レイアウトファイル内の埋め込み記号名のリストを取得。
		$keys = array_keys($filename[_LAYOUT_CONTENTS_KEY]);

		//テンプレート部品のファイル更新があったかどうかを保持するフラグ
		$updateCount = 0;

		//レイアウトファイル内のtpl{}の数だけキャッシュファイルの更新有無を確認
		foreach ($keys as $key) {
			$retFlg = $this->convert_template($filename[_LAYOUT_CONTENTS_KEY][$key]);

			//更新されていればプラス1
			if ($retFlg) {
				$updateCount++;
			}

			$tpl_cachename = "./templates/cache/tpl/" . $filename[_LAYOUT_CONTENTS_KEY][$key] . '.cache';

			if(!file_exists($tpl_cachename)){
				die("Not found Template file : '" . $tpl_cachename . "'");
			}

			//tpl部品のHTML文字列を配列にセット
			$contents[$key] =  file_get_contents($tpl_cachename);
		}

		$layoutFileName = "./templates/layout/" . $filename[_LAYOUT_KEY];
		$layoutRefreshFlg = $this->convert_layout($filename[_LAYOUT_KEY]);

		$page_name = "";

		//キャッシュ用のページ名は明示されていなければ、tplファイル名とする。
		if (isset($filename[_PAGE_NAME_KEY])) {
			$page_name = $filename[_PAGE_NAME_KEY];
		} else {
			$page_name = str_replace(".tpl", "", $filename[_LAYOUT_CONTENTS_KEY][MAIN_CONTENTS]);
		}

		$page_cachename = "./templates/cache/" . $page_name . ".cache";

		//キャッシュファイルが無いもしくはテンプレファイルが新しい
		if (! file_exists($page_cachename) || ($updateCount > 0) || $layoutRefreshFlg) {

			if(!file_exists($layoutFileName)){
				die("Not found Layout file : '" . $layoutFileName . "'");
			}

			$s = file_get_contents($layoutFileName);	//ファイルの内容を全て文字列に読み込む

			//各パーツ用のスクリプトファイル（キャッシュ）をレイアウトファイルにセットする。
			foreach ($keys as $key) {
				$s = preg_replace('/<!-- tpl\{'.$key.'\}  -->/', $contents[$key], $s);
			}

			$s = $this->convert_string($s);		//文字列をコンバートする

			//ページファイルを作成
			file_put_contents($page_cachename, $s);
		}

		extract($_display);		//連想配列の中身をすべて普通の変数に展開する
		
		
		@header("Cache-Control: private, no-cache, no-cache=Set-Cookie, proxy-revalidate");
		@header("Pragma: no-cache");
		@header("Expires: Wed, 17 Sep 1975 21:32:10 GMT");
		
		//画面描画
		include($page_cachename);
	}


	/**
	 * tplファイルをキャッシュに展開します。
	 *
	 * @param unknown_type $filename
	 */
	public function convert_template($filename) {

		$filename_path = "./templates/" . $filename;
		$cachename = "./templates/cache/tpl/" . $filename . '.cache';

		$retFlg = false;

		//キャッシュファイルが無いもしくはテンプレファイルが新しい場合のみファイルを更新
		if (! file_exists($cachename) || filemtime($cachename) < filemtime($filename_path)) {

			$retFlg = true;

			if(!file_exists($filename_path)){
				die("Not found template : '" . $filename_path . "'");
			}

			$s = file_get_contents($filename_path);	//ファイルの内容を全て文字列に読み込む

			$s = $this->convert_string($s);		//文字列をコンバートする

			file_put_contents($cachename, $s);
		}

		return $retFlg;
	}

	/**
	 * layoutファイルをキャッシュに作成します。
	 * レイアウトはファイルにはPHP要素を含まない仕様なので、
	 * キャッシュはファイル自体をリネームしてコピーしている。
	 *
	 * @param unknown_type $filename
	 */
	public function convert_layout($filename) {

		$filename_path = "./templates/layout/" . $filename;
		$cachename = "./templates/cache/layout/" . $filename . '.cache';

		$retFlg = false;

		//キャッシュファイルが無いもしくはテンプレファイルが新しい場合のみファイルを更新。
		if (! file_exists($cachename) || filemtime($cachename) < filemtime($filename_path)) {
			$retFlg = true;

			if(!file_exists($filename_path)){
				die("Not found layout file : '" . $filename_path . "'");
			}

			copy($filename_path, $cachename);
		}

		return $retFlg;
	}

	/**
	 * HTML部品に埋め込まれたテンプレート用の記述をphpスクリプトで置き換える。
	 * isset()を使用して宣言されていない変数がある場合のNoticeを回避している。
	 *
	 * @param string $s
	 */
	public function convert_string($s)
	{
		//XML宣言を置換
		$s = preg_replace('/^<\?xml/', '<<?php ?>?xml', $s);

		//------------------------------------------------------
		//言語置換＆URLエンコード
		$s = preg_replace('/_%\{(.*?)\}/', '<?php $text = explode("|","$1"); echo isset($text[$locale]) ? urlencode($text[$locale]) : ""; ?>', $s);

		//'#{...}' を 'echo ...;' に置換
		$s = preg_replace('/#\{(.*?)\}/', '<?php echo isset($$1) ? $$1 : ""; ?>', $s);
		//HTMLエスケープ
		$s = preg_replace('/&\{(.*?)\}/', '<?php echo isset($$1) ? htmlspecialchars($$1) : ""; ?>', $s);

		//HTMLエスケープ+改行をBRに
		$s = preg_replace('/&BR\{(.*?)\}/', '<?php echo isset($$1) ? nl2br(make_link(htmlspecialchars($$1))) : ""; ?>', $s);

		//HTMLエスケープなし+改行をBRに
		$s = preg_replace('/#BR\{(.*?)\}/', '<?php echo isset($$1) ? nl2br(make_link($$1)) : ""; ?>', $s);

		//半角カナを全角カナに
		$s = preg_replace('/K\{(.*?)\}/', '<?php echo isset($$1) ? mb_convert_kana($$1,KV,"UTF-8") : ""; ?>', $s);
		//URLエンコード
		$s = preg_replace('/%\{(.*?)\}/', '<?php echo isset($$1) ? urlencode($$1) : ""; ?>', $s);
		//言語置換
		$s = preg_replace('/_\{(.*?)\}/', '<?php $text = explode("|","$1"); echo isset($text[$locale]) $text[$locale] : ""; ?>', $s);

		//エラーメッセージを出力する。カンマを含む場合はBRタグに変換する。また、error_br{}直後にBRタグが存在する場合は除去する。
		$s = preg_replace('/error_br\{(.*?)\}(\<br \/\>)?/', '<?php echo isset($$1) ? str_replace(",", "<br />", $$1) . "<br />" : ""; ?>', $s);

		//エラーメッセージを出力する。メッセージをそのまま出力する。
		$s = preg_replace('/error_br\{(.*?)\}/', '<?php echo isset($$1) ? $$1 : ""; ?>', $s);


		return $s;
	}

}