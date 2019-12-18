<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * ページング情報を管理するクラス
 * @author ta-ando
 *
 */
class Nds_pagination
{
	/** 現在ページの左右に表示する個数 $disp_range×2+1が表示する実際の個数 */
	var $disp_range = 5;

	var $offset;

	var $limit;

	var $order_by_array = array();

	var $total = 0;

	var $current_page = 1;

	/*
	 * コンストラクタ
	 * 
	 * @param unknown_type $limit 最大表示件数。FALSEの場合は制限なし
	 * @param unknown_type $page 表示ページ
	 */
	public function __construct($limit = FALSE, $page = 1)
	{
		$this->limit = ($limit) ? $limit : 0;
		$this->offset = 0;

		$this->set_page($page);
	}

	/**
	 * 表示するページ番号をセットする
	 * 
	 * @param unknown_type $page
	 */
	public function set_page($page = 1)
	{
		if ( ! is_numeric($page) or $page < 1)
		{
			$page = 1;
		}

		$page = (int)$page;

		$this->current_page = $page;
		$this->offset = ($page - 1) * $this->limit;

		if ($this->offset < 0)
		{
			$this->offset = 0;
		}
	}

	/**
	 * ソート順を追加します。
	 * ※SQLのテーブルやカラムにエイリアスを使用する場合は$keyに事前にエイリアスを付けてこのメソッドを使用すること。
	 * 
	 * @param unknown_type $key
	 * @param unknown_type $sort_order
	 */
	public function add_order($key, $sort_order = 'ASC')
	{
		if (is_blank($key))
		{
			return $this;
		}

		$this->order_by_array[] = $key . ' ' . $sort_order;

		return $this;
	}

	/**
	 * SQLで使用する状態に部品を組み立てます
	 */
	public function get_sql_paging_condition()
	{
		$tmp_order_by = 'id ASC';

		if (count($this->order_by_array) != 0)
		{
			//指定があればそちらを使用
			$tmp_order_by = implode(', ', $this->order_by_array);
		}

		return array(
				'limit' => $this->limit,
				'offset' => $this->offset,
				'order_by_array' => $tmp_order_by
				);
	}

	/**
	 * 前ページが存在するかどうかを取得します。
	 * @return TRUE:存在する, false:存在しない
	 */
	public function has_before()
	{
		if ($this->offset != 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * 次ページが存在するかどうかを取得します。
	 * @return TRUE:存在する, false:存在しない
	 */
	public function has_next()
	{
		$curent_records = $this->current_page * $this->limit;

		if ($curent_records === 0)
		{
			return FALSE;
		}

		if ($this->total > $curent_records)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * 次ページのページ数を取得する
	 */
	public function get_next_page()
	{
		return $this->current_page + 1;
	}

	/**
	 * 前ページを取得する
	 */
	public function get_before_page()
	{
		return $this->current_page - 1;
	}

	/**
	 * 現在ページを取得する
	 */
	public function get_current_page()
	{
		return $this->current_page;
	}

	/**
	 * 最終ページ数を取得する
	 */
	public function get_last_page()
	{
		if ($this->limit === 0)
		{
			return 1;
		}

		return ceil($this->total / $this->limit);
	}

	/**
	 * Google風なページングを行うために表示するページの配列を作成します。
	 */
	public function get_near_page_array()
	{
		// ページの表示個数
		$disp_kosuu_max = $this->disp_range * 2 + 1;

		if ($this->get_last_page() <= $disp_kosuu_max)
		{
			/*
			 * 表示したいページの個数よりもページ数が少ない場合は全部のページを表示する
			 */
			
			$start = 1;
			$end = $this->get_last_page();
		}
		else
		{
			/*
			 * 最初のページと最後のページを取得
			 */
			
			$start = ($this->current_page - $this->disp_range) > 0
						? ($this->current_page - $this->disp_range)
						: 1;

			$end = ($this->current_page + $this->disp_range) <= $this->get_last_page() 
						? ($this->current_page + $this->disp_range)
						: $this->get_last_page();

			$kosuu = $end - $start + 1;

			/*
			 * 左右のページの個数が異なる場合があるので調整（最初のページ付近、最後のページ付近で発生）
			 */

			if ($kosuu < $disp_kosuu_max)
			{
				if (($this->current_page - $start + 1) <= $this->disp_range) 
				{
					//最初のページに近いため、左側の個数が少ない場合は、右側を増やす
					$end = $start + ($this->disp_range * 2);
				}
				else if  (($this->get_last_page() - $this->current_page + 1) <= $this->disp_range)
				{
					//最後のページに近いため、右側の個数が少ない場合は、左側を増やす
					$start = $this->get_last_page() - ($this->disp_range * 2);
				} 
			}
		}

		$ret_list = array();

		/*
		 * intにして配列に保持する
		 */

		for ($i = $start; $i < ($end + 1); $i++) 
		{
			$ret_list[] = (int)$i;
		}

		return $ret_list;
	}

	/**
	 * 現在表示中のページの最初の件数を取得する。
	 */
	function get_current_page_start_num()
	{
		return $this->offset + 1;
	}

	/**
	 * 現在表示中のページの最後の件数を取得する。
	 */
	function get_current_page_end_num()
	{
		return ($this->has_next()) 
		       ? $this->offset + $this->limit
		       : $this->total;
	}

	/**
	 * 表示しているページのリストの中に最終ページが含まれているか判定する。
	 */
	function is_near_page_array_has_last_page()
	{
		$list = $this->get_near_page_array();
		
		if (empty($list))
		{
			FALSE;
		}

		$near_last_page = end($list);

		return ($near_last_page == $this->get_last_page());
	}

	/**
	 * 表示しているページのリストの中に最初のページが含まれているか判定する。
	 */
	function is_near_page_array_has_first_page()
	{
		$list = $this->get_near_page_array();
		
		if (empty($list))
		{
			FALSE;
		}

		return ($list[0] == 1);
	}
}
