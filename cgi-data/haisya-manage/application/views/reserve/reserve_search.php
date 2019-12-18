<script type="text/javascript">
//<![CDATA[
$(function(){
    $("#cond_reserve_date_start_label").datepicker({dateFormat: 'yy-mm-dd'});
    $("#cond_reserve_date_end_label").datepicker({dateFormat: 'yy-mm-dd'});
    $("#cond_reserve_date_label").datepicker({dateFormat: 'yy-mm-dd'});
});

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

<?php echo error_msg($this->error_list, 'unit_price_duplicate'); ?>

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
			<label class="control-label" for="">担当</label>
			<div class="controls">
                <?php echo form_nds_dropdown('cond_staff_id', $this->staff_id_list, $this->data, ' '); ?>
			</div>
		</div>
	</div>
	</div>
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span5">
			<label class="control-label" for="">ステータス</label>
			<div class="controls">
        		<?php foreach ($this->reserve_status_list as $key => $value): ?>
		        <label class="checkbox inline"><?php echo form_nds_multi_checkbox('cond_reserve_status', $key, $this->data, ' class="" '); ?><?php echo h($value); ?></label>
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
	<div class="row-fluid">
	<div class="span12">
		<div class="control-group span8">
			<label class="control-label" for="">予定日</label>
			<div class="controls">
		    <?php if ($this->login_user->is_admin()): ?>
				<?php echo form_nds_input('cond_reserve_date_start', $this->data, 'id="cond_reserve_date_start_label"'); ?>
                 〜
				<?php echo form_nds_input('cond_reserve_date_end', $this->data, 'id="cond_reserve_date_end_label"'); ?>
		    <?php else: ?>
				<?php echo form_nds_input('cond_reserve_date', $this->data, 'id="cond_reserve_date_label"'); ?>
		    <?php endif; ?>
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
		<?php else: ?>
        <!-- ▲管理者 -->
		<input type="button" class="btn" value="日報ダウンロード" 
			onclick="
				oldAction=$('#common_form').attr('action');
				$('#common_form').attr('action','<?php echo site_url($this->common_form_action_base . 'pdf'); ?>');
				$('#common_form').submit();
				$('#common_form').attr('action',oldAction);" />
		<?php endif; ?>
	</div>
<?php echo form_close(); ?>

<div class="row-fluid" style="margin-bottom: 25px;">
	<div class="span3">
		<a href="<?php echo site_url($this->page_path_register); ?>" class="btn "><i class="icon-plus "></i>  　新規登録</a>
	</div>
	<div class="span5 pull-right">
		<dl class="dl-horizontal" style="margin-top:0;margin-bottom:0;">
        <dt>ポイント計:</dt>
        <dd><?php echo $this->total['point']; ?> pt</dd>
        <dt>請求金額計:</dt>
        <dd><?php echo number_format($this->total['price']); ?> 円</dd>
        </dl>
	</div>
</div>

<?php if ( ! empty($this->list)): ?>

<table class="table table-bordered">
<colgroup>
<col width="10%">
<col width="10%">
<col width="20%">
<col width="8%">
<col width="12%">
<col width="10%">
<col width="10%">
<col width="20%">
</colgroup>
<thead>
	<tr>
		<th>担当</th>
		<th>ステータス</th>
		<th>予定日
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/reserve_date/ASC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'reserve_date' && $cond_sort_order === 'ASC') ? 'color:red;' : ''; ?>">▲</a>
			<a href="<?php echo site_url()."/{$this->common_form_action_base}sort/reserve_date/DESC/?{$this->get_query}"; ?>" 
				style="<?php echo ($cond_sort_key === 'reserve_date' && $cond_sort_order === 'DESC') ? 'color:red;' : ''; ?>">▼</a>
        </th>
		<th>工事コード </th>
		<th>ナンバープレート</th>
		<th>ポイント</th>
		<th>請求金額</th>
		<th>&nbsp;</th>
	</tr>
</thead>
<tbody>
<?php foreach ($this->list as $value): ?>
	<tr>
		<td>
            <?php echo h($value['user_name']); ?>
            <?php if ($value['none']): ?>
                <img src="<?php echo config_item('material_url'); ?>img/alert.png" width="16" height="16" alt="警告" />
            <?php endif; ?>
        </td>
		<td><?php echo h($this->reserve_status_list[$value['reserve_status']]); ?></td>
		<td><?php echo h($value['reserve_date'] . " " . substr($value['reserve_time_start'], 0, 5) . "〜" . substr($value['reserve_time_end'], 0, 5)); ?></td>
		<td><?php echo h($value['construction_code']); ?></td>
		<td><?php echo h($value['number_plate']); ?></td>
		<td style="text-align:right;"><?php echo h($value['total_point']); ?></td>
		<td style="text-align:right;"><?php echo h(number_format($value['total_price'])); ?></td>
		<td>
			<a href="<?php echo site_url("{$this->page_path_detail}index/{$value['id']}"); ?>" class="btn"><i class="icon-edit"></i>  詳細</a>
            <?php if ( $value['construction_status'] == Construction_status::CLOSE): ?>
    			<a class="btn disabled"><i class="icon-edit"></i>  編集</a>
            <?php else: ?>
    			<a href="<?php echo site_url("{$this->page_path_edit}index/{$value['id']}"); ?>" class="btn btn-primary"><i class="icon-edit icon-white"></i>  編集</a>
            <?php endif; ?>
			<a class="btn btn-danger" onclick="deleteData(<?php echo $value['id']; ?>);"><i class="icon-trash icon-white"></i> 削除</a>
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
