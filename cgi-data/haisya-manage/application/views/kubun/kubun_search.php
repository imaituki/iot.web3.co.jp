<div class="row-fluid" style="margin-bottom: 25px;">
	<div class="span3">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn "><i class="icon-plus "></i>  　新規登録</a>
	</div>
</div>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th>ID</th>
		<th>親区分ID</th>
		<th>データ種別</th>
		<th>区分種別</th>
		<th>区分コード</th>
		<th>区分値</th>
		<th>ソート順</th>
		<th style="width: 150px;">&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td><?php echo h($value['id']); ?>&nbsp;</td>
		<td><?php echo h($value['parent_kubun_id_label']); ?>&nbsp;</td>
		<td><?php echo Relation_data_type::get_label($value['relation_data_type']); ?>&nbsp;</td>
		<td><?php echo Kubun_type::get_label($value['kubun_type']); ?>&nbsp;</td>
		<td><?php echo h($value['kubun_code']); ?>&nbsp;</td>
		<td><?php echo h($value['kubun_value']); ?>&nbsp;</td>
		<td><?php echo h($value['order_number']); ?>&nbsp;</td>
		<td>
			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-file icon-white"></i>  編集</a>
			<a class="btn btn-danger" href="<?php echo site_url("{$this->page_path_delete}{$value['id']}"); ?>"  onclick="if ( ! confirm('削除します。よろしいですか？')){return false;}"><i class="icon-trash icon-white"></i> 削除</a>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php else: ?>

	<div class="alert alert-error">該当するデータがありません。</div>
		
<?php endif; ?>
