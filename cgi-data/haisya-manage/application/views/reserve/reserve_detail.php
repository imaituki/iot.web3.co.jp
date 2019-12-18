<script type="text/javascript">
//<![CDATA[
$(function() {
    $('#reserve_copy').click(function() {
        $('#dialog_copy').dialog({
            resizable: false,
            modal: true,
            buttons: {
                "はい": function() {
                    location.href = "<?php echo site_url("/reserve/reserve_edit/copy/{$this->reserve_entity->id}"); ?>";
                },
                "いいえ": function() {
                    $(this).dialog("close");
                }
            }
        });
    });
    $('#reserve_delete').click(function() {
        $('#dialog_delete').dialog({
            resizable: false,
            modal: true,
            buttons: {
                "はい": function() {
                    location.href = "<?php echo site_url("{$this->page_path_delete}{$this->reserve_entity->id}"); ?>";
                },
                "いいえ": function() {
                    $(this).dialog("close");
                }
            }
        });
    });
});
//]]>
</script>

<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("top/top/?date=".$this->cal_date); ?>" class="btn "><i class="icon-arrow-left"></i> カレンダーへ戻る</a>
	</div>
	<div class="pull-right">
	    <?php if ( ! $this->login_user->is_admin() ): ?>
        <!-- 開始 -->
        <?php if ($this->reserve_entity->reserve_status == 0): ?>
   		<input type="button" class="btn btn-danger" value="作業開始" 
    		onclick="
	    		oldAction=$('#common_form').attr('action');
		    	$('#common_form').attr('action','<?php echo site_url($this->common_form_action_base . "start/{$this->reserve_entity->id}"); ?>');
			    $('#common_form').submit();
   				$('#common_form').attr('action',oldAction);" />
        <?php endif; ?>
        <?php if ($this->reserve_entity->reserve_status == 1): ?>
        <!-- 終了 -->
    	<input type="button" class="btn btn-danger" value="作業終了" 
	    	onclick="
		    	oldAction=$('#common_form').attr('action');
			    $('#common_form').attr('action','<?php echo site_url($this->common_form_action_base . "end/{$this->reserve_entity->id}"); ?>');
   				$('#common_form').submit();
    			$('#common_form').attr('action',oldAction);" />
        <?php endif; ?>
    	<?php endif; ?>
	</div>
</div>

<?php echo h_error($this->error_msg); ?>

<table class="table table-bordered">
<colgroup>
    <col width='30%'>
    <col width='70%'>
</colgroup>
<thead>
	<tr>
		<th colspan="2" class="table_section">予約情報</th>
	</tr>
</thead>
<tfoot style="text-align: right">
    <tr>
        <td colspan="2" style="text-align: right">
			<?php if ($this->login_user->is_admin() && $this->reserve_entity->reserve_status != Reserve_status::COPY): ?>
			<a class="btn " id="reserve_copy"><i class="icon-plus"></i>  複製</a>
			<!--<a href="<?php echo site_url("/reserve/reserve_edit/copy/{$this->reserve_entity->id}"); ?>" class="btn " onclick="return confirm('複製しますか？');"><i class="icon-plus"></i>  複製</a>-->
	        <?php endif; ?>
            <?php if ( $this->construction_entity->construction_status == Construction_status::CLOSE): ?>
			    <a class="btn disabled"><i class="icon-edit"></i>  予約情報編集</a>
            <?php else: ?>
			    <a href="<?php echo site_url("{$this->page_path_edit}index/{$this->reserve_entity->id}"); ?>" class="btn btn-primary"><i class="icon-edit icon-white"></i>  予約情報編集</a>
            <?php endif; ?>
			<a class="btn btn-danger" id="reserve_delete"><i class="icon-edit icon-white"></i>  予約情報削除</a>
        </td>
    <tr>
