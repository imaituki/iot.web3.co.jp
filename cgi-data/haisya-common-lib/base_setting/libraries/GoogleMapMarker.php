<?php 

/**
 * 
 * googlemap用のクラス
 * @author ta-ando
 *
 */
class GoogleMapMarker
{
	var $title;
	
	var $icon;
	
	var $lat;
	
	var $lng;
	
	var $link;
	
	var $company_id;

	var $map_place;

	/** 業種名 */
	var $industry_label;

	/**
	 * 初期化処理
	 * 
	 * @param unknown_type $lat
	 * @param unknown_type $lng
	 * @param unknown_type $title
	 * @param unknown_type $icon
	 */
	function init($lat, $lng, $title = "", $icon = "")
	{
		$this->lat = $lat;
		$this->lng = $lng;
		$this->title = $title;
		$this->icon = $icon;
	}
}


?>
