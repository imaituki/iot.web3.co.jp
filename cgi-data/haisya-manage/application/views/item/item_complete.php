<div class="alert alert-success">
	<?php if ($this->page_type === Page_type::REGISTER): ?>
	製品の登録を完了しました。<br />
	引き続き、製品の詳細情報の登録を行う画面に進みます。
<br /><br />
	<a href="<?php echo site_url("item/item_edit/handle_relation/{$post_id}"); ?>" >製品の詳細画面に移動する</a>
<br />
	<br />※詳細情報の登録を後で行う場合は、上メニューの[製品]-[製品を検索する]で対象の製品を選択することで<br />いつでも行うことができます。

	<?php elseif ($this->page_type === Page_type::EDIT): ?>
	編集を完了しました。
	<?php elseif ($this->page_type === Page_type::SEARCH): ?>
	削除を完了しました。
	<?php endif; ?>
</div>

<div class="well">
	<div class="pull-left">
	<?php if ($this->page_type === Page_type::EDIT): ?>
		<a href="<?php echo site_url($this->page_path_edit); ?>" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i> 戻る</a>
	<?php else: ?>
		<a href="<?php echo site_url($this->page_path_search_again); ?>" class="btn btn-primary"><i class="icon-arrow-left icon-white"></i> 一覧に戻る</a>
	<?php endif; ?>
	</div>
</div>
