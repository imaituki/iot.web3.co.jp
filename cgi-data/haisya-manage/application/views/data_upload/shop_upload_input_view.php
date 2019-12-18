<div class="span10 mainArea">

<?php echo form_open_multipart($this->common_form_action_base . 'submit/', array('id' => 'common_form', 'class' => 'well form-horizontal')); ?>

	<label class="checkbox"><?php echo form_nds_checkbox('commit_flg', Valid_flg::VALID, $this->data, ' class="" '); ?>実際に反映させる</label>
	<?php echo form_error('commit_flg'); ?>
	
	<br /><br />
	
	<div class="form-actions" style="margin:0px auto;">
		<input type="submit" name="search" value="アップロード" class="btn btn-primary" />
	</div>

<?php echo form_close(); ?>

<div class="inputArea"><!-- スクロール -->

<table class="table table-bordered">
<thead>
	<tr></tr>
</thead>
<tbody>
<?php foreach ($this->display_data as $mansion_id => $mansion): ?>
	<tr>
		<td><?php echo $mansion['mansion_name']; ?></td>
	</tr>
<?php endforeach; ?>
<?php foreach ($this->error_list as $error_message): ?>
	<tr>
		<td>
			<div class="alert alert-error"><?php echo $error_message; ?></div>
		</td>
	</tr>
<?php endforeach; ?>
<?php foreach ($this->warning_list as $key => $error_message): ?>
	<tr>
		<td>
			<div class="alert"><?php echo $key; ?></div>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

</div><!-- /スクロール -->

</div>
