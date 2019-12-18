<script type="text/javascript">

<?php if ($this->page_type == Page_type::EDIT && $this->onload_js){ echo $this->onload_js; }?>

var constInfoArray = {
<?php
//$array_item[] = "\"\":[\"\", \"--\"]";
$array_item[] = "\"\":[\"\", \"\"]";
foreach( $this->construction_array as $data ){
    $line = "\"".$data->id."\": [\"".h($data->construction_name)."\",\"".h($data->construction_address)."\",\"".h($data->company_name)." ".h($data->incharge_name)."\"]";
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
    $("#customer").html(const_info[2]);
    $("#construction_address").html(const_info[1]);
    $("#construction_name").html(const_info[0]);
}

$(function(){
    setConstructionInfo($("#construction_id").val());

    $("#construction_id").change(function(){
        setConstructionInfo($(this).val());
    });

    $("#reserve_date").datepicker({dateFormat: 'yy-mm-dd'});

});
</script>
<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("reserve/reserve_detail/index/".$this->reserve_id); ?>" class="btn "><i class="icon-arrow-left"></i> 配車詳細へ戻る</a>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
</div>

<?php echo h_error($this->error_msg); ?>

<table class="table table-bordered">
<colgroup>
<col width="30%">
<col width="70%">
</colgroup>
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th>担当　<span class="label label-warning">必須</span></th>
		<td>
            <?php echo form_nds_dropdown('staff_id', $this->staff_id_list, $this->data, ' '); ?>
			<?php echo form_error('staff_id'); ?>
            <?php echo error_msg($this->error_list, 'staff_id'); ?>
            <span class="help-block">担当を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>ステータス　<span class="label label-warning">必須</span></th>
		<td>
            <?php $reserve_status = $this->data["reserve_status"]; ?>
    		<?php foreach ($this->reserve_status_list as $key => $value): ?>
            <label class="radio inline"><input type="radio" name="reserve_status" value="<?php echo $key; ?>" <?php if( (int)$reserve_status === $key ){ echo "checked='checked'"; } ?>><?php echo h($value); ?></label>
			<?php endforeach; ?>
			<?php echo form_error('reserve_status'); ?>
		</td>
	</tr>
	<tr>
		<th>表示カラー　<span class="label label-warning">必須</span></th>
		<td>
    		<?php foreach ($this->reserve_color_list as $key => $value): ?>
			<label class="radio inline"><?php echo form_nds_radio('color', $key, $this->data); ?> <?php echo h($value) ?></label>　
			<?php endforeach; ?>
			<?php echo form_error('color'); ?>
            <?php echo error_msg($this->error_list, 'color'); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">予約日時　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('reserve_date', $this->data, 'size="25" maxlength="25" id="reserve_date"'); ?><br />
            <?php echo form_nds_dropdown('reserve_time_start', $this->reserve_time_list, $this->data, 'style="width:100px"'); ?> 〜
            <?php echo form_nds_dropdown('reserve_time_end', $this->reserve_time_list, $this->data, 'style="width:100px"'); ?>
			<?php echo form_error('reserve_date'); ?>
			<?php echo form_error('reserve_time_start'); ?>
			<?php echo form_error('reserve_time_end'); ?>
            <?php echo error_msg($this->error_list, 'reserve_time_end'); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">実施時間</th>
		<td>
			<?php echo form_nds_input('time_start', $this->data, 'class="span2" maxlength="10" id="time_start"'); ?> 〜
			<?php echo form_nds_input('time_end', $this->data, 'class="span2" maxlength="10" id="time_start"'); ?>
			<?php echo form_error('time_start'); ?>
			<?php echo form_error('time_end'); ?>
            <?php echo error_msg($this->error_list, 'time_start'); ?>
            <?php echo error_msg($this->error_list, 'time_end'); ?>
		</td>
	</tr>
	<tr>
		<th>工事コード　<span class="label label-warning">必須</span></th>
		<td>
            <?php echo form_nds_dropdown('construction_id', $this->construction_id_list, $this->data, 'id="construction_id"'); ?>
			<?php echo form_error('construction_id'); ?>
		</td>
	</tr>
	<tr>
		<th>顧客名　</th>
        <td id="customer"></td>
	</tr>
	<tr>
		<th>現場名　</th>
        <td id="construction_name"></td>
	</tr>
	<tr>
		<th>住所　</th>
        <td id="construction_address"></td>
	</tr>
	<tr>
		<th>ナンバープレート</th>
		<td>
            <?php echo form_nds_dropdown('car_profile_id', $this->car_profile_id_list, $this->data, ' '); ?>
			<?php echo form_error('car_profile_id'); ?>
            <span class="help-block">ナンバープレートを選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>備考</th>
		<td>
			<?php echo form_nds_textarea('memo', $this->data, 'cols="25" rows="5"'); ?>
			<?php echo form_error('memo'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>


<div id="dialog_complete" title="完了" style="display:none;">
    <p>データの複製が完了しました。担当者の割り当て等必要な修正をして下さい。</p>
</div>
