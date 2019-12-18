<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ページタイプの定数クラス
 * @author ta-ando
 *
 */
class Page_type extends Base_const_lib
{
	/** 画面を識別するためのキー */
	const KEY = 'common_page_type';

	/** 画面を示すキー */
	const REGISTER = 'register';
	const EDIT = 'edit';
	const DETAIL = 'detail';
	const SEARCH = 'search';

	//複数のページで構成しない画面に使用する。
	const SIMPLE = 'simple';
}
