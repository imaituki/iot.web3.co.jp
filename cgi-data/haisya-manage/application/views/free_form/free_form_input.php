<!-- 画像アップロード用JSファイル -->
<script src="<?php echo base_url(); ?>js/ndsImageUpload.js" ></script>

<script type="text/javascript">


$(document).ready(function(){
    // 行を一つ上に移動させる
    $(document).on("click" , "a.upFormList" ,
    function(){
        var t=$(this).parent().parent();	//tr > td > a の構造なのでtrを見つけ出す

        if($(t).prev("tr")){
            $(t).insertBefore($(t).prev("tr")[0]);
        }

        tbody_obj = t.parent();
        tbody_obj_id = $(tbody_obj).attr('id');

        var sort_order_joined_text_key = tbody_obj_id.replace(/_tbody/g, "");
        update_form_sort(sort_order_joined_text_key);
    });

    // 行を一つ下に移動させる
    $(document).on("click" , "a.downFormList" , function(){
        var t=$(this).parent().parent();	//tr > td > a の構造なのでtrを見つけ出す

        if($(t).next("tr")){
            $(t).insertAfter($(t).next("tr")[0]);
        }

        tbody_obj = t.parent();
        tbody_obj_id = $(tbody_obj).attr('id');

        var sort_order_joined_text_key = tbody_obj_id.replace(/_tbody/g, "");
        update_form_sort(sort_order_joined_text_key);
    });
});

/**
 * ソートの完了後にtrタグのid属性を元にtrタグの並びを取得し、hidden要素にカンマ区切りのソート順を
 * セットする処理。
 */
function update_form_sort(sort_order_joined_text_key) {

	var column_id_array = new Array();

	//ソート要素の持つIDを保持
	$('#'+sort_order_joined_text_key+'_tbody tr').each(function(){
		column_id_array.push(this.id);
	});

	var joinedStr = "";

	//ソート可能なタグのid属性はtr_{連番}となっているので、連番のみを抽出してカンマで連結する
	for (var i = 0; i < column_id_array.length; i++) {
		joinedStr += (i != 0) 
		             ? ',' 
				     : '';

		joinedStr += column_id_array[i].replace(/tr_/g, "");
	}

	//hiddenにセット
	$('#'+sort_order_joined_text_key+'_num_str_id').val(joinedStr);
}

</script>

<!-- DatePickerを設定 -->
<SCRIPT Language="JavaScript">
<!--
	$(document).ready(function(){
		//dataPickerを設定
		$("#post_date_id").datepicker();
		$("#new_icon_end_date_id").datepicker();
		$("#publish_end_date_id").datepicker();
	});
// -->
</SCRIPT>
<!-- //DatePickerを設定 -->
<div>

<?php echo form_open_multipart($this->common_form_action_base . 'conf/', array('id' => 'common_form')); ?>

<!-- JSファイルからフォームのアクション先を取得するためのhidden要素 -->
<input type="hidden" id="common_form_action_base" value="<?php echo site_url($this->common_form_action_base); ?>" />
<!-- 画像のアップロード、削除で対象の画像を特定するhidden要素 -->
<input type="hidden" name="target_image_id" id="target_image_id" value="" />

<?php if ($this->page_type == Page_type::EDIT): ?>
<div class="well">
	<div class="pull-left">
		<a href="<?php echo site_url($this->page_path_search_again); ?>" class="btn "><i class="icon-arrow-left"></i> 戻る</a>
	</div>
</div>
<?php endif; ?>

<div class="alert alert-info">
	必要事項を入力し、画面下の確認ボタンを押してください。
	入力内容の確認画面に進みます。
</div>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">管理情報</th>
	</tr>
