<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Controller
 * @author ta-ando
 *
 */
class MY_Controller extends CI_Controller 
{
	/*
	 * システムの自動ロードによりこのファイルが読み込まれる。
	 * このファイルが読み込まれることによって、下記のrequire_onceも実行される。
	 * これにより共通ライブラリ内に用意した実際の親クラス、プロジェクト固有のコントローラーが読み込まれる。
	 */
}

/*
 * 子Controllerをrequire_once。
 * ロード順序はbase_Controller.phpが先
 */

require_once COMMON_LIB_PATH . 'base_setting/core/base_Controller.php';

//プロジェクト個別のコントローラー
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'common_Controller.php';

//検索機能を持つコントーラー用の親コントローラー
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'search_Controller.php';

//t_postを検索機能を持つコントーラー用の親コントローラー
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'post_search_Controller.php';

//登録, 編集画面のコントーラー用の親コントローラー
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'register_Controller.php';

//t_postを登録、編集する画面のコントーラー用の親コントローラー
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'post_register_Controller.php';