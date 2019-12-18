<script type="text/javascript">
//<![CDATA[
/*
function changeStatus(id) {
        $.ajax({
            url: '<?php echo site_url('construction/construction_search/update_status'); ?>',
            data: {
                'id': id,
                'construction_status': $('#construction_status_' + id).val()
            },
            type: 'post',
            success: function(data, textStatus, jqXHR) {
                alert('ステータスを更新しました。');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('ステータスの更新に失敗しました。');
            }
        });
}
*/
function allCheck(input, selector) {
    if ($(input).attr('checked')) {
        $(selector).attr('checked', true);
    } else {
        $(selector).attr('checked', false);
    }
}
$(function() {
    $('#changeStatus').change(function() {
        $('#dialog').dialog({
            resizable: false,
            modal: true,
            buttons: {
                "はい": function() {
                    statusSubmit();
                },
                "いいえ": function() {
                    $(this).dialog("close");
                }
            }
        });
    });
});
function statusSubmit()
{
    var fm = document.form1;
    if (!fm["construction_status_id[]"]) {
        return false;
    }
    var checkflag = false;
    var max = fm["construction_status_id[]"].length;
    if (max) {
        for (var i=0; i<max; i++) {
            if(fm["construction_status_id[]"][i].checked == true){
                checkflag = true;
            }
        }
    } else {
        if(fm["construction_status_id[]"].checked == true) {
            checkflag = true;
        }
    }
    if(!checkflag){
        $('#nonCheck').dialog({
            buttons: {
                "閉じる": function() {
                    $(this).dialog("close");
                    $('#dialog').dialog("close");
                }
            }
        });
        return false;
    }
    fm.submit();
}
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
			<label class="control-label" for="">工事コード</label>
			<div class="controls">
				<?php echo form_nds_input('cond_construction_code', $this->data, 'id="cond_construction_code_label"'); ?>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="">現場名</label>
			<div class="controls">
				<?php echo form_nds_input('cond_construction_name', $this->data, 'id="cond_construction_name_label"'); ?>
			</div>
		</div>
	</div>
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">ステータス</label>
			<div class="controls">
	            <?php foreach ($this->construction_status_list as $key => $value): ?>
	            <label class="checkbox inline"><?php echo form_nds_multi_checkbox('cond_construction_status', $key, $this->data, ''); ?><?php echo h($value); ?></label>
	            <?php endforeach; ?>
			</div>
		</div>
		<div class="control-group span5">
			<label class="control-label" for="">顧客名</label>
			<div class="controls">
                <?php echo form_nds_dropdown('cond_customer_id', $this->customer_id_list, $this->data, 'id="cond_customer_id_label"'); ?>
			</div>
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

<?php echo form_open($this->common_form_action_base . 'change_status/', array('method' => 'POST', 'name' => 'form1', 'id' => 'form1')); ?>
<div class="row-fluid" style="margin-bottom: 25px;">
	<div class="span2">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn "><i class="icon-plus "></i>  　新規登録</a>
	</div>
<div class="form-horizontal">
	<div class="control-group">
		<label class="control-label">ステータス一括変更&nbsp;&nbsp;</label>
        <div class="controls">
            <?php echo form_nds_dropdown('change_status', $this->construction_status_dropdown_list, '', 'id="changeStatus"'); ?>
        </div>
	</div>
</div>
</div>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<colgroup>
<col width="10%">
<col width="10%">
<col width="13%">
<col width="13%">
<col width="13%">
<col width="13%">
<col width="13%">
<col width="15%">
</colgroup>
<thead>
	<tr>
		<th>
            <label class="checkbox" style="margin-bottom:0;font-weight:bold;">
            <input type="checkbox" name="status_check" onclick="allCheck(this, 'input[name=\'construction_status_id[]\']')" />ステータス
            </label>
        </th>
		<th>工事コード
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/construction_code/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'construction_code' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/construction_code/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'construction_code' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>顧客名 </th>
		<th>現場名
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/construction_name/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'construction_name' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/construction_name/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'construction_name' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>住所
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/construction_address/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'construction_address' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/construction_address/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'construction_address' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>登録日
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/insert_datetime/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'insert_datetime' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/insert_datetime/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'insert_datetime' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>更新日</th>
		<th>&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td>
            <label class="checkbox">
            <input type="checkbox" name="construction_status_id[]" value="<?php echo $value['id']; ?>" /><?php echo h($this->construction_status_list[$value['construction_status']]); ?>
            </label>
        </td>
		<td><?php echo h($value['construction_code']); ?>&nbsp;</td>
		<td><?php echo h($this->customer_id_list[$value['customer_id']]); ?>&nbsp;</td>
		<td><?php echo h($value['construction_name']); ?>&nbsp;</td>
		<td><?php echo h($value['construction_address']); ?>&nbsp;</td>
		<td><?php echo h(preg_replace('/-/', '/', $value['insert_datetime'])); ?></td>
		<td><?php echo h(preg_replace('/-/', '/', $value['update_datetime'])); ?></td>
		<td>
			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-edit icon-white"></i>  編集</a>
			<a class="btn btn-danger" onclick="deleteData(<?php echo $value['id']; ?>);"><i class="icon-trash icon-white"></i> 削除</a>
		</td>
	</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php echo form_close(); ?>

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


<div id="dialog" title="ステータス一括変更" style="display:none;">
    <p>ステータスを変更しますか？</p>
</div>
<div id="nonCheck" title="ステータス一括変更" style="display:none;">
    <p>チェックボックスが選択されていません！</p>
</div>
<div id="dialog_delete" title="削除" style="display:none;">
    <p>削除します。よろしいですか？</p>
</div>
