<script type="text/javascript">
// 単価情報
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

var quantityUnitLabel = {
<?php
foreach( $this->construction_detail_unit_list as $construction_detail_id => $unit_label){
    $lines[] = "$construction_detail_id: '$unit_label'";
}
echo implode(",\n", $lines);
?>};

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
function setQuantityUnitLabel( construction_type_id )
{
    $(".unit_label").html( quantityUnitLabel[ construction_type_id ] );
}
function checkUnitPrice()
{
    var type_id      = $("#construction_type_id").val();
    var detail_id    = $("#construction_detail_id").val();
    var disposal_id  = $("#disposal_id").val();
    var car_class_id = $("#car_class_id").val();
    var url          = "<?php echo site_url("/unit_price/unit_price_search/get_unit_price_data/"); ?>";
    var param        = {
        construction_type_id   : type_id,
        construction_detail_id : detail_id,
        disposal_id            : disposal_id,
        car_class_id           : car_class_id
    };

    $.getJSON(url, param, function(data, status){
        if( data == null ){
            $("#unit_price_exists").hide();
            $("#unit_price_not_exists").show();
        } else {
            $("#unit_price_not_exists").hide();
            $("#unit_price_exists").show();
//            $("#unit_price_price").html( data.unit_price );
            $("#unit_price_point").html( data.point );
        }
    });
}
$(function(){
    setUnitPrice( $("#construction_type_id").val(), $("#unit_price_id").val() );
    setQuantityUnitLabel( $("#construction_detail_id").val() );
    checkUnitPrice();

    $("#construction_type_id").change(function(){
        var construction_type_id = $(this).val();
        setUnitPrice( construction_type_id );
    });
    $("#construction_detail_id").change(function(){
        var construction_detail_id = $(this).val();
        setQuantityUnitLabel( construction_detail_id );
    });
    $("#construction_type_id,#construction_detail_id,#disposal_id,#car_class_id").change(function(){
        checkUnitPrice();
    });
});
</script>
<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("reserve/reserve_detail/index/{$this->reserve_entity->id}"); ?>" class="btn "><i class="icon-arrow-left"></i> 配車詳細へ戻る</a>
	</div>
</div>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
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
        <td><?php echo h($this->reserve_entity->reserve_date) . " ".substr(h($this->reserve_entity->reserve_time_start), 0, 5)."〜".substr(h($this->reserve_entity->reserve_time_end), 0, 5); ?></td>
	</tr>
	<tr>
        <th> 実施時間 </th>
        <td>
            <?php if ($this->reserve_entity->time_start && $this->reserve_entity->time_end): ?>
            <?php echo substr(h($this->reserve_entity->time_start), 0, 5) . "〜" . substr(h($this->reserve_entity->time_end), 0, 5); ?>
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
            <?php echo form_nds_dropdown("construction_type_id", $this->construction_type_id_list, $this->data, 'id="construction_type_id"'); ?>
			<?php echo form_error('construction_type_id'); ?>
            <span class="help-block">工種を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			種別/単位
		</th>
		<td>
            <?php echo form_nds_dropdown("construction_detail_id", $this->construction_detail_id_list, $this->data, 'id="construction_detail_id"'); ?>
			<?php echo form_error('construction_detail_id'); ?>
            <span class="help-block">種別/単位を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			数量　
		</th>
		<td>
            予定:
            <?php echo form_nds_input('count_estimate', $this->data, 'style="width:100px;"'); ?>
            <span class="unit_label"></span><br />
			<?php echo form_error('count_estimate'); ?>
            実績:
            <?php echo form_nds_input('count_actual', $this->data, 'style="width:100px;"'); ?>
            <span class="unit_label"></span>
			<?php echo form_error('count_actual'); ?>
		</td>
	</tr>
	<tr>
		<th>
			処理場
		</th>
		<td>
            <?php echo form_nds_dropdown("disposal_id", $this->disposal_id_list, $this->data, 'id="disposal_id"'); ?>
			<?php echo form_error('disposal_id_list'); ?>
            <span class="help-block">処理場を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			車輌扱い
		</th>
		<td>
            <?php echo form_nds_dropdown('car_class_id', $this->car_class_id_list, $this->data, 'id="car_class_id"'); ?>
			<?php echo form_error('car_class_id'); ?>
            <span class="help-block">処理場を選択してください。</span>
		</td>
	</tr>
    <tr>
        <th>ポイント単価</th>
        <td>
            <div id="unit_price_not_exists" style="display: none;color: #f00;">指定された「工種、種別、処理場、車輌扱い」の組みの単価設定がありません</div>
            <div id="unit_price_exists" style="display:none;"><span id="unit_price_point"></span> pt</div>
        </td>
    </tr>
</tbody>
</table>


<div class="form-actions">
    <?php echo form_hidden('reserve_id', $this->reserve_id); ?>
    <?php echo form_hidden('detail_number', $this->detail_number); ?>
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>
