<?php echo error_msg($this->error_list, 'delete'); ?>

<?php if (is_blank(error_msg($this->error_list, 'delete'))): ?>
<div class="alert alert-success">

	<?php if ($this->page_type === Page_type::REGISTER): ?>
	登録を完了しました。
	<?php elseif ($this->page_type === Page_type::EDIT): ?>
	編集を完了しました。
	<?php elseif ($this->page_type === Page_type::SEARCH): ?>
	削除を完了しました。
	<?php endif; ?>

</div>
<?php endif; ?>

<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("construction_type/construction_type_search/search_again/"); ?>" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i> 一覧に戻る</a>
	</div>
</div>