</thead>
<tbody>
	<tr>
		<th class="span3">公開/非公開</th>
		<td>
			<label class="checkbox"><?php echo form_nds_checkbox('draft_flg', Draft_flg::DRAFT, $this->data, 'class="checkbox"'); ?>&nbsp;非公開</label>
			<span class="help-block">非公開にチェックした場合は公開されません</span>
			<?php echo form_error('draft_flg'); ?>
		</td>
	</tr>
	<?php if ($this->column_post_date_use): ?>
	<tr>
		<th><?php echo $this->label_post_date; ?>　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('post_date', $this->data, 'class="input-medium" id="post_date_id" size="10" maxlength="10"'); ?>
			<span class="help-block">yyyy/mm/dd形式で入力してください。</span>
			<?php echo form_error('post_date'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_new_icon_end_date_use): ?>
	<tr>
		<th><?php echo $this->label_new_icon_end_date; ?></th>
		<td>
			<?php echo form_nds_input('new_icon_end_date', $this->data, 'class="input-medium" id="new_icon_end_date_id" size="10" maxlength="10"'); ?>
			<span class="help-inline">yyyy/mm/dd形式で入力してください。</span>
			<span class="help-block">※NEWアイコンを表示させない場合はブランクにしてください</span>
			<?php echo form_error('new_icon_end_date'); ?>
			<?php echo error_msg($this->error_list, 'new_icon_date_reverse_date_error'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_publish_end_date_use): ?>
	<tr>
		<th><?php echo $this->label_publish_end_date; ?></th>
		<td>
			<?php echo form_nds_input('publish_end_date', $this->data, 'class="input-medium" id="publish_end_date_id" size="10" maxlength="10"'); ?>
			<span class="help-inline">yyyy/mm/dd形式で入力してください。</span>
			<span class="help-block">※公開し続ける場合はブランクにしてください。</span>
			<?php echo form_error('publish_end_date'); ?>
			<?php echo error_msg($this->error_list, 'publish_end_date_reverse_date_error'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->basic_category_use): ?>
	<tr>
		<th><?php echo $this->label_basic_category; ?></th>
		<td>
			<?php if ( ! empty($this->basic_category_list)): ?>
			<?php foreach ($this->basic_category_list as $key => $value): ?>
			<label class="checkbox inline" ><?php echo form_nds_multi_checkbox('basic_category_ids', $key, $this->data); ?> <?php echo h($value); ?></label>
			<?php endforeach; ?>
			<?php endif; ?>

			<?php echo form_error('basic_category_ids'); ?>
			<?php echo error_msg($this->error_list, 'basic_category_ids_relation_error'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_order_number_use): ?>
	<tr>
		<th><?php echo $this->label_order_number; ?>　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('order_number', $this->data, ' class="span1" size="2" maxlength="4" '); ?>
			<?php echo form_error('order_number'); ?>
			<span class="help-block">数字で入力してください。</span>
		</td>
	</tr>
	<?php endif; ?>
</tbody>
</table>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">基本情報</th>
	</tr>
</thead>
<tbody>
	<?php if ($this->column_post_title_use): ?>
	<tr>
		<th class="span3"><?php echo $this->label_post_title; ?>　<span class="label label-warning">必須</span></th>
		<td>
			<?php echo form_nds_input('post_title', $this->data, 'class="span9" '); ?>
			<span class="help-block">最大200文字</span>
			<?php echo form_error('post_title'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_sub_title_use): ?>
	<tr>
		<th class="span3"><?php echo $this->label_post_sub_title; ?></th>
		<td>
			<?php echo form_nds_input('post_sub_title', $this->data, 'class="span9" '); ?>
			<span class="help-block">最大200文字</span>
			<?php echo form_error('post_sub_title'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_content_use): ?>
	<tr>
		<th class="span3">
			<?php echo $this->label_post_content; ?>
			<span class="help-block">※最大5000文字</span>
		</th>
		<td>
			<?php echo form_nds_textarea('post_content', $this->data, ' id="editor1" class="span8" rows="14"'); ?>
			<?php echo form_error('post_content'); ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if ($this->column_post_link_use): ?>
	<tr>
		<th class="span3"><?php echo $this->label_post_link; ?></th>
		<td>
			<span class="label" style="vertical-align:baseline;">URL</span>　<?php echo form_nds_input('post_link', $this->data, 'class="span9" placeholder="http://xxxxxxx" '); ?>
			<span class="help-block">URL形式で入力してください</span><br />
			<?php echo form_error('post_link'); ?>
			<span class="label" style="vertical-align:baseline;"><?php echo $this->label_post_link_text; ?></span>　<?php echo form_nds_input('post_link_text', $this->data, 'class="span5" '); ?>
			<span class="help-block">リンクに使われる文字です。未入力の場合は規定値が使用されます。最大50文字</span>
			<?php echo form_error('post_link_text'); ?>
		</td>
	</tr>
	<?php endif; ?>
