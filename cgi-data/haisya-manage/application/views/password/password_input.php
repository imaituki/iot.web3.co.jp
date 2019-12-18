<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php echo h_error($this->error_msg); ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th class="span4">現在のパスワード　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('old_password', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('old_password'); ?>
			<?php echo error_msg($this->error_list, 'old_password_match_error'); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">新しいパスワード　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_password('new_password', $this->data, 'size="25" maxlength="25"'); ?>
			<?php echo form_error('new_password'); ?>
			<span class="help-block">ログイン時に使用するパスワードです。半角英数字で入力してください。</span>
			<?php echo form_nds_password('new_password_retype', $this->data, 'size="25" maxlength="25"'); ?> (確認用)
			<span class="help-block">確認のため確認用欄にも同じパスワードを入力してください。</span>
			<?php echo form_error('new_password_retype'); ?>
			<?php echo error_msg($this->error_list, 'new_password_match_error'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
