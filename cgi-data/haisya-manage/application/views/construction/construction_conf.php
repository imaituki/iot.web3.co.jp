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
		<th>
			ステータス
		</th>
		<td>
			<?php echo h($this->construction_status_list[$construction_status]); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
	        工事コード
		</th>
		<td>
			<?php echo h($construction_code); ?>
		</td>
	</tr>
	<tr>
		<th>
			顧客名
		</th>
		<td>
			<?php echo h($this->customer_id_list[$customer_id]); ?>
		</td>
	</tr>
	<tr>
		<th>
			現場名
		</th>
		<td>
			<?php echo h($construction_name); ?>
		</td>
	</tr>
	<tr>
		<th>
			住所
		</th>
		<td>
			<?php echo h($construction_address); ?>
		</td>
	</tr>
	<tr>
		<th>
		    緯度／経度	
		</th>
		<td>
			緯度：<?php echo h($latitude); ?>&nbsp;&nbsp;&nbsp;&nbsp;経度：<?php echo h($longitude); ?>
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
