<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * ダウンロードを行うクラス
 * @author ta-ando
 *
 */
class Download_file extends Common_Controller 
{
	/** 画面に渡す変数 */
	const F_FILE_NAME = 'file_name';

	/**
	 * コンストラクタ
	 * ・画面独自のライブラリ、ヘルパなどの読み込み
	 * ・画面で使用する変数情報をセット
	 */
	public function __construct()
	{
		parent::__construct();
		// これ以降にコードを書いていく

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data();
	}

	/**
	 * 強制的にダウンロードダイアログを使用してファイルをダウンロードする。
	 */
	public function document()
	{
		$file_path = $this->data[self::F_FILE_NAME];

		$file_name = basename($file_path);
		
		if($file_path && isset($file_path) && file_exists($file_path))
		{
			header("Content-length: ".filesize($file_path));
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . $file_name . '"');

			readfile("{$file_path}");
		} else {
			show_error("File does not exist.");
		}
	}
}