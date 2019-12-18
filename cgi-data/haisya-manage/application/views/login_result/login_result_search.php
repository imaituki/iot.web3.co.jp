
<?php echo form_open($this->common_form_action_base . 'search/', array('method' => 'GET', 'id' => 'common_form', 'class' => 'well form-horizontal')); ?>

	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">会員</label>
			<div class="controls">
				<?php echo form_nds_dropdown('cond_member_id', $this->member_list, $this->data, 'id=""'); ?>
			</div>
		</div>
	</div>
	</div>

	<?php if ($this->basic_category_use): ?>
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for=""><?php echo $this->label_basic_category; ?></label>
			<div class="controls">
				<?php echo form_nds_dropdown('cond_basic_category_ids', $this->basic_category_list, $this->data, 'id=""'); ?>
			</div>
		</div>
	</div>
	</div>
	<?php endif; ?>

	<div class="form-actions" style="margin:0px auto;">
		<input type="submit" name="search" value="検索" class="btn btn-primary" />
	</div>
<?php echo form_close(); ?>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th style="width: 140px;">ログイン日時
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/login_datetime/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'login_datetime' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/login_datetime/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'login_datetime' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
		</th>
		<th>会員</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td><?php echo h(format_date_to_pattern($value['login_datetime'], "Y/m/d  H時i分")); ?></td>
		<td>
			<span class="label">ID: <?php echo h($value['member_id']); ?></span>
			<a href="<?php echo site_url("member/member_edit/index/{$value['member_id']}"); ?>">
			<?php echo h($value['member_id_label']); ?>
			</a>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- ページング -->
<div class="pagination">
	<ul>
		<!-- 前へ -->
		<?php if ($this->nds_pagination->has_before()): ?>
		<li><a href="<?php echo site_url($this->common_form_action_base."page/{$this->nds_pagination->get_before_page()}")."/?{$this->get_query}"; ?>">前へ</a></li>
		<?php else: ?>
		<li class="disabled"><a href="#">前へ</a></li>
		<?php endif; ?>
		<!-- /前へ -->

		<!-- ページ番号表示 -->
		<?php foreach ($this->nds_pagination->get_near_page_array() as $page): ?>
			<?php if ($page === $this->nds_pagination->get_current_page()): ?>
			<li class="active"><a href="#"><?php echo $this->nds_pagination->get_current_page(); ?></a></li>
			<?php else: ?>
			<li><a href="<?php echo site_url($this->common_form_action_base."page/{$page}?{$this->get_query}"); ?>"><?php echo $page; ?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
		<!-- /ページ番号表示 -->

		<!-- 次へ -->
		<?php if ($this->nds_pagination->has_next()): ?>
		<li><a href="<?php echo site_url($this->common_form_action_base."page/{$this->nds_pagination->get_next_page()}")."/?{$this->get_query}"; ?>">次へ</a></li>
		<?php else: ?>
		<li class="disabled"><a href="#">次へ</a></li>
		<?php endif; ?>
		<!-- /次へ -->
	</ul>
</div>
<!-- /ページング -->

<?php else: ?>

	<div class="alert alert-error">該当するデータがありません。</div>
		
<?php endif; ?>
