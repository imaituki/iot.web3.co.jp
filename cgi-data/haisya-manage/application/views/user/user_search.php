<script type="text/javascript">
//<![CDATA[
function deleteData(id)
{
    $('#dialog_delete').dialog({
        resizable: false,
        modal: true,
        buttons: {
            "はい": function() {
                location.href = "<?php echo site_url("{$this->page_path_delete}"); ?>/" + id;
            },
            "いいえ": function() {
                $(this).dialog("close");
            }
        }
    });
}
//]]>
</script>


<?php echo form_open($this->common_form_action_base . 'search/', array('method' => 'GET', 'id' => 'common_form', 'class' => 'well form-horizontal')); ?>
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">ユーザーコード</label>
			<div class="controls">
				<?php echo form_nds_input('cond_user_code', $this->data, 'id="cond_user_code_label"'); ?>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="">アカウント種別</label>
			<div class="controls">
				<?php echo form_nds_dropdown('cond_account_type', Account_type::get_dropdown_list(), $this->data, 'id="cond_account_type_label"'); ?>
			</div>
		</div>
	</div>
	</div>

	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">ユーザー名</label>
			<div class="controls">
				<?php echo form_nds_input('cond_user_name', $this->data, 'id="cond_user_name_label"'); ?>
			</div>
		</div>
	</div>
	</div>

	<div class="form-actions" style="margin:0px auto;">
		<input type="submit" name="search" value="検索" class="btn btn-primary" />
        <!-- ▼管理者 -->
		<?php if ($this->login_user->is_admin()): ?>
		<input type="button" class="btn" value="CSVダウンロード" 
			onclick="
				oldAction=$('#common_form').attr('action');
				$('#common_form').attr('action','<?php echo site_url($this->common_form_action_base . 'csv'); ?>');
				$('#common_form').submit();
				$('#common_form').attr('action',oldAction);" />
		<?php endif; ?>
        <!-- ▲管理者 -->
	</div>
<?php echo form_close(); ?>

<div class="row-fluid" style="margin-bottom: 25px;">
	<div class="span3">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn "><i class="icon-plus "></i>  　新規登録</a>
	</div>
</div>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<colgroup>
<col width="14%">
<col width="12%">
<col width="18%">
<col width="14%">
<col width="14%">
<col width="14%">
<col width="14%">
</colgroup>
<thead>
	<tr>
		<th class="span3">ユーザーコード
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/user_code/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'user_code' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/user_code/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'user_code' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>ユーザー名
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/user_name/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'user_name' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/user_name/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'user_name' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>ユーザー名（フリガナ）
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/user_furigana/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'user_furigana' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/user_furigana/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'user_furigana' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>アカウント種別
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/account_type/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'account_type' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/account_type/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'account_type' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>登録日</th>
		<th>更新日</th>
		<th>&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td><?php echo h($value['user_code']); ?>&nbsp;</td>
		<td><?php echo h($value['user_name']); ?>&nbsp;</td>
		<td><?php echo h($value['user_furigana']); ?>&nbsp;</td>
		<td><?php echo h(Account_type::get_label($value['account_type'])); ?>&nbsp;</td>
		<td><?php echo h(preg_replace('/-/', '/', $value['insert_datetime'])); ?></td>
		<td><?php echo h(preg_replace('/-/', '/', $value['update_datetime'])); ?></td>
		<td>
			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-edit icon-white"></i>  編集</a>
			<?php if ($value['user_code'] !== System_const::NDS_ROOT_USER): ?>
			<a class="btn btn-danger" onclick="deleteData(<?php echo $value['id']; ?>);"><i class="icon-trash icon-white"></i> 削除</a>
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


<div id="dialog_delete" title="削除" style="display:none;">
    <p>削除します。よろしいですか？</p>
</div>
