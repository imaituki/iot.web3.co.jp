<script type="text/javascript">
var quantityUnitLabel = {
<?php
$unit_price_item = null;
foreach( $this->quantity_unit_label_list as $construction_type_id => $unit_label){
    $lines[] = "$construction_type_id: '$unit_label'";
}
echo implode(",\n", $lines);
?>};

function setQuantityUnitLabel( construction_type_id )
{
    $(".unit_label").html( quantityUnitLabel[ construction_type_id ] );
}
$(function(){
    setQuantityUnitLabel( <?php echo $this->data['construction_type_id']; ?> );
});
</script>
<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<div class="alert">
	表示されている内容に問題がなければ画面下の実行ボタンを押してください。
	登録/編集を確定します。
</div>

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
<tbody>
	<tr>
        <th> 担当 </th>
        <td><?php echo h($this->staff_entity->user_name);?></td>
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
        <td><?php echo h($this->reserve_entity->reserve_date). " ".substr(h($this->reserve_entity->reserve_time_start), 0, 5)."〜".substr(h($this->reserve_entity->reserve_time_end), 0, 5);?></td>
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
        <td><?php echo h($this->customer_entity->company_name)." ". h($this->customer_entity->name); ?></td>
	</tr>
	<tr>
        <th> 現場名 </th>
        <td><?php echo h($this->construction_entity->construction_name); ?></td>
	</tr>
	<tr>
        <th> 住所 </th>
        <td><?php echo h($this->construction_entity->construction_address); ?></td>
	</tr>
	<tr>
        <th> ナンバープレート </th>
        <td>
            <?php if ($this->car_profile_entity): ?>
            <?php echo h($this->car_profile_entity->number_plate); ?>
            <?php endif; ?>
        </td>
	</tr>
	<tr>
        <th> 備考 </th>
        <td><?php echo h_br($this->reserve_entity->memo); ?></td>
	</tr>
</tbody>
</table>


<?php
$construction_type_id = $this->data['construction_type_id'];
$construction_detail_id = $this->data['construction_detail_id'];
$disposal_id = $this->data['disposal_id'];
$count_actual = $this->data['count_actual'] ? $this->data['count_actual'] : '----';
?>
<table class="table table-bordered">
<colgroup>
    <col width='30%'>
    <col width='70%'>
</colgroup>
<thead>
	<tr>
        <th colspan="2" class="table_section">作業情報 <?php echo $this->detail_number; ?></th>
	</tr>
</thead>
<tbody>
	<tr>
		<th>
			分類/工種
		</th>
		<td>
            <?php echo h($this->construction_type_id_list[ $construction_type_id ]); ?>
		</td>
	</tr>
	<tr>
		<th>
			種別/単位
		</th>
		<td>
            <?php  echo h($this->construction_detail_id_list[$construction_detail_id]); ?>
		</td>
	</tr>
	<tr>
		<th>
			数量　
		</th>
		<td>
            予定:
            <?php echo h($this->data['count_estimate']); ?>
            <span class="unit_label"></span><br />
            実績:
            <?php echo h($count_actual); ?>
            <span class="unit_label"></span>
		</td>
	</tr>
	<tr>
		<th>
			処理場
		</th>
		<td>
            <?php  echo h($this->disposal_id_list[$disposal_id]); ?>
		</td>
	</tr>
	<tr>
		<th>
			車輌扱い
		</th>
		<td>
            <?php echo h($this->car_class_id_list[ $this->data['car_class_id'] ]); ?>
		</td>
	</tr>
</tbody>
</table>


<?php if ($this->page_type !== Page_type::DETAIL): ?>
<?php //詳細画面では表示しない ?>
<div class="form-actions">
    <?php echo form_hidden('reserve_id', $this->reserve_id); ?>
    <?php echo form_hidden('detail_number', $this->detail_number); ?>
	<input type="submit" class="btn btn-primary" value="　実行　" />
	<input type="button" class="btn" value="　戻る　" 
		onclick="$('#common_form').attr('action', '<?php echo site_url($this->common_form_action_base . 'back/'); ?>');$('#common_form').submit();" />
</div>
<?php endif; ?>

<?php echo form_close(); ?>
