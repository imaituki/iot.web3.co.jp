
<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<?php $column_no_order_list = explode(',', $basic_column_order_num_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php 
		//連番のキーを作成
		$title_key = "basic_form{$column_no}_title";
		$form_type_key = "basic_form{$column_no}_form_type";
	?>
	<?php if ($this->data[$form_type_key] !== Form_type::NONE): ?>
	<tr>
		<th class="span4"><?php echo h($this->data[$title_key]); ?></th>
		<td>
			<?php if ($column_no == Mail_form_column::NAME): ?>
				<!-- お名前 -->
				<?php echo h($name); ?>

			<?php elseif ($column_no == Mail_form_column::FURIGANA): ?>
				<!-- フリガナ -->
				<?php echo h($furigana); ?>

			<?php elseif ($column_no == Mail_form_column::COMPANY): ?>
				<!-- 会社・団体名 -->
				<?php echo h($company_name); ?>

			<?php elseif ($column_no == Mail_form_column::POSITION): ?>
				<!-- 役職等 -->
				<?php echo h($position); ?>

			<?php elseif ($column_no == Mail_form_column::MAIL): ?>
				<!-- メールアドレス -->
				<?php echo h($email); ?>

			<?php elseif ($column_no == Mail_form_column::PHONE): ?>
				<!-- 電話番号 -->
				<?php echo h($phone_number); ?>

			<?php elseif ($column_no == Mail_form_column::POSTAL_CODE): ?>
				<!-- 郵便番号 -->
				<?php if (is_not_blank($postal_code1) && is_not_blank($postal_code2)): ?>
				〒<?php echo h($postal_code1); ?> - <?php echo h($postal_code2); ?>
				<?php endif; ?>

			<?php elseif ($column_no == Mail_form_column::PLACE): ?>
				<!-- 所在地 -->
				<?php echo h($place); ?>

			<?php elseif ($column_no == Mail_form_column::OTHER_INQUIRY): ?>
				<!-- その他お問い合わせ等 -->
				<?php echo h_br($other_inquiry); ?>

			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php endforeach; ?>
</tbody>
</table>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">詳細情報</th>
	</tr>
</thead>
<tbody>
	<?php $column_no_order_list = explode(',', $optional_column_order_num_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php 
		//連番のキーを作成
		$title_key = "optional_form{$column_no}_title";
		$form_type_key = "optional_form{$column_no}_form_type";
		$require_flg_key = "optional_form{$column_no}_require_flg";
		$input_key = "optional_form{$column_no}_input";
	?>
	<?php if ($this->data[$form_type_key] !== Form_type::NONE): ?>
	<tr>
		<th class="span4"><?php echo h($this->data[$title_key]); ?></th>
		<td>
			<?php if ($this->data[$form_type_key] === Form_type::TEXTAREA): ?>
				<!-- テキストエリア -->
				<?php echo h_br($this->data[$input_key]); ?>

			<?php elseif ($this->data[$form_type_key] === Form_type::MULTI_CHECKBOX): ?>
				<!-- 複数選択項目 -->
				<?php if (is_not_blank($this->data[$input_key])): ?>
				<?php echo implode(", ", $this->data[$input_key]); ?>
				<?php endif; ?>

			<?php else: ?>
				<!-- テキストボックスなど -->
				<?php echo h($this->data[$input_key]); ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php endforeach; ?>
</tbody>
</table>

<?php echo form_close(); ?>
