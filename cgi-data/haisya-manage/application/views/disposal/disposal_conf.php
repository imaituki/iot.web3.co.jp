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
	        処理場
		</th>
		<td>
			<?php echo h($disposal_name); ?>
		</td>
	</tr>
	<tr>
		<th>
			処理場(フリガナ)
		</th>
		<td>
			<?php echo h($disposal_furigana); ?>
		</td>
	</tr>
	<tr>
		<th>
			電話番号
		</th>
		<td>
			<?php echo h($phone_number); ?>
		</td>
	</tr>
	<tr>
		<th>
			FAX番号
		</th>
		<td>
			<?php echo h($fax_number); ?>
		</td>
	</tr>
	<tr>
		<th>
			郵便番号
		</th>
		<td>
			<?php echo h($postal_code); ?>
		</td>
	</tr>
	<tr>
		<th>
			住所
		</th>
		<td>
			<?php echo h($address); ?>
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
