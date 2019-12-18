<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("kubun/kubun_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
	<th class="span4">親区分ID</th>
	<td>
		<?php echo form_nds_dropdown('parent_kubun_id', $this->kubun_id_list, $this->data, ' class="span7" '); ?>
		<?php echo form_error('parent_kubun_id'); ?>
		<span class="help-inline">整数で入力してください。</span>
	</td>
</tr>
<tr>
	<th>関連データタイプ　<span class="label label-warning">必須</span></th>
	<td>
		<?php echo form_nds_dropdown('relation_data_type', Relation_data_type::$CONST_ARRAY, $this->data, ' class="" '); ?>
		<?php echo form_error('relation_data_type'); ?>
	</td>
</tr>
<tr>
	<th>区分種別　<span class="label label-warning">必須</span></th>
	<td>
		<?php echo form_nds_dropdown('kubun_type', Kubun_type::$CONST_ARRAY, $this->data, ' class="" '); ?>

		<?php echo form_error('kubun_type'); ?>
	</td>
</tr>
<tr>
	<th>区分コード　<span class="label label-warning">必須</span></th>
	<td>
		<?php echo form_nds_input('kubun_code', $this->data, ' class="" '); ?>
		<?php echo form_error('kubun_code'); ?>
		<span class="help-inline">整数で入力してください。</span>
	</td>
</tr>
<tr>
	<th>区分値(ラベル)　<span class="label label-warning">必須</span></th>
	<td>
		<?php echo form_nds_input('kubun_value', $this->data, ' class="" '); ?>
		<?php echo form_error('kubun_value'); ?>
	</td>
</tr>
<tr>
	<th>詳細</th>
	<td>
		<?php echo form_nds_input('description', $this->data, ' class="span9" '); ?>
		<?php echo form_error('description'); ?>
	</td>
</tr>
<tr>
	<th>ソート順　<span class="label label-warning">必須</span></th>
	<td>
		<?php echo form_nds_input('order_number', $this->data, ' class="" '); ?>
		<?php echo form_error('order_number'); ?>
		<span class="help-inline">整数で入力してください。</span>
	</td>
</tr>
<tr>
	<th>アイコンファイル名</th>
	<td>
		<?php echo form_nds_input('icon_file_name', $this->data, ' class="" '); ?>
		<?php echo form_error('icon_file_name'); ?>
	</td>
</tr>
<tr>
	<th>アイコンファイル名2</th>
	<td>
		<?php echo form_nds_input('icon_file_name2', $this->data, ' class="" '); ?>
		<?php echo form_error('icon_file_name2'); ?>
	</td>
</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
