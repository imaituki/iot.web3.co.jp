<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("unit_price/unit_price_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
</div>

<?php echo h_error($this->error_msg); ?>

<?php echo error_msg($this->error_list, 'unit_price_duplicate'); ?>
<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th>工種</th>
		<td>
            <?php echo form_nds_dropdown('construction_type_id', $this->construction_type_id_list, $this->data, ' '); ?>
			<?php echo form_error('construction_type_id'); ?>
            <span class="help-block">工種を選択してください。</span>
		</td>
	</tr>
    <tr>
        <th>種別<td>
            <?php echo form_nds_dropdown('construction_detail_id', $this->construction_detail_id_list, $this->data, ' '); ?>
            <?php echo form_error('construction_detail_id'); ?>
            <span class="help-block">種別を選択してください。</span>
        </td>
    </tr>
    <tr>
        <th>処理場</th>
        <td>
            <?php echo form_nds_dropdown('disposal_id', $this->disposal_id_list, $this->data, ' '); ?>
            <?php echo form_error('disposal_id'); ?>
            <span class="help-block">処理場を選択してください。</span>
        </td>
    </tr>
    <tr>
        <th>車輌扱い</th>
        <td>
            <?php echo form_nds_dropdown('car_class_id', $this->car_class_id_list, $this->data, ' '); ?>
            <?php echo form_error('car_class_id'); ?>
            <span class="help-block">車輌扱いを選択してください。</span>
        </td>
    </tr>
	<tr>
		<th>
			単価　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('unit_price', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('unit_price'); ?>
		</td>
	</tr>
	<tr>
		<th>
			ポイント　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('point', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('point'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
