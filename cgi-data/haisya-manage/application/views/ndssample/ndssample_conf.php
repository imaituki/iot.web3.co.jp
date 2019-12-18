
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
		<th class="span3">公開/非公開</th>
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
		<th class="span3"><?php echo $this->label_post_title; ?></th>
		<td>
			<?php echo h($post_title); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_sub_title_use): ?>
	<tr>
		<th class="span3"><?php echo $this->label_post_sub_title; ?></th>
		<td>
			<?php echo h($post_sub_title); ?>&nbsp;
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_content_use): ?>
	<tr>
		<th class="span3"><?php echo $this->label_post_content; ?></th>
		<td>
			<?php echo h_br($post_content); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_link_use): ?>
	<tr>
		<th class="span3"><?php echo $this->label_post_link; ?></th>
		<td>
			<span class="label" style="vertical-align:baseline;">URL</span>　<?php echo h($post_link); ?><br />
			<?php if ($this->column_post_link_text_use): ?>
			<span class="label" style="vertical-align:baseline;"><?php echo $this->label_post_link_text; ?></span>　
			<?php echo h($post_link_text); ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	<!-- 追加項目セット位置 -->
</tbody>
</table>

<!-- 画像アップロードを使用する場合に表示する -->
<?php if ($this->use_image_upload): ?>

<!-- ソート順を保持するパラメータ -->
<?php 
	$file_type_prefix = File_type::get_prefix(File_type::IMAGE);	//接頭辞を取得
	$sort_order_joined_text_key = "{$file_type_prefix}_order_str";
	$sort_order_joined_text_id = "{$sort_order_joined_text_key}_id";
	$sort_order_joined_text_tbody_key = "{$sort_order_joined_text_key}_tbody";
?>
<input type="hidden" name="<?php echo $sort_order_joined_text_key; ?>" 
                     id="<?php echo $sort_order_joined_text_id; ?>"
                     value="<?php echo h($this->data[$sort_order_joined_text_key]); ?>" />

<table class="table table-bordered table-hover imgUp">
<thead>
	<tr>
		<th colspan="2" class="table_section">画像</th>
	</tr>
</thead>
<tbody>
	<?php $column_no_order_list = explode(',', $this->data[$sort_order_joined_text_key]); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php
		$uploaded_file_key = "after_upload_{$file_type_prefix}{$column_no}";	//セッションに保持するためにアップロード後のファイル名を保持するキー
		$file_exists_flg = "{$uploaded_file_key}_exists_flg";
		$caption_key = "{$file_type_prefix}{$column_no}_caption";	//キャプション用のキー
	?>
		<tr>
		<td class="span3" >
			<input type="hidden" name="<?php echo $uploaded_file_key; ?>" value="<?php echo h($this->data[$uploaded_file_key]); ?>" />
			<input type="hidden" name="<?php echo $file_exists_flg; ?>" value="<?php echo h($this->data[$file_exists_flg]); ?>" />

			<div style="width: 80px; height: 60px; overflow: hidden;">
			<?php if (is_blank($this->data[$uploaded_file_key])): ?>
				<img src="<?php echo base_url(); ?>img/no_photo.jpg" />
			<?php elseif ($this->data[$file_exists_flg]): ?>
				<img src="<?php echo $this->destination_upload_url . h($this->thumbnail_prefix . $this->data[$uploaded_file_key]); ?>" />
			<?php else: ?>
				<img src="<?php echo $this->departure_upload_url . h($this->thumbnail_prefix . $this->data[$uploaded_file_key]); ?>" />
			<?php endif; ?>
			</div>
		</td>
		<td>
			<?php if ($this->use_image_caption): ?>
			<?php echo h_br($this->data[$caption_key], TRUE,'(未入力)'); ?>
			<?php endif; ?>
		</td>
		</tr>
	<?php endforeach; ?>
</tbody>
</table>

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
