<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

	/*
	
	MapTypeId.ROADMAP - デフォルトの道路地図を表示 
	MapTypeId.SATELLITE - Google Earth の航空写真を表示 
	MapTypeId.HYBRID - 通常のビューと航空写真の混合表示 
	MapTypeId.TERRAIN - 地形情報に基づいて物理的なマップ タイルを表示します。
	*/

	/** マップ本体 */
	var map;

	/** 中心固定のマーカー */
	var pointMarker;

	$(document).ready(function(){

		//PHPからの情報を取得する
		var current_map_latitude = "<?php echo h($latitude); ?>";
		var current_map_longitude = "<?php echo h($longitude); ?>";

		//デフォルト（岡山駅）
		var latlng = new google.maps.LatLng(34.66635636391227 , 133.91823291778564);

		if (current_map_latitude != '' && current_map_longitude != '') {
			latlng = new google.maps.LatLng(current_map_latitude, current_map_longitude);
		}

		var myOptions = {
			zoom: 13,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			streetViewControl:false,
			mapTypeControl:false,
			scrollwheel: false
		};

		//マップを描画
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		//マーカーを描画
		pointMarker = new google.maps.Marker({
			position: map.getCenter(), 
			map: map,
			draggable: false
		});

		//ドラッグ中もマーカーを常に中心に固定させる
		google.maps.event.addListener(map, 'drag', function(event) {
	
			//元のマーカーを除去
			pointMarker.setMap(null);
		
			pointMarker = new google.maps.Marker({
				position: map.getCenter(), 
				map: map,
				draggable: false
			});

			//フォームの値を書き換え
			$("input[name='latitude']").val(map.getCenter().lat());
			$("input[name='longitude']").val(map.getCenter().lng());
	
		});

	});

	//ジオコーディング
	function codeAddress(targetAddress) {
	
		if (targetAddress == '') {
			alert("住所を入力してください");
			return false;
		}
	
		var address = targetAddress;
	
		geocoder = new google.maps.Geocoder();
	
		if (geocoder) {
			geocoder.geocode( { 'address': address}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
			
					map.setCenter(results[0].geometry.location);
				
					$("input[name='latitude']").val(results[0].geometry.location.lat());
					$("input[name='longitude']").val(results[0].geometry.location.lng());

					//マーカーを再セット
					pointMarker.setMap(null);
				
					pointMarker = new google.maps.Marker({
						position: map.getCenter(), 
						map: map,
						draggable: false
					});

				} else {
					alert("緯度経度の抽出に失敗しました");
				}
			});
		}
	}

</script>


<!-- 画像アップロード用JSファイル -->
<script src="<?php echo base_url(); ?>js/ndsImageUpload.js" ></script>
<!-- 画像ソート用JSファイル -->
<script src="<?php echo base_url(); ?>js/ndsSortImage.js" ></script>

<SCRIPT Language="JavaScript">
<!--
	$(document).ready(function(){
		//外部JSファイルを使用して画像ソートの設定を読み込む。
		set_sort_logic();
	});
// -->
</SCRIPT>

<!-- DatePickerを設定 -->
<SCRIPT Language="JavaScript">
<!--
	$(document).ready(function(){
		//dataPickerを設定
		$("#post_date_id").datepicker();
		$("#new_icon_end_date_id").datepicker();
		$("#publish_end_date_id").datepicker();
	});
// -->
</SCRIPT>
<!-- //DatePickerを設定 -->

<div>

