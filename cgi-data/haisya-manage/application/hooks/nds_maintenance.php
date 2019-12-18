<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance {

	/**
	 * メンテナンス画面を表示する
	 */
	public function maintenance() {

		$config = load_class('Config', 'core');

		if ($config->item('maintenance_mode') === TRUE) {
			include APPPATH . 'views/' . $config->item('maintenance_view') . '.php';
			exit();
		}
	}
}