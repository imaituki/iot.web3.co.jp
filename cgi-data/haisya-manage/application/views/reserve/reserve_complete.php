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
		<a href="<?php echo site_url("top/top/?date={$this->cal_date}"); ?>" class="btn "><i class="icon-arrow-left"></i> カレンダーへ戻る</a>
        &nbsp;&nbsp;&nbsp;
		<a href="<?php echo site_url("{$this->page_path_detail}index/{$this->reserve_id}"); ?>" class="btn "><i class="icon-arrow-left"></i> 配車詳細へ</a>
	</div>
</div>
