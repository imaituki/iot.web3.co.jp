
<?php echo form_open($this->common_form_action_base . 'search/', array('method' => 'GET', 'id' => 'common_form', 'class' => 'well form-horizontal')); ?>

	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span7">
			<label class="control-label" for="">キーワード</label>
			<div class="controls">
				<?php echo form_nds_input('cond_keyword', $this->data, ' class="span5" placeholder="スペース区切りで複数キーワードを指定可能"'); ?>
				<span class="help-block"><?php echo $this->label_keyword_search_condition; ?>を検索します</span>
			</div>
		</div>
	</div>
	</div>

	<div class="form-actions" style="margin:0px auto;">
		<input type="submit" name="search" value="検索" class="btn btn-primary" />
	</div>
<?php echo form_close(); ?>


<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th style="width: 140px;">最終検索日時
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/last_update_datetime/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'last_update_datetime' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/last_update_datetime/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'last_update_datetime' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
		</th>
		<?php if ($this->column_post_title_use): ?>
		<th>
			<?php echo $this->label_post_title; ?>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/post_title/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'post_title' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/post_title/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'post_title' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
		</th>
		<?php endif; ?>
		<th style="width: 150px;">&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<?php if ($this->column_post_date_use): ?>
		<td><?php echo h(format_date_to_pattern($value['last_update_datetime'], "Y/m/d H:i:s")); ?></td>
		<?php endif; ?>
		<?php if ($this->basic_category_use): ?>
		<td><?php echo h($value['basic_category_label']); ?>&nbsp;</td>
		<?php endif; ?>
		<?php if ($this->column_order_number_use): ?>
		<td>
			<?php echo h($value['order_number']); ?>
		</td>
		<?php endif; ?>
		<?php if ($this->column_post_title_use): ?>
		<td><?php echo h($value['post_title']); ?></td>
		<?php endif; ?>
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
