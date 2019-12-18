<script type="text/javascript">
var constInfoArray = {
<?php
$array_item[] = "\"\":[\"\", \"--\"]";
foreach( $this->construction_array as $data ){
    $line = "\"".$data->id."\": [\"".$data->construction_name." / ".$data->construction_address."\",\"".$data->company_name." ".$data->incharge_name."\"]";
    $array_item[] = $line;
}
echo implode(",\n", $array_item);
?>};

var unitPriceArray = {
<?php
$unit_price_item = null;
foreach( $this->unit_price_id_list as $construction_type_id => $data ){
    $line  = $construction_type_id.": [";
    $up_lines = null;
    foreach($data as $unit_price_id => $unit_price_label){
        $up_lines[] = "[".$unit_price_id .",'".$unit_price_label."']";
    }
    $line.= implode(",", $up_lines);
    $line.= "]";
    $unit_price_item[] = $line;
}
echo implode(",\n", $unit_price_item);
?>};

function setConstructionInfo(const_id)
{
    var const_info = constInfoArray[ const_id ];
    $("#customer").html(const_info[1]);
    $("#construction_name").html(const_info[0]);
}

function setUnitPrice(construction_type_id, selected_val)
{
    var unit_price_array = unitPriceArray[ construction_type_id ];
    $('#unit_price_id').children().remove();
    for (var i = 0; i < unit_price_array.length; i++ ) {
        var option_tag = null;

        option_tag = "<option value='" + unit_price_array[i][0] + "'> " + unit_price_array[i][1] + "</option>";

        $("#unit_price_id").append(option_tag);

        // 選択値がある場合は selected にする
        if( !!selected_val) {
            $("#unit_price_id").val(selected_val);
        }
    }
}
$(function(){
    setConstructionInfo($("#construction_id").val());
    setUnitPrice($("#construction_type_id").val(), $("#unit_price_id").val());

    $("#construction_id").change(function(){
        setConstructionInfo($(this).val());
    });

    $("#reserve_date").datepicker({dateFormat: 'yy-mm-dd'});

    $("#construction_type_id").change(function(){
        setUnitPrice($(this).val());
    });
});
</script>
<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("reserve/reserve_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
</div>

<?php echo h_error($this->error_msg); ?>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th>
			担当　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('staff_id', $this->staff_id_list, $this->data, ' '); ?>
			<?php echo form_error('staff_id'); ?>
            <span class="help-block">担当を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			ステータス　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('reserve_status', $this->reserve_status_list, $this->data, ' '); ?>
			<?php echo form_error('reserve_status'); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
			予約日時　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('reserve_date', $this->data, 'size="25" maxlength="25" id="reserve_date"'); ?>
            <?php echo form_nds_dropdown('reserve_time_start', $this->reserve_time_list, $this->data, 'style="width:100px"'); ?> 〜
            <?php echo form_nds_dropdown('reserve_time_end', $this->reserve_time_list, $this->data, 'style="width:100px"'); ?>
			<?php echo form_error('reserve_date'); ?>
			<?php echo form_error('reserve_time_start'); ?>
			<?php echo form_error('reserve_time_end'); ?>
            <?php echo error_msg($this->error_list, 'reserve_time_end'); ?>
		</td>
	</tr>
	<tr>
		<th>
			工事ID　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('construction_id', $this->construction_id_list, $this->data, 'id="construction_id"'); ?>
			<?php echo form_error('construction_id'); ?>
		</td>
	</tr>
	<tr>
		<th> 顧客名 </th> <td id="customer"></td>
	</tr>
	<tr>
		<th> 現場/場所 </th> <td id="construction_name"> </td>
	</tr>
	<tr>
		<th>
			車輌情報　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('car_profile_id', $this->car_profile_id_list, $this->data, ' '); ?>
			<?php echo form_error('car_profile_id'); ?>
            <span class="help-block">ナンバープレートを選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			備考
		</th>
		<td>
			<?php echo form_nds_input('memo', $this->data, 'style="width: 500px;"'); ?>
			<?php echo form_error('memo'); ?>
		</td>
	</tr>
</tbody>
</table>

<?php if( isset($this->data['id']) && $this->data['id'] ): ?>
<?php if( isset($this->data['reserve_detail_array']) && count($this->data['reserve_detail_array']) ): ?>
<?php foreach($this->data['reserve_detail_array'] as $i => $reserve_detail): ?>
<table class="table table-bordered">
<thead>
	<tr>
        <th colspan="2" class="table_section">作業情報<?php echo ($i + 1); ?></th>
	</tr>
</thead>
<tbody>
	<tr>
		<th>
			作業　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('staff_id', $this->staff_id_list, $this->data, ' '); ?>
			<?php echo form_error('staff_id'); ?>
            <span class="help-block">担当を選択してください。</span>
		</td>
	</tr>
</tbody>
</table>
<?php endforeach; // reserve_detail_array?>
<?php endif; // reserve_detail_array?>

<table class="table table-bordered">
<thead>
	<tr>
        <th colspan="2" class="table_section">作業情報 <?php if( isset($i) ){echo ($i + 1); } else { $i = 0; } ?></th>
	</tr>
</thead>
<tbody>
	<tr>
		<th>
			分類/工種　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown("construction_type_id[$i]", $this->construction_type_id_list, $this->data, 'id="construction_type_id"'); ?>
			<?php echo form_error('staff_id'); ?>
            <span class="help-block">工種を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			種別/単位/処理場
		</th>
		<td>
            <?php echo form_nds_dropdown("construction_detail_id[$i]", $this->unit_price_id_list, $this->data, 'id="unit_price_id"'); ?>
			<?php echo form_error('staff_id'); ?>
            <span class="help-block">種別/単位を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			数量　
		</th>
		<td>
            予定:
            <?php echo form_nds_input('count_estimate', $this->staff_id_list, $this->data, ' '); ?>
			<?php echo form_error('count_estimate'); ?>
            /実績:
            <?php echo form_nds_input('count_actual', $this->staff_id_list, $this->data, ' '); ?>
			<?php echo form_error('count_actual'); ?>
		</td>
	</tr>
	<tr>
		<th>
			車輌扱い
		</th>
		<td>
            <?php echo form_nds_dropdown('car_class_id', $this->car_class_id_list, $this->data, ' '); ?>
			<?php echo form_error('car_class_id'); ?>
            <span class="help-block">処理場を選択してください。</span>
		</td>
	</tr>
</tbody>
</table>

<?php endif; // id ?>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
