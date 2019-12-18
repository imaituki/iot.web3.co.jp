<?php if (is_not_blank($this->application_session_data->get_stored_id(Relation_data_type::ITEM))): ?>

<ul class="nav nav-pills nav-stacked">
	<li class="nav-header">基本情報</li>
	<li class="<?php echo ($this->current_main_menu === 'item') ? 'active' : ''; ?>"><a href="<?php echo site_url("item/item_edit/index/"); ?>">
		<i class="icon-home <?php echo ($this->current_sub_menu == 'item') ? 'icon-white' : ''; ?>"></i> 基本情報を編集する</a></li>
	<li class="nav-header">記事</li>
	<li class="<?php echo ($this->current_sub_menu === 'item_free') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_free/item_free_search/index/"); ?>">
		<i class="icon-search <?php echo ($this->current_sub_menu == 'item_free') ? 'icon-white' : ''; ?>"></i> 記事を検索、編集する</a></li>
	<li class="<?php echo ($this->current_sub_menu === 'item_free_register') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_free/item_free_register/index/"); ?>">
		<i class="icon-plus <?php echo ($this->current_sub_menu == 'item_free_register') ? 'icon-white' : ''; ?>"></i> 記事を新規登録する</a></li>
	<li class="nav-header">検索用キーワード</li>
	<li class="<?php echo ($this->current_main_menu === 'item_keyword') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_keyword/item_keyword_search/index/"); ?>">
		<i class="icon-tags <?php echo ($this->current_sub_menu == 'item_keyword') ? 'icon-white' : ''; ?>"></i> キーワード一覧</a></li>
	<li class="nav-header">表作成</li>
	<li class="<?php echo ($this->current_main_menu === 'item_free_table') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_free_table/item_free_table_search/index/"); ?>">
		<i class="icon-th <?php echo ($this->current_sub_menu == 'item_free_table') ? 'icon-white' : ''; ?>"></i> 表組み一覧</a></li>
	<li class="nav-header">ダウンロードファイル</li>
	<li class="<?php echo ($this->current_main_menu === 'item_cutaway') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_cutaway/item_cutaway_search/index/"); ?>">
		<i class="icon-file <?php echo ($this->current_sub_menu == 'item_cutaway') ? 'icon-white' : ''; ?>"></i> 断面図一覧</a></li>
	<li class="<?php echo ($this->current_main_menu === 'item_download') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_download/item_download_search/index/"); ?>">
		<i class="icon-file <?php echo ($this->current_sub_menu == 'item_download') ? 'icon-white' : ''; ?>"></i> 他ファイル一覧</a></li>
	<li class="nav-header">施工実績</li>
	<li class="<?php echo ($this->current_sub_menu === 'item_sekou_results') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_sekou_results/item_sekou_results_search/index/"); ?>">
		<i class="icon-search <?php echo ($this->current_sub_menu == 'item_sekou_results') ? 'icon-white' : ''; ?>"></i> 施工実績を検索、編集する</a></li>
	<li class="<?php echo ($this->current_sub_menu === 'item_sekou_results_register') ? 'active' : ''; ?>"><a href="<?php echo site_url("item_sekou_results/item_sekou_results_register/index/"); ?>">
		<i class="icon-plus <?php echo ($this->current_sub_menu == 'item_sekou_results_register') ? 'icon-white' : ''; ?>"></i> 施工実績を新規登録する</a></li>
</ul>

<?php endif; ?>
