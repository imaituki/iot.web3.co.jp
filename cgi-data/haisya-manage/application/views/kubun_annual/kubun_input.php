<?php echo form_open($this->common_form_action_base . 'conf/'); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("kubun_annual/kubun_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
<tr>
	<th class="span4">使用可否　<span class="label label-warning">必須</span></th>
	<td>
		<label class="checkbox"><?php echo form_nds_checkbox('valid_flg', Valid_flg::VALID, $this->data, ' class="" '); ?> 使用する</label>
		<?php echo form_error('valid_flg'); ?>
	</td>
</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
