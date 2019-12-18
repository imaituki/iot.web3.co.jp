<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* MY_Model
*
* @author localdisk 
* @property CI_DB_active_record $db
*/
class MY_Model extends CI_Model
{
	/*
	 * システムの自動ロードによりこのファイルが読み込まれる。
	 * このファイルが読み込まれることによって、下記のrequire_onceも実行される。
	 * これにより共通ライブラリ内に用意した実際の親クラスが読み込まれる。
	 */
}

/*
 * 子Modelをrequire_once
 */

require_once COMMON_LIB_PATH . 'base_setting/core/base_Model.php';

/*
 * 子Modelをrequire_once
 */

require_once COMMON_LIB_PATH . 'base_setting/core/base_post_Model.php';