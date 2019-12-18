<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 全てのサービスで共通して使用する定数クラス
 * @author ta-ando
 *
 */
class System_const
{
	/** サービス管理で使用する擬似企業ID */
	const DEFAULT_DATA_TYPE_DIR_NAME = 'service';

	/** 変更削除不可ユーザーのID */
	const FIXED_ROOT_USER_ACCOUNT = '1';

	/** 全権限を持つエヌディエスのユーザーコード */
	const NDS_ROOT_USER = 'nds';

	/** デフォルトの関連データID */
	const REFAULT_RELATION_ID = 0;
}