</tfoot>
<tbody>
	<tr>
        <th> 担当 </th>
        <td><?php echo h($this->staff_entity->user_name); ?></td>
	</tr>
	<tr>
        <th> ステータス </th>
        <td><?php echo h($this->reserve_status_list[$this->reserve_entity->reserve_status]); ?></td>
	</tr>
	<tr>
        <th> 表示カラー </th>
        <td><?php echo h($this->reserve_color_list[$this->reserve_entity->color]); ?></td>
	</tr>
	<tr>
        <th> 予約日時 </th>
        <td><?php echo h($this->reserve_entity->reserve_date) . " " . substr(h($this->reserve_entity->reserve_time_start), 0, 5)."〜".substr(h($this->reserve_entity->reserve_time_end), 0, 5);?>
        </td>
	</tr>
	<tr>
        <th> 実施時間 </th>
        <td>
            <?php if ($this->reserve_entity->time_start && $this->reserve_entity->time_end): ?>
            <?php echo substr(h($this->reserve_entity->time_start), 0, 5) . "〜" . substr(h($this->reserve_entity->time_end), 0, 5);?>
            <?php endif; ?>
        </td>
	</tr>
	<tr>
        <th> 工事コード </th>
        <td><?php echo h($this->construction_entity->construction_code); ?></td>
	</tr>
	<tr>
        <th> 顧客名 </th>
        <td><?php echo h($this->customer_entity->company_name) . " " . h($this->customer_entity->name); ?></td>
	</tr>
	<tr>
        <th> 現場名 </th>
        <td><?php echo h($this->construction_entity->construction_name); ?></td>
	</tr>
	<tr>
        <th> 住所 </th>
        <td><?php echo h($this->construction_entity->construction_address); ?>
            <?php if (!empty($this->construction_entity->latitude) && !empty($this->construction_entity->longitude)): ?>
                 【 <a href="http://maps.google.com/maps?q=<?php echo h($this->construction_entity->latitude); ?>,<?php echo h($this->construction_entity->longitude); ?>" target="_blank">地図</a> 】</td>
            <?php endif; ?>
	</tr>
	<tr>
        <th> ナンバープレート </th>
        <td><?php 
            if( $this->car_profile_entity == "" ){
                echo "";
            } else {
                echo h($this->car_profile_entity->number_plate);
            }
            ?>
        </td>
	</tr>
	<tr>
        <th> 備考 </th><td><?php echo h_br($this->reserve_entity->memo); ?></td>
	</tr>
</tbody>
</table>

<?php foreach($this->reserve_detail_entities as $detail): ?>
<table class="table table-bordered">
<colgroup>
    <col width='30%'>
    <col width='70%'>
</colgroup>
<thead>
	<tr>
        <th colspan="2" class="table_section">作業情報 <?php echo $detail->detail_number; ?>
        <?php if ($detail->unit_price_id == 0): ?> <img src="<?php echo config_item('material_url'); ?>img/alert.png" width="16" height="16" alt="警告" /><?php endif; ?></th>
	</tr>
</thead>
<tfoot>
    <td colspan="2" style="text-align: right;" align="right">
    <a href="<?php echo site_url("/reserve_detail/reserve_detail_edit/index/{$detail->id}"); ?>" class="btn btn-primary"><i class="icon-edit icon-white"></i>  作業<?php echo $detail->detail_number; ?> 編集</a>
    <a class="btn btn-danger" href="<?php echo site_url("/reserve_detail/reserve_detail_search/delete/{$detail->id}"); ?>"  onclick="if ( ! confirm('削除します。よろしいですか？')){return false;}"><i class="icon-trash icon-white"></i> 作業<?php echo $detail->detail_number; ?> 削除</a>
    </td>
</tfoot>
<tbody>
	<tr>
		<th>
			分類/工種
		</th>
		<td>
            <?php echo h($detail->construction_category_name); ?>
            <?php if (isset($detail->construction_type_name)): ?>&nbsp;:&nbsp;<?php endif; ?>
            <?php echo h($detail->construction_type_name); ?>
		</td>
	</tr>
	<tr>
		<th>
			種別/単位
		</th>
		<td>
            <?php echo h($detail->construction_detail_name); ?>
            <?php if (isset($detail->weight)): ?>&nbsp;/&nbsp;<?php endif; ?>
            <?php echo h($detail->weight); ?>
            <?php if (isset($detail->unit)): ?>&nbsp;/&nbsp;<?php endif; ?>
            <?php echo h($detail->unit); ?>
            <span id="unit_label"></span>
		</td>
	</tr>
	<tr>
		<th>
			数量　
		</th>
		<td>
            予定:
            <?php echo h($detail->count_estimate); ?>
            <?php echo h($detail->unit); ?><br />
            実績:
            <?php echo h($detail->count_actual); ?>
            <?php echo h($detail->unit); ?>
		</td>
	</tr>
	<tr>
		<th>
			処理場
		</th>
		<td>
            <?php echo h($detail->disposal_name); ?>
            <span id="unit_label"></span>
		</td>
	</tr>
	<tr>
		<th>
			車輌扱い
		</th>
		<td>
            <?php echo h($detail->car_class_name); ?>
		</td>
	</tr>
</tbody>
</table>
<?php endforeach; ?>


<div class="form-actions">
    <?php if ( $this->construction_entity->construction_status == Construction_status::CLOSE): ?>
    	<a class="btn disabled"><i class="icon-plus"></i>  作業追加</a>
    <?php else: ?>
    	<a href="<?php echo site_url("reserve_detail/reserve_detail_register/index/{$this->reserve_entity->id}"); ?>" class="btn btn-primary"><i class="icon-plus icon-white"></i>  作業追加</a>
    <?php endif; ?>
</div>


<div id="dialog_copy" title="複製" style="display:none;">
    <p>複製しますか？</p>
</div>
<div id="dialog_delete" title="削除" style="display:none;">
    <p>作業情報も全て削除します。よろしいですか？</p>
</div>
