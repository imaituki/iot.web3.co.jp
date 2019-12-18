
<?php if ($this->login_user->is_nds_root()): ?>
<div class=" well" style="margin-bottom: 25px;">
	<div class="span3">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn "><i class="icon-plus "></i>  　新規登録</a>
	</div>
	<div class="span3">
		<a href="<?php echo site_url("freetext/freetext_bundle_register"); ?>" class="btn "><i class="icon-list "></i>  　一括登録</a>
	</div>
</div>
<?php endif; ?>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th style="width: 100px;">&nbsp;</th>
		<?php if ($this->basic_category_use): ?>
		<th class="span3"><?php echo $this->label_basic_category; ?></th>
		<?php endif; ?>
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
		<td>
			<span class="label"><?php echo "ID: {$value['id']}"; ?></span>
			<?php if ($value['draft_flg'] !== Draft_flg::DRAFT): ?>
				<span class="label label-success">公開</span>
			<?php else: ?>
				<span class="label label-warning">非公開</span>
			<?php endif; ?>
		</td>
		<?php if ($this->basic_category_use): ?>
		<td><?php echo h($value['basic_category_label']); ?>&nbsp;</td>
		<?php endif; ?>
		<?php if ($this->column_post_title_use): ?>
		<td>
			<?php echo h($value['post_title']); ?>
		</td>
		<?php endif; ?>
		<td>
			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-file icon-white"></i>  編集</a>
			<?php if ($this->login_user->is_nds_root()): ?>
			<a class="btn btn-danger" href="<?php echo site_url("{$this->page_path_delete}{$value['id']}"); ?>"  onclick="if ( ! confirm('削除します。よろしいですか？')){return false;}"><i class="icon-trash icon-white"></i> 削除</a>
			<?php endif; ?>
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
