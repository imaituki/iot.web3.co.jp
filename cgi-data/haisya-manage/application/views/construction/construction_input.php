<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link href="<?php echo base_url(); ?>js/jquery.fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">//<![CDATA[
var map;
var marker;

$(function() {
    var geocoder = new google.maps.Geocoder();

    $("#codeAddress").click(function() {
        var result = true;
        var address = $("#construction_address").val();
        if (geocoder && address) {
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    latlng = results[0].geometry.location;
                    $("#latitude").val(latlng.lat());
                    $("#longitude").val(latlng.lng());
                } else {
                    alert('住所の場所が見つかりません');
                }
            });
        } else {
            alert('住所の場所が見つかりません');
        }
    });

    $("#mapAddress").fancybox({onStart: function() {
        var lat = $("#latitude").val();
        var lng = $("#longitude").val();

        var latlng;
        if (lat && lng) {
            latlng = new google.maps.LatLng(lat, lng);
        } else {
            var address = $("#construction_address").val();
            if (geocoder) {
                geocoder.geocode({'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        latlng = results[0].geometry.location;
                    }
                });
            }
        }

        if (!latlng) {
            // 座標が取得できない場合は岡山県岡山市北区（緯度:34.65534, 経度:133.9198129）から取得
            latlng = new google.maps.LatLng(34.65534, 133.9198129);
        }

        var mapOptions = {
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            zoom: 15
        };

        if (!map)
        {
            map = new google.maps.Map($("#maps").get(0), mapOptions);
        }
        else
        {
            map.panTo(latlng);
        }

        if (!marker)
        {
            marker = new google.maps.Marker({map: map, position: latlng});
            marker.setDraggable(true);
        }
        else
        {
            marker.setPosition(latlng);
        }

        // ポイントで設定
        $("#inputPoint").click(function() {
            latlng = marker.getPosition();
            $("#latitude").val(latlng.lat());
            $("#longitude").val(latlng.lng());
            $.fancybox.close();
        });
    }});
});
//]]></script>

<?php echo form_open($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>
<?php if ($this->page_type == Page_type::EDIT): ?>
<?php //詳細画面でのみ表示 ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url("construction/construction_search/search_again/"); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
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
		<th class="span4">
			ステータス　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('construction_status', $this->construction_status_list, $this->data, ' '); ?>
			<?php echo form_error('construction_status'); ?>
            <span class="help-block">ステータスを選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			工事コード　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_code', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('construction_code'); ?>
            <?php echo error_msg($this->error_list, 'construction_code_duplicate'); ?>
		</td>
	</tr>
	<tr>
		<th class="span4">
			顧客名　<span class="label label-warning">必須</span>
		</th>
		<td>
            <?php echo form_nds_dropdown('customer_id', $this->customer_id_list, $this->data, ' '); ?>
			<?php echo form_error('customer_id'); ?>
            <span class="help-block">顧客を選択してください。</span>
		</td>
	</tr>
	<tr>
		<th>
			現場名　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_name', $this->data, 'size="25" maxlength="25"'); ?><br />
			<?php echo form_error('construction_name'); ?>
		</td>
	</tr>
	<tr>
		<th>
			住所　<span class="label label-warning">必須</span>
		</th>
		<td>
			<?php echo form_nds_input('construction_address', $this->data, 'id="construction_address" class="span9"'); ?><br />
			<?php echo form_error('construction_address'); ?>
		</td>
	</tr>
	<tr>
		<th>
			緯度／経度
		</th>
		<td>
			緯度：<?php echo form_nds_input('latitude', $this->data, 'id="latitude" size="25" maxlength="25"'); ?>&nbsp;&nbsp;
			経度：<?php echo form_nds_input('longitude', $this->data, 'id="longitude" size="25" maxlength="25"'); ?>
            <a href="javascript:;" name="codeAddress" id="codeAddress" class="btn" onclick="">住所より自動取得</a>
            <a href="#maparea" id="mapAddress" class="btn">地図で設定</a>
            <br />
			<?php echo form_error('latitude'); ?>
			<?php echo form_error('longitude'); ?>
		</td>
	</tr>
</tbody>
</table>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<div style="display: none">
    <div id="maparea">
        <div id="maps" style="width: 500px; height: 500px"></div>
        <a href="javascript:;" id="inputPoint" class="btn">この位置を入力</a>
    </div>
</div>
<?php echo form_close(); ?>
