<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("construction_category/construction_category_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
			分類コード　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_category_code', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('construction_category_code'); ?>
			<?php echo error_msg($this->error_list, 'construction_category_code_duplicate'); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
			分類名　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_category_name', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('construction_category_name'); ?>
			<?php echo error_msg($this->error_list, 'construction_category_name_duplicate'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
