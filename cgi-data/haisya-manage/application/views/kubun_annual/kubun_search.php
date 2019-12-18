
<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th>年度</th>
		<th>使用可否</th>
		<th style="width: 200px;">&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td><?php echo h($value['kubun_value']); ?>&nbsp;</td>
		<td>
			<?php if ($value['valid_flg'] == Valid_flg::VALID): ?>
				<span class="label label-success">使用する</span>
			<?php else: ?>
				<span class="label label-warning">使用しない</span>
			<?php endif; ?>
		</td>
		<td>
			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-file icon-white"></i>  編集</a>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>

<?php else: ?>

	<div class="alert alert-error">該当するデータがありません。</div>
		
<?php endif; ?>
