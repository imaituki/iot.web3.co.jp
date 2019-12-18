<!-- Googleマップ -->
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">

	/** マップ本体 */
	var map;

	$(document).ready(function(){

		//PHPからの情報を取得する
		var current_map_latitude = "<?php echo h($latitude); ?>";
		var current_map_longitude = "<?php echo h($longitude); ?>";

		if (current_map_latitude == "" || current_map_longitude == "") {
			return;
		}

		var myOptions = {
			zoom: 13,
			center: new google.maps.LatLng(current_map_latitude, current_map_longitude),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			disableDefaultUI:true,
			draggable: false,
			disableDoubleClickZoom:true,
			scrollwheel:false
		};

		//マップを描画
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		//マーカーを描画
		pointMarker = new google.maps.Marker({
			position: map.getCenter(), 
			map: map,
			draggable: false
		});
	});
</script>

<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<div class="alert">
	表示されている内容に問題がなければ画面下の実行ボタンを押してください。
	登録/編集を確定します。
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
			<?php echo ($draft_flg === Draft_flg::DRAFT) ? '非公開' : '公開'; ?>&nbsp;
		</td>
	</tr>
	<?php if ($this->column_post_date_use): ?>
	<tr>
		<th><?php echo $this->label_post_date; ?></th>
		<td>
			<?php echo h(format_date_to_pattern($post_date)); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_new_icon_end_date_use): ?>
	<tr>
		<th><?php echo $this->label_new_icon_end_date; ?></th>
		<td>
			<?php echo h(format_date_to_pattern($new_icon_end_date)); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_publish_end_date_use): ?>
	<tr>
		<th><?php echo $this->label_publish_end_date; ?></th>
		<td>
			<?php echo h(format_date_to_pattern($publish_end_date)); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->basic_category_use): ?>
	<tr>
		<th><?php echo $this->label_basic_category; ?></th>
		<td>
			<?php echo h($this->label_list['basic_category_ids']); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_order_number_use): ?>
	<tr>
		<th><?php echo $this->label_order_number; ?></th>
		<td>
			<?php echo h($order_number); ?>
		</td>
	</tr>
	<?php endif; ?>
<tr>
	<th>管理コード</th>
	<td>
		<?php echo h($management_code); ?>
	</td>
</tr>
<tr>
	<th>表示サイト</th>
	<td>
		<?php echo h($this->label_list['site_type']); ?>
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
		<th class="span4"><?php echo $this->label_post_title; ?></th>
		<td>
			<?php echo h($post_title); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_sub_title_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_sub_title; ?></th>
		<td>
			<?php echo h($post_sub_title); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_content_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_content; ?></th>
		<td>
			<?php echo h_br($post_content); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_link_use): ?>
	<tr>
		<th class="span4"><?php echo $this->label_post_link; ?></th>
		<td>
			<span class="label" style="vertical-align:baseline;">URL</span>　<?php echo h($post_link); ?><br />
			<?php if ($this->column_post_link_text_use): ?>
			<span class="label" style="vertical-align:baseline;"><?php echo $this->label_post_link_text; ?></span>　
			<?php echo h($post_link_text); ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
<tr>
	<th>TEL</th>
	<td>
		<?php echo h($phone_number); ?>
	</td>
</tr>
</tbody>
</table>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">地図</th>
	</tr>
</thead>
<tr>
	<th class="span4">エリア</th>
	<td>
		<?php echo h($this->label_list['area']); ?>
	</td>
</tr>
<tr>
	<th>都道府県</th>
	<td>
		<?php echo h($this->label_list['prefecture_code']); ?>
	</td>
</tr>
<tbody>
<tr>
	<th>住所</th>
	<td>
		<?php echo h($place); ?>
	</td>
</tr><tr>
	<th>建物等</th>
	<td>
		<?php echo h($place2); ?>
	</td>
</tr>
	<tr>
		<th>緯度、経度</th>
		<td>
			<?php if (is_not_blank($latitude) && is_not_blank($longitude)): ?>
			緯度：<?php echo h($latitude); ?>、経度：<?php echo h($longitude); ?>
			<?php endif; ?>
			<div id="map_canvas" style="width:450px; height:350px"></div>
		</td>
	</tr>
	<!-- 追加項目セット位置 -->
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
<ul id="image_sortable" class="" style="width: 100%">
	<?php $column_no_order_list = explode(',', $image_order_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php
		$target_form_key = "upload_image{$column_no}";	//ファイルアップロードのフォーム名称のキー
		$uploaded_file_key = "after_upload_image{$column_no}";	//セッションに保持するためにアップロード後のファイル名を保持するキー
		$file_exists_flg = "{$uploaded_file_key}_exists_flg";
		$caption_key = "image{$column_no}_caption";	//キャプション用のキー
		$paragraph_title_key = "image{$column_no}_paragraph_title";
	?>
	
		<?php if ($this->use_image_paragraph_title): ?>
		<?php if (is_not_blank($this->data[$paragraph_title_key]) && is_not_blank($this->data[$uploaded_file_key])): ?>

		<li class="conf_paragraph_title conf_paragraph_title_clear ">
			<div class="label label-success" style="height: 30px;">
				<span class="label" style="vertical-align:baseline;">章タイトル</span>　<?php echo h($this->data[$paragraph_title_key]); ?>
			</div>
		</li>
		<?php endif; ?>
		<?php endif; ?>

		<li id="tr_<?php echo $column_no; ?>" class="<?php echo ($this->use_image_caption) ? 'sortable_image' : 'sortable_image_no_caption' ?>" >
			<input type="hidden" name="<?php echo $uploaded_file_key; ?>" value="<?php echo h($this->data[$uploaded_file_key]); ?>" />

			<table>
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
					<td style="width: 230px; vertical-align: top;">
						<span class="label">キャプション</span><br />
						<?php echo h_br($this->data[$caption_key], TRUE,'(未入力)'); ?>
					</td>
					<?php else: ?>
					<td></td>
					<?php endif; ?>
				</tr>
			</table>

		</li>
	<?php endforeach; ?>
</ul>
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
		</th>
		<td class="span3">
			<?php if (is_blank($this->data[$uploaded_file_key])): ?>
				なし
			<?php else: ?>
				<?php if ($this->data[$file_exists_flg]): ?>
					<a href="<?php echo $this->destination_upload_url . h($this->data[$uploaded_file_key]);?>" class="btn" target="_blank"><i class="icon-file"></i> ファイル確認</a>
				<?php else: ?>
					<a href="<?php echo $this->departure_upload_url . h($this->data[$uploaded_file_key]);?>" class="btn" target="_blank"><i class="icon-file"></i> ファイル確認</a>
				<?php endif; ?>
			<?php endif; ?>
		</td>
		<td class="span4">
			<span class="label">表示用ファイル名</span><br />
			<?php echo h($this->data[$title_key]); ?>
		<td>
			<span class="label">キャプション</span><br />
			<?php echo h_br($this->data[$caption_key]); ?>
		</td>
	</tr>
	<?php endfor; ?>
</tbody>
</table>

<?php endif; ?>

<div class="form-actions">
	<input type="submit" class="btn btn-primary" value="　実行　" />
	<input type="button" class="btn" value="　戻る　" 
		onclick="$('#common_form').attr('action', '<?php echo site_url($this->common_form_action_base . 'back/'); ?>');$('#common_form').submit();" />
</div>

<?php echo form_close(); ?>
