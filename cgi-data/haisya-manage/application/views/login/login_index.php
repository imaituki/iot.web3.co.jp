<div style="float:none; margin:0px auto;">
	<?php echo form_open($this->common_form_action_base . 'check/', array('class' => 'well form-horizontal')); ?>

	<div class="control-group <?php echo has_form_error('user_code'); ?>">
		<label for="user_code_label">ユーザーコード</label>
		<div>
			<?php echo form_nds_input('user_code', $this->data, ' id="user_code_label" '); ?>
			<?php echo form_error('user_code'); ?>
		</div>
	</div>

	<div class="control-group <?php echo has_form_error('password'); ?>">
		<label for="password_label">パスワード</label>
		<div>
			<?php echo form_nds_password('password', $this->data, 'id="password_label"'); ?>
			<?php echo form_error('password'); ?>
		</div>
	</div>

	<?php echo error_msg($this->error_list, 'login_failed'); ?>

	<div style="margin:0px auto;">
		<button type="submit" class="btn btn-primary">ログイン</button>
		<a href="<?php echo site_url('login/login/'); ?>" class="btn">キャンセル</a>
	</div>

	<?php echo form_close(); ?>
</div><!--/span-->
