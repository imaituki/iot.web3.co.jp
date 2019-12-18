<script type="text/javascript">
var constInfoArray = {
<?php
$array_item[] = "\"\":[\"\", \"--\"]";
foreach( $this->construction_array as $data ){
    $line = "\"".$data->id."\": [\"".h($data->construction_name)."\",\"".h($data->construction_address)."\",\"".h($data->company_name)." ".h($data->incharge_name)."\"]";
    $array_item[] = $line;
}
echo implode(",\n", $array_item);
?>};
function setConstructionInfo(const_id)
{
    var const_info = constInfoArray[ const_id ];
    $("#customer").html(const_info[2]);
    $("#construction_address").html(const_info[1]);
    $("#construction_name").html(const_info[0]);
}
$(function(){
    setConstructionInfo(<?php echo $construction_id;?>);
});
</script>
<?php echo form_open($this->common_form_action_base . 'submit/', array('id' => 'common_form')); ?>

<div class="alert">
	表示されている内容に問題がなければ画面下の実行ボタンを押してください。
	登録/編集を確定します。
</div>

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
		<th class="span4">
	        担当
		</th>
		<td>
			<?php echo h($this->staff_id_list[$staff_id]); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
	        ステータス
		</th>
		<td>
			<?php echo h($this->reserve_status_list[$reserve_status]); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
	        表示カラー
		</th>
        <td>
            <?php
                if( $this->db_reserve_status == Reserve_status::COPY && $color == "" ){
                    echo "----";
                } else {
                    echo h($this->reserve_color_list[$color]);
                }
            ?>
		</td>
	</tr>
	<tr>
		<th>
			予約日時
		</th>
		<td>
			<?php echo h($reserve_date." ".$reserve_time_start."〜".$reserve_time_end); ?>
		</td>
	</tr>
	<tr>
		<th>
			実施時間
		</th>
		<td>
            <?php if ($time_start && $time_end): ?>
			<?php echo h($time_start . "〜" . $time_end); ?>
            <?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>
			工事コード
		</th>
		<td>
			<?php echo h($this->construction_id_list[$construction_id]); ?>
		</td>
	</tr>
	<tr>
		<th> 顧客名 </th>
        <td id="customer"></td>
	</tr>
	<tr>
		<th> 現場名 </th>
        <td id="construction_name"> </td>
	</tr>
	<tr>
		<th> 住所 </th>
        <td id="construction_address"> </td>
	</tr>
	<tr>
		<th>
			ナンバープレート
		</th>
		<td>
			<?php echo h($this->car_profile_id_list[$car_profile_id]); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
	        備考
		</th>
		<td>
			<?php echo h_br($memo); ?>
		</td>
	</tr>
</tbody>
</table>

<?php if ($this->page_type !== Page_type::DETAIL): ?>
<?php //詳細画面では表示しない ?>
<div class="form-actions">
	<input type="submit" class="btn btn-primary" value="　実行　" />
	<input type="button" class="btn" value="　戻る　" 
		onclick="$('#common_form').attr('action', '<?php echo site_url($this->common_form_action_base . 'back/'); ?>');$('#common_form').submit();" />
</div>
<?php endif; ?>

<?php echo form_close(); ?>
