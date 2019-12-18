<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<div class="alert">
	表示されている内容に問題がなければ画面下の実行ボタンを押してください。
	登録/編集を確定します。
</div>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
<tr>
	<th class="span4">親区分ID</th>
	<td>
		<?php echo h($this->kubun_id_list[$parent_kubun_id]); ?>
	</td>
</tr>
<tr>
	<th>関連データタイプ</th>
	<td>
		<?php echo Relation_data_type::get_label($relation_data_type); ?>
	</td>
</tr>
<tr>
	<th>区分種別</th>
	<td>
		<?php echo Kubun_type::get_label($kubun_type); ?>
	</td>
</tr>
<tr>
	<th>区分コード</th>
	<td>
		<?php echo h($kubun_code); ?>
	</td>
</tr>
<tr>
	<th>区分値</th>
	<td>
		<?php echo h($kubun_value); ?>
	</td>
</tr>
<tr>
	<th>詳細</th>
	<td>
		<?php echo h($description); ?>
	</td>
</tr>
<tr>
	<th>ソート順</th>
	<td>
		<?php echo h($order_number); ?>
	</td>
</tr>
<tr>
	<th>アイコンファイル名</th>
	<td>
		<?php echo h($icon_file_name); ?>
	</td>
</tr>
<tr>
	<th>アイコンファイル名2</th>
	<td>
		<?php echo h($icon_file_name2); ?>
	</td>
</tr>
</tbody>
</table>

<?php if ($this->page_type !== Page_type::DETAIL): ?>
<?php //詳細画面では表示しない ?>
<div class="form-actions">
	<input type="submit" class="btn btn-primary" value="　実行　" />
	<input type="button" class="btn" value="　戻る　" 
		onclick="$('#common_form').attr('action', '<?php echo site_url($this->common_form_action_base . 'back/'); ?>');$('#common_form').submit();" />
</div>
<?php endif; ?>

<?php echo form_close(); ?>
