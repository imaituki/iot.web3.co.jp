<div class="alert alert-success">
	<?php if ($this->page_type === Page_type::REGISTER): ?>
	登録を完了しました。
	<?php elseif ($this->page_type === Page_type::EDIT): ?>
	編集を完了しました。
	<?php elseif ($this->page_type === Page_type::SEARCH): ?>
	削除を完了しました。
	<?php endif; ?>
</div>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url($this->page_path_search_again); ?>" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i> 戻る</a>
	</div>
</div>
