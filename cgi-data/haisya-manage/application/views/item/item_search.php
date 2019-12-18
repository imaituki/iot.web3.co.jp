
<?php echo form_open($this->common_form_action_base . 'search/', array('method' => 'GET', 'id' => 'common_form', 'class' => 'well form-horizontal')); ?>
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">データID</label>
			<div class="controls">
				<?php echo form_nds_input('cond_id', $this->data, 'id="" class="input-mini"'); ?>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="">公開/非公開</label>
			<div class="controls">
				<?php echo form_nds_dropdown('cond_draft_flg', Draft_flg::get_dropdown_list() ,$this->data, 'id=""'); ?>
			</div>
		</div>
	</div>
	</div>

	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span7">
			<label class="control-label" for="">キーワード</label>
			<div class="controls">
				<?php echo form_nds_input('cond_keyword', $this->data, ' class="input-xlarge" placeholder="スペース区切りで複数キーワードを指定可能"'); ?>
				<span class="help-inline"><?php echo $this->label_keyword_search_condition; ?>を検索します</span>
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
		<div class="control-group span5">
			<label class="control-label" for="">属性</label>
			<div class="controls">
			<?php if ( ! empty($this->other_attribute_list)): ?>
			<?php foreach ($this->other_attribute_list as $key => $value): ?>
			<label class="checkbox inline" ><?php echo form_nds_multi_checkbox('cond_other_attribute_ids', $key, $this->data); ?> <?php echo h($value); ?></label>
			<?php endforeach; ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
	</div>
	<?php endif; ?>


	<div class="form-actions" style="margin:0px auto;">
		<input type="submit" name="search" value="検索" class="btn btn-primary" />
		<input type="button" class="btn" value="CSVダウンロード" 
			onclick="
				oldAction=$('#common_form').attr('action');
				$('#common_form').attr('action','<?php echo site_url($this->common_form_action_base . 'download_csv/'); ?>');
				$('#common_form').submit();
				$('#common_form').attr('action',oldAction);" />
	</div>
<?php echo form_close(); ?>

<div class="row-fluid" style="margin-bottom: 25px;">
	<div class="span3">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn btn-primary"><i class="icon-plus icon-white"></i>  　新規登録</a>
	</div>
</div>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th style="width: 100px;">データID
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/id/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'id' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/id/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'id' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
		</th>
		<?php if ($this->column_post_date_use): ?>
		<th style="width: 80px;"><?php echo $this->label_post_date; ?>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/post_date/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'post_date' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/post_date/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'post_date' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
		</th>
		<?php endif; ?>
		<?php if ($this->basic_category_use): ?>
		<th class="span3"><?php echo $this->label_basic_category; ?>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/main_category_kubun_code/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'main_category_kubun_code' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/main_category_kubun_code/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'main_category_kubun_code' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
		</th>
		<?php endif; ?>
		<?php if ($this->column_order_number_use): ?>
		<th class="span3"><?php echo $this->label_order_number; ?>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/order_number/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'order_number' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/order_number/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'order_number' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>

		</th>
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
		<th style="width: 220px;">&nbsp;</th>
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
		<?php if ($this->column_post_date_use): ?>
		<td><?php echo h(format_date_to_pattern($value['post_date'])); ?></td>
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
		<td>
			<a href="<?php echo site_url("{$this->page_path_handle_relation}{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-file icon-white"></i>  製品の情報</a>
			<a class="btn btn-danger" href="<?php echo site_url("{$this->page_path_delete}{$value['id']}"); ?>"  onclick="if ( ! confirm('削除します。よろしいですか？')){return false;}"><i class="icon-trash icon-white"></i> 削除</a>
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
