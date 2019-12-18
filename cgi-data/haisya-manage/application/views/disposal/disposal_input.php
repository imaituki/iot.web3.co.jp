<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("disposal/disposal_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
</div>

<?php echo h_error($this->error_msg); ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th class="span4">
			処理場　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('disposal_name', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('disposal_name'); ?>
			<?php echo error_msg($this->error_list, 'disposal_name_duplicate'); ?>
		</td>
	</tr>
	<tr>
		<th>
			処理場(フリガナ)　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('disposal_furigana', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('disposal_furigana'); ?>
		</td>
	</tr>
	<tr>
		<th>
		    電話番号	
		</th>
		<td>
			<?php echo form_nds_input('phone_number', $this->data, ''); ?><br />
			<?php echo form_error('phone_number'); ?>
		</td>
	</tr>
	<tr>
		<th>
		    FAX番号	
		</th>
		<td>
			<?php echo form_nds_input('fax_number', $this->data, ''); ?><br />
			<?php echo form_error('fax_number'); ?>
		</td>
	</tr>
	<tr>
		<th>
		    郵便番号
		</th>
		<td>
			<?php echo form_nds_input('postal_code', $this->data, ''); ?><br />
			<?php echo form_error('postal_code'); ?>
		</td>
	</tr>
	<tr>
		<th>
		    住所
		</th>
		<td>
			<?php echo form_nds_input('address', $this->data, 'class="span9"'); ?><br />
			<?php echo form_error('address'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
