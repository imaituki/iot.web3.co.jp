<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<div class="alert">
	以下の内容で変更を行います。問題がなければ画面下の実行ボタンを押してください。
	変更を確定します。
</div>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th class="span4">新しいパスワード　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo h($new_password); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" class="btn btn-primary" value="　実行　" />
	<input type="button" class="btn" value="　戻る　" 
		onclick="$('#common_form').attr('action', '<?php echo site_url($this->common_form_action_base . 'back/'); ?>');$('#common_form').submit();" />
</div>

<?php echo form_close(); ?>
