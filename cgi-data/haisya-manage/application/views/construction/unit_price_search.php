<?php echo form_open($this->common_form_action_base . 'search/', array('method' => 'GET', 'id' => 'common_form', 'class' => 'well form-horizontal')); ?>
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">工種ID</label>
			<div class="controls">
				<?php echo form_nds_input('cond_construction_type_code', $this->data, 'id="cond_construction_type_code_label"'); ?>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="">工種名</label>
			<div class="controls">
				<?php echo form_nds_input('cond_construction_type_name', $this->data, 'id="cond_construction_type_name_label"'); ?>
			</div>
		</div>
	</div>
	</div>

	<div class="form-actions" style="margin:0px auto;">
		<input type="submit" name="search" value="検索" class="btn btn-primary" />
	</div>
<?php echo form_close(); ?>

<div class="row-fluid" style="margin-bottom: 25px;">
	<div class="span3">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn "><i class="icon-plus "></i>  　新規登録</a>
	</div>
</div>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th>工種ID</th>
		<th>種別ID </th>
		<th>処理場ID </th>
		<th>車輌扱いID </th>
		<th>単価 </th>
		<th>ポイント </th>
		<th style="width: 150px;">&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td><?php echo h($this->construction_type_id_list[$value['construction_type_id']]); ?>&nbsp;</td>
		<td><?php echo h($this->construction_detail_id_list[$value['construction_detail_id']]); ?>&nbsp;</td>
		<td><?php echo h($this->disposal_id_list[$value['disposal_id']]); ?>&nbsp;</td>
		<td><?php echo h($this->car_class_id_list[$value['car_class_id']]); ?>&nbsp;</td>
		<td><?php echo h($value['unit_price']); ?>&nbsp;</td>
		<td><?php echo h($value['point']); ?>&nbsp;</td>
		<td>
			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-edit icon-white"></i>  編集</a>
			
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
