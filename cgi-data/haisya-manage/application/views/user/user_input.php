<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("user/user_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
			ユーザーコード
			<?php if ($this->page_type === Page_type::REGISTER): ?>
			　<span class="label label-warning">必須</span>
			<?php endif ?>
		</th>
		<td>
			<?php if ($this->page_type === Page_type::REGISTER): ?>
				<?php echo form_nds_input('user_code', $this->data, 'size="25" maxlength="25"'); ?><br />
				<?php echo form_error('user_code'); ?>
				<?php echo error_msg($this->error_list, 'user_code_dupricate'); ?>
	
				<span class="help-block">ログイン時に使用するユーザーを識別するためのコードです。半角英数字で25文字以内で入力してください。</span>
			<?php else: ?>
				<?php echo h($user_code); ?>
			<?php endif; ?>
			
			
		</td>
	</tr>
	<tr>
		<th>
			ユーザー名　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('user_name', $this->data, 'size="40" maxlength="40"'); ?><br />
			<?php echo form_error('user_name'); ?>
			<span class="help-block">管理用に使用するユーザーの名称です。全角、半角が使用できます。</span>
		</td>
	</tr>
	<tr>
		<th>
			ユーザー名（フリガナ）　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('user_furigana', $this->data, 'size="40" maxlength="40"'); ?><br />
			<?php echo form_error('user_furigana'); ?>
		</td>
	</tr>
	<tr>
		<th>
			パスワード
			<?php if ($this->page_type === Page_type::REGISTER): ?>
			　<span class="label label-warning">必須</span>
			<?php endif ?>
		</th>
		<td>
			<?php echo form_nds_input('password', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('password'); ?>
			<span class="help-block">ログイン時に使用するパスワードです。半角英数字で25文字以内で入力してください。</span>
			<?php if ($this->page_type === Page_type::EDIT): ?>
			<div class="alert alert-info span5">
				パスワードを変更しない場合は未入力にしてください
			</div>
			<?php endif ?>
		</td>
	</tr>
	<tr>
		<th>
			アカウント種別　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_dropdown('account_type', Account_type::$SYSTEM_ACCOUNT_ARRAY, $this->data); ?><br />
			<?php echo form_error('account_type'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
