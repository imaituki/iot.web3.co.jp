<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("construction_type/construction_type_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
			工種コード　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_type_code', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('construction_type_code'); ?>
			<?php echo error_msg($this->error_list, 'construction_type_code_duplicate'); ?>
		</td>
	</tr>
    <tr>
        <th>分類名　<span class="label label-warning">必須</span></th>
        <td>
            <?php echo form_nds_dropdown('construction_category_id', $this->construction_category_id_list, $this->data, ' '); ?>
            <?php echo form_error('construction_category_id'); ?>
            <span class="help-block">分類を選択してください。</span>
        </td>
    </tr>
	<tr>
		<th>
			工種名　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_type_name', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('construction_type_name'); ?>
			<?php echo error_msg($this->error_list, 'construction_type_name_duplicate'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