</tbody>
</table>

<table class="table table-bordered">
<thead>
	<tr>
		<th colspan="2" class="table_section">メール設定</th>
	</tr>
</thead>
<tbody>
<tr>
	<th class="span3">送信先メールアドレス　<span class="label label-warning">必須</span></th>
	<td>
		<?php echo form_nds_input('to_email', $this->data, ' class="" '); ?>
		<?php echo form_error('to_email'); ?>
	</td>
</tr>
<tr>
	<th>送信先メールアドレス2</th>
	<td>
		<?php echo form_nds_input('to_email_2', $this->data, ' class="" '); ?>
		<?php echo form_error('to_email_2'); ?>
		<span class="help-inline">送信先が2つある場合に使用します。</span>
	</td>
</tr>
<tr>
	<th>送信元メールアドレス</th>
	<td>
		<?php echo form_nds_input('from_email', $this->data, ' class="" '); ?>
		<?php echo form_error('from_email'); ?>
		<span class="help-inline">送信元として表示されるメールアドレスです。未入力の場合は「送信先メールアドレス」と同じものを使用します。</span>
	</td>
</tr>
<tr>
	<th>差出人</th>
	<td>
		<?php echo form_nds_input('from_label', $this->data, ' class="span7" '); ?>
		<?php echo form_error('from_label'); ?>
		<span class="help-inline">差出人として表示されます</span>
	</td>
</tr>
<tr>
	<th>メール件名</th>
	<td>
		<?php echo form_nds_input('mail_subject', $this->data, ' class="span7" '); ?>
		<?php echo form_error('mail_subject'); ?>
		<span class="help-block">メールの件名に表示されます。未入力の場合は「[{お知らせのタイトル}]の申し込み」が設定されます。</span>
	</td>
</tr>
<tr>
	<th>確認メール用メッセージ</th>
	<td>
		<?php echo form_nds_textarea('confirm_message', $this->data, ' class="span7" rows="5" '); ?>
		<?php echo form_error('confirm_message'); ?>
		<span class="help-block">申し込みいただいた方に送信される確認メールの本文の冒頭部分です。未入力の場合はシステム共通の文言が設定されます。</span>
	</td>
</tr>
<tr>
	<th>署名</th>
	<td>
		<?php echo form_nds_textarea('mail_signature', $this->data, ' class="span7" rows="5" '); ?>
		<?php echo form_error('mail_signature'); ?>
		<span class="help-block">メール本文の最後の署名です。未入力の場合は署名なしとなります。</span>
	</td>
</tr>

	<!-- 追加項目セット位置 -->
</tbody>
</table>


<!-- ソート順 -->
<input type="hidden" name="basic_column_order_num_str" id="basic_column_order_num_str_id" value="<?php echo h($basic_column_order_num_str); ?>" />
<input type="hidden" name="optional_column_order_num_str" id="optional_column_order_num_str_id" value="<?php echo h($optional_column_order_num_str); ?>" />

<table class="table table-bordered" id="mail_form_basic_detail_table">
<thead>
	<tr>
		<th colspan="5" class="table_section">
		問い合わせフォーム　基本項目<span class="help-block">(並び順を変更する場合は各項目の左端のアイコンをドラッグし、上下に移動させて任意の場所にドロップして下さい。)</span>
		</th>
	</tr>
	<tr>
		<th class="span3">項目名</th>
		<th class=""></th>
		<th class="">使用有無</th>
		<th class="">詳細</th>
		<th ></th>
	</tr>