<?php echo form_open_multipart($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<!-- JSファイルからフォームのアクション先を取得するためのhidden要素 -->
<input type="hidden" id="common_form_action_base" value="<?php echo site_url($this->common_form_action_base); ?>" />
<!-- 画像のアップロード、削除で対象の画像を特定するhidden要素 -->
<input type="hidden" name="target_image_id" id="target_image_id" value="" />

<?php if ($this->page_type == Page_type::EDIT): ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url($this->page_path_search_again); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
</div>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">管理情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th class="span4">公開/非公開</th>
		<td>
			<label class="checkbox"><?php echo form_nds_checkbox('draft_flg', Draft_flg::DRAFT, $this->data, 'class="checkbox"'); ?>&nbsp;非公開</label>
			<span class="help-block">非公開にチェックした場合は公開されません</span>
			<?php echo form_error('draft_flg'); ?>
		</td>
	</tr>
	<?php if ($this->column_post_date_use): ?>
	<tr>
		<th><?php echo $this->label_post_date; ?>　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('post_date', $this->data, 'class="input-medium" id="post_date_id" size="10" maxlength="10"'); ?>
			<span class="help-block">yyyy/mm/dd形式で入力してください。</span>
			<?php echo form_error('post_date'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_new_icon_end_date_use): ?>
	<tr>
		<th><?php echo $this->label_new_icon_end_date; ?></th>
		<td>
			<?php echo form_nds_input('new_icon_end_date', $this->data, 'class="input-medium" id="new_icon_end_date_id" size="10" maxlength="10"'); ?>
			<span class="help-inline">yyyy/mm/dd形式で入力してください。</span>
			<span class="help-block">※NEWアイコンを表示させない場合はブランクにしてください</span>
			<?php echo form_error('new_icon_end_date'); ?>
			<?php echo error_msg($this->error_list, 'new_icon_date_reverse_date_error'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_publish_end_date_use): ?>
	<tr>
		<th><?php echo $this->label_publish_end_date; ?></th>
		<td>
			<?php echo form_nds_input('publish_end_date', $this->data, 'class="input-medium" id="publish_end_date_id" size="10" maxlength="10"'); ?>
			<span class="help-inline">yyyy/mm/dd形式で入力してください。</span>
			<span class="help-block">※公開し続ける場合はブランクにしてください。</span>
			<?php echo form_error('publish_end_date'); ?>
			<?php echo error_msg($this->error_list, 'publish_end_date_reverse_date_error'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->basic_category_use): ?>
	<tr>
		<th><?php echo $this->label_basic_category; ?></th>
		<td>
			<?php if ( ! empty($this->basic_category_list)): ?>
				<?php if ($this->basic_category_multi_select): ?>
					<?php foreach ($this->basic_category_list as $key => $value): ?>
					<label class="checkbox inline" ><?php echo form_nds_multi_checkbox('basic_category_ids', $key, $this->data); ?> <?php echo h($value); ?></label>
					<?php endforeach; ?>
				<?php else: ?>
					<?php echo form_nds_dropdown('basic_category_ids', $this->basic_category_list, $this->data); ?>
				<?php endif; ?>
			<?php endif; ?>

			<?php echo form_error('basic_category_ids'); ?>
			<?php echo error_msg($this->error_list, 'basic_category_ids_relation_error'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_order_number_use): ?>
	<tr>
		<th><?php echo $this->label_order_number; ?>　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('order_number', $this->data, ' class="span1" size="2" maxlength="4" '); ?>
			<?php echo form_error('order_number'); ?>
			<span class="help-block">数字で入力してください。</span>
		</td>
	</tr>
	<?php endif; ?>
<tr>
	<th>管理コード</th>
	<td>
		<?php echo form_nds_input('management_code', $this->data, ' class="" '); ?>
		<span class="help-block"></span>
		<?php echo form_error('management_code'); ?>
	</td>
</tr>
<tr>
	<th>表示サイト</th>
	<td>
		<?php foreach ($this->site_type_list as $checkbox_key => $checkbox_value): ?>
		<label class="checkbox inline"><?php echo form_nds_multi_checkbox('site_type', $checkbox_key, $this->data, ' class="" '); ?><?php echo h($checkbox_value); ?></label>
		<?php endforeach; ?>
		<?php echo form_error('site_type'); ?>
	</td>
</tr>
</tbody>
</table>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<?php if ($this->column_post_title_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_title; ?>　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('post_title', $this->data, 'class="span9" '); ?>
			<span class="help-block">最大200文字</span>
			<?php echo form_error('post_title'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_sub_title_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_sub_title; ?></th>
		<td>
			<?php echo form_nds_input('post_sub_title', $this->data, 'class="span9" '); ?>
			<span class="help-block">最大200文字</span>
			<?php echo form_error('post_sub_title'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_content_use): ?>
	<tr>
		<th class="span4">
			<?php echo $this->label_post_content; ?>　<span class="label label-warning">必須</span>
			<span class="help-block">※最大5000文字</span>
		</th>
		<td>
			<?php echo form_nds_textarea('post_content', $this->data, ' id="editor1" class="span8" rows="14"'); ?>
			<?php echo form_error('post_content'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_link_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_link; ?></th>
		<td>
			<span class="label" style="vertical-align:baseline;">URL</span>　<?php echo form_nds_input('post_link', $this->data, 'class="span9" placeholder="http://xxxxxxx" '); ?>
			<span class="help-block">URL形式で入力してください</span><br />
			<?php echo form_error('post_link'); ?>
			<?php if ($this->column_post_link_text_use): ?>
			<span class="label" style="vertical-align:baseline;"><?php echo $this->label_post_link_text; ?></span>　<?php echo form_nds_input('post_link_text', $this->data, 'class="span5" '); ?>
			<span class="help-block">リンクに使われる文字です。未入力の場合は規定値が使用されます。最大50文字</span>
			<?php echo form_error('post_link_text'); ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
<tr>
	<th>TEL</th>
	<td>
		<?php echo form_nds_input('phone_number', $this->data, ' class="" '); ?>
		<?php echo form_error('phone_number'); ?>
	</td>
</tr>
	<!-- 追加項目セット位置 -->
</tbody>
</table>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">地図</th>
	</tr>
</thead>
<tbody>
<tr>
	<th class="span4">エリア</th>
	<td>
		<?php echo form_nds_dropdown('area', $this->area_list,  $this->data, ' class="" '); ?>
		<?php echo form_error('area'); ?>
	</td>
</tr>
<tr>
	<th>都道府県</th>
	<td>
		<?php echo form_nds_dropdown('prefecture_code', $this->prefecture_code_list,  $this->data, ' class="" '); ?>
		<?php echo form_error('prefecture_code'); ?>
	</td>
</tr>
<tr>
	<th class="span4">住所</th>
	<td>
		<div class="input-append" style="margin-right: 20px;">
			<?php echo form_nds_input('place', $this->data, ' id="place2" class="span7" '); ?>
			<a class="btn" href="#" onclick="codeAddress($('input[name=\'place\']').val()); return false;" ><i class="icon-map-marker"></i> 地図にマーカー</a> 
		</div>
		
		<span class="label">建物等</span>
		<?php echo form_nds_input('place2', $this->data, ' class="span5" '); ?>
		<?php echo form_error('place2'); ?>
		
		<?php echo form_error('place'); ?>
	</td>
</tr>
<tr>
	<th>緯度, 経度
	</th>
	<td>
		<div class="input-prepend input-append" style="display: inline;">
		<span class="add-on">緯度</span>
		<?php echo form_nds_input('latitude', $this->data, 'size="20" maxlength="20"'); ?>
		</div> 
		<div class="input-prepend input-append" style="display: inline;">
		<span class="add-on">経度</span>
		<?php echo form_nds_input('longitude', $this->data, 'size="20" maxlength="20"'); ?><br />
		</div>
		
		<span class="help-block">下の地図をドラッグして緯度経度を調節できます</span>

		<div id="map_canvas" style="width:390px; height:320px"></div>

		<span class="help-block">※倍率の変更は保存されません</span>
		<?php echo form_error('latitude'); ?>
		<?php echo form_error('longitude'); ?>
		<?php echo error_msg($this->error_list, 'map_latlng_relation_error'); ?>
	</td>
</tr>
</tbody>
</table>

<!-- 画像アップロードを使用する場合に表示する -->
<?php if ($this->use_image_upload): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">画像</th>
	</tr>
</thead>
</table>
<span class="help-block">※利用できる画像の種類は「JPEG」,「PNG」です。</span>

<div class="row-fluid">

<!-- ソート順を保持するパラメータ -->
<input type="hidden" name="image_order_str" id="image_order_str_id" value="<?php echo h($image_order_str); ?>" />

<ul id="image_sortable" class="" style="width: 100%">

	<?php $column_no_order_list = explode(',', $image_order_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php
		$target_form_key = "upload_image{$column_no}";	//ファイルアップロードのフォーム名称のキー
		$uploaded_file_key = "after_upload_image{$column_no}";	//セッションに保持するためにアップロード後のファイル名を保持するキー
		$file_exists_flg = "{$uploaded_file_key}_exists_flg";
		$caption_key = "image{$column_no}_caption";
		$paragraph_title_key = "image{$column_no}_paragraph_title";
	?>

		<li id="tr_<?php echo $column_no; ?>" class="<?php echo ($this->use_image_caption) ? 'sortable_image' : 'sortable_image_no_caption' ?>" >
			<input type="hidden" name="<?php echo $uploaded_file_key; ?>" value="<?php echo h($this->data[$uploaded_file_key]); ?>" />
			<input type="hidden" name="<?php echo $file_exists_flg; ?>" value="<?php echo h($this->data[$file_exists_flg]); ?>" />

			<table>
				<?php if ($this->use_image_paragraph_title): ?>
				<tr>
					<td colspan="2">
						<span class="label" style="vertical-align:baseline;">章タイトル</span><?php echo form_nds_input($paragraph_title_key, $this->data, 'id="" style="width:200px;" class="paragraph_title" placeholder="章タイトルを入力できます" '); ?>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<td>
						<a name="<?php echo $target_form_key; ?>"></a>
						<?php if (is_blank($this->data[$uploaded_file_key])): ?>
							<img src="<?php echo base_url(); ?>img/no_photo.jpg" width="200" height="150" />
						<?php else: ?>
							<?php if ($this->data[$file_exists_flg]): ?>
								<img src="<?php echo $this->destination_upload_url . h($this->thumbnail_prefix . $this->data[$uploaded_file_key]); ?>" />
							<?php else: ?>
								<img src="<?php echo $this->departure_upload_url . h($this->thumbnail_prefix . $this->data[$uploaded_file_key]); ?>" />
							<?php endif; ?>
						<?php endif; ?>
					</td>
					<?php if ($this->use_image_caption): ?>
					<td style="width: 230px;">
						<span class="label">キャプション</span><br />
						<?php echo form_nds_textarea($caption_key, $this->data, 'style="width:200px" rows="6" placeholder="キャプションを入力できます"'); ?>
					</td>
					<?php else: ?>
					<td></td>
					<?php endif; ?>
				</tr>
				<tr>
					<td colspan="2" style="height:45px;">
						<?php if (is_blank($this->data[$uploaded_file_key])): ?>
							<input type="file" style=""; name="<?php echo $target_form_key; ?>" onchange="uploadImage('<?php echo $target_form_key; ?>');" />
						<?php else: ?>
							<input class="btn btn-danger" type="button" value="画像を削除" onclick="deleteImage('<?php echo $target_form_key; ?>');" />
						<?php endif; ?>
					</td>
				</tr>
			</table>

		<?php echo error_msg($this->error_list, $target_form_key); ?>
		<?php echo form_error($caption_key); ?>
		<?php echo form_error($paragraph_title_key); ?>
		</li>
	<?php endforeach; ?>
</ul>

</div>

<div class="pull-right">
<a href="#" title="このページのトップへ">このページのトップへ</a>
</div>

<?php endif; ?>

<!-- ダウンロード用ファイルを使用する場合に表示する -->
<?php if ($this->use_doc_upload): ?>
<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="4" class="table_section">ダウンロード用ファイル</th>
	</tr>
</thead>
<tbody>
	<?php for ($i = 1; $i <= $this->max_doc_file; $i++): ?>
	<?php
		$target_form_key = "upload_doc{$i}";	//ファイルアップロードのフォーム名称のキー
		$uploaded_file_key = "after_upload_doc{$i}";	//セッションに保持するためにアップロード後のファイル名を保持するキー
		$file_exists_flg = "{$uploaded_file_key}_exists_flg";
		$caption_key = "doc{$i}_caption";	//キャプション用のキー
		$title_key = "doc{$i}_title";	//キャプション用のキー
	?>
	<tr>
		<th class="span2">
			ファイル<?php echo $i; ?>
			<input type="hidden" name="<?php echo $uploaded_file_key; ?>" value="<?php echo h($this->data[$uploaded_file_key]); ?>" />
			<input type="hidden" name="<?php echo $file_exists_flg; ?>" value="<?php echo h($this->data[$file_exists_flg]); ?>" />
		</th>
		<td class="span3">
			<?php if (is_blank($this->data[$uploaded_file_key])): ?>
				<input type="file" name="<?php echo $target_form_key; ?>" onchange="uploadImage('<?php echo $target_form_key; ?>');" />
			<?php else: ?>
				<div class="alert alert-info">アップ済み</div>
				<input class="btn btn-danger" type="button" value="ファイルを削除" onclick="deleteImage('<?php echo $target_form_key; ?>');" />
			<?php endif; ?>
		</td>
		<td class="span4">
			<span class="label">表示用ファイル名</span><br />
			<?php echo form_nds_input($title_key, $this->data, 'id="" style="width:200px;" class="" placeholder="" '); ?>
			<span class="help-block" style="width: 250px;">未入力の場合は「ダウンロードはこちら」が表示されます</span>
			<?php echo form_error($title_key); ?>
		<td>
			<span class="label">キャプション</span><br />
			<?php echo form_nds_textarea($caption_key, $this->data, 'class="span5" rows="2" '); ?>
			<div>
				<a name="<?php echo $target_form_key; ?>"></a>
				<?php echo error_msg($this->error_list, $target_form_key); ?>
				<?php echo form_error($caption_key); ?>
			</div>
		</td>
	</tr>
	<?php endfor; ?>
</tbody>
</table>

<?php endif; ?>
<div class=" pull-right">
<a href="#" title="このページのトップへ">このページのトップへ</a>
</div>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>

</div>
