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
		<th class="span4">
	        種別ID
		</th>
		<td>
			<?php echo h($construction_detail_code); ?>
		</td>
	</tr>
<?php /*
	<tr>
		<th>
			工種
		</th>
		<td>
			<?php echo h($this->construction_category_id_list[$construction_category_id]); ?>
		</td>
	</tr>
 */?>
	<tr>
		<th>
			種別
		</th>
		<td>
			<?php echo h($construction_detail_name); ?>
		</td>
	</tr>
	<tr>
		<th>
			重量
		</th>
		<td>
			<?php echo h($weight); ?>
		</td>
	</tr>
	<tr>
		<th>
			単位
		</th>
		<td>
			<?php echo h($unit); ?>
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