</thead>
<tbody id="basic_column_order_tbody">
	<?php $column_no_order_list = explode(',', $basic_column_order_num_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php 
		//連番のキーを作成
		$title_key = "basic_form{$column_no}_title";
		$coices_key = "basic_form{$column_no}_choices";
		$form_type_key = "basic_form{$column_no}_form_type";
		$require_flg_key = "basic_form{$column_no}_require_flg";
	?>
	<tr id="tr_<?php echo $column_no; ?>">
		<td>
			<span class="label label-info"><?php echo Mail_form_column::get_basic_label($column_no); ?></span>
			<?php echo form_nds_input($title_key, $this->data, ' size="70" maxlength="200"'); ?>
			<?php echo form_error($title_key); ?>
			<?php echo h_error($this->error_list[$title_key]); ?>
		</td>
		<td>
			<label class="checkbox"><?php echo form_nds_checkbox($require_flg_key, Valid_flg::VALID, $this->data); ?> 必須</label>
		</td>
		<td>
			<label class="checkbox"><?php echo form_nds_checkbox($form_type_key, Form_type::FORM_USE, $this->data); ?> 使用する</label>
		</td>
		<td>
			<span class="help-block"><?php echo Mail_form_column::get_check_description($column_no); ?></span>
		</td>
		<td>
			<a href="#" onclick="return false;" class="upFormList"><img src="<?php echo base_url(); ?>img/arrow_up.png" alt="上へ" width="40" height="28" /></a>
			<a href="#" onclick="return false;" class="downFormList"><img src="<?php echo base_url(); ?>img/arrow_down.png" alt="下へ" width="40" height="28" /></a>
		</td>
	</tr>
	<?php endforeach; ?>
</tbody>
</table>

<table class="table table-bordered" id="mail_form_option_detail_table">
<thead>
	<tr>
		<th colspan="5" class="table_section">
		問い合わせフォーム　追加項目<span class="help-block">(並び順を変更する場合は各項目の左端のアイコンをドラッグし、上下に移動させて任意の場所にドロップして下さい。)</span>
		</th>
	</tr>
	<tr>
		<th class="span3">項目名</th>
		<th class=""></th>
		<th class="">種類</th>
		<th class="">選択肢（選択項目の場合に使用）<span class="help-inline">(選択肢を　| （パイプ記号）で続けて入力してください)</span></th>
		<th></th>
	</tr>
</thead>
<tbody id="optional_column_order_tbody">
	<?php $column_no_order_list = explode(',', $optional_column_order_num_str); ?>
	<?php foreach ($column_no_order_list as $column_no): ?>
	<?php 
		//連番のキーを作成
		$title_key = "optional_form{$column_no}_title";
		$coices_key = "optional_form{$column_no}_choices";
		$form_type_key = "optional_form{$column_no}_form_type";
		$require_flg_key = "optional_form{$column_no}_require_flg";
	?>
	<tr id="tr_<?php echo $column_no; ?>">
		<td>
			<?php echo form_nds_input($title_key, $this->data, ' size="70" maxlength="200"'); ?>
			<?php echo form_error($title_key); ?>
			<?php echo h_error($this->error_list[$title_key]); ?>
		</td>
		<td>
			<label class="checkbox"><?php echo form_nds_checkbox($require_flg_key, Valid_flg::VALID, $this->data); ?>必須</label>
		</td>
		<td>
			<?php echo form_nds_dropdown($form_type_key, Form_type::$CONST_ARRAY, $this->data, ''); ?>
		</td>
		<td>
			<?php echo form_nds_input($coices_key, $this->data, 'class="span5" size="70" maxlength="200" placeholder="例　参加する|欠席する|懇親会のみ参加する"'); ?>
			<?php echo h_error($this->error_list[$coices_key]); ?>
		</td>
		<td>
			<a href="#" onclick="return false;" class="upFormList"><img src="<?php echo base_url(); ?>img/arrow_up.png" alt="上へ" width="40" height="28" /></a>
			<a href="#" onclick="return false;" class="downFormList"><img src="<?php echo base_url(); ?>img/arrow_down.png" alt="下へ" width="40" height="28" /></a>
		</td>
	</tr>
	<?php endforeach; ?>
</tbody>
</table>

<div class=" pull-right">
<a href="#" title="このページのトップへ">このページのトップへ</a>
</div>

<div class="form-actions">
	<input type="submit" name="conf" value="　確認　" class="btn btn-primary" />
</div>

<?php echo form_close(); ?>

</div>
