<script src="<?php echo base_url(); ?>js/datetimepicker/jquery.ui.datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>js/datetimepicker/jquery.ui.datetimepicker-jp.js"></script>
<style type="text/css">
#ui-datepicker-div select {
    width: 70px;
}
</style>
<script type="text/javascript">
$(function(){
    //$("#datetime").datepicker({dateFormat: 'yy-mm-dd'});
    $("#datetime").datetimepicker();
});
</script>

<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("attendance/attendance_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
		<th>ユーザー　<span class="label label-warning">必須</span></th>
		<td>
            <?php echo form_nds_dropdown('staff_id', $this->staff_id_list, $this->data, ' '); ?>
			<?php echo form_error('staff_id'); ?>
            <?php echo error_msg($this->error_list, 'staff_id'); ?>
            <span class="help-block">担当を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th class="span4">出勤日時　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('datetime', $this->data, 'size="25" maxlength="25" id="datetime"'); ?><br />
			<?php echo form_error('datetime'); ?>
            <?php echo error_msg($this->error_list, 'datetime'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
