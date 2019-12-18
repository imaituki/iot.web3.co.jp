<?php /* Smarty version Smarty-3.1.18, created on 2019-11-29 14:57:27
         compiled from "/virtual/119.245.151.134/home/admin/contents/case/template/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17269037655db648141c9fd0-56093022%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '16b7d7daaabfece2f239c02d47721d8b6d6a1f77' => 
    array (
      0 => '/virtual/119.245.151.134/home/admin/contents/case/template/form.tpl',
      1 => 1575007043,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17269037655db648141c9fd0-56093022',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db6481433c524_67911456',
  'variables' => 
  array (
    'message' => 0,
    'arr_post' => 0,
    'OptionCaseCategory' => 0,
    '_ARR_IMAGE' => 0,
    'template_image' => 0,
    '_IMAGEFULLPATH' => 0,
    '_CONTENTS_DIR' => 0,
    '_ARR_FILE' => 0,
    'template_file' => 0,
    'mode' => 0,
    '_CONTENTS_ID' => 0,
    '_CONTENTS_CONF_PATH' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db6481433c524_67911456')) {function content_5db6481433c524_67911456($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/function.html_options.php';
if (!is_callable('smarty_function_html_radios')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/function.html_radios.php';
?><form id="inputForm" name="inputForm" class="form-horizontal" action="./preview.php?preview=1" method="post" enctype="multipart/form-data">
	<div class="ibox-content">
		<div class="form-group required">
			<label class="col-sm-2 control-label">日付 </label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['date'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['date'];?>
</p><?php }?>
				<div class="input-daterange input-group" id="datepicker">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" class="input-sm form-control datepicker" name="date" id="date" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['date'])===null||$tmp==='' ? '' : $tmp);?>
" readonly>
				</div>
			</div>
		</div>
		<div class="hr-line-dashed"></div>
			<div class="form-group required">
				<label class="col-sm-2 control-label">カテゴリ</label>
				<div class="col-sm-6">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['case_category'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['case_category'];?>
</p><?php }?>

					<div class="radio m-r-xs inline">
						<select class="form-control" name="case_category" id="case_category">
							<option value="0">選択してください</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['OptionCaseCategory']->value,'selected'=>$_smarty_tpl->tpl_vars['arr_post']->value['case_category']),$_smarty_tpl);?>

						</select>
					</div>
				</div>
			</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group required">
			<label class="col-sm-2 control-label">タイトル</label>
			<div class="col-sm-8">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['title'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['title'];?>
</p><?php }?>
				<input type="text" class="form-control" name="title" id="title" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<?php if ($_smarty_tpl->tpl_vars['_ARR_IMAGE']->value!=null) {?>
			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_image']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('path'=>$_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value,'dir'=>$_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value,'prefix'=>"s_"), 0);?>

		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['_ARR_FILE']->value!=null) {?>
			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_file']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('path'=>$_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value,'dir'=>$_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value), 0);?>

		<?php }?>
		<div class="form-group">
			<label class="col-sm-2 control-label">本文 </label>
			<div class="col-sm-9">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['comment'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['comment'];?>
</p><?php }?>
				<textarea name="comment" id="comment" rows="7" class="form-control ckeditor"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['comment'])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">掲載期間 </label>
			<div class="col-sm-4">
				<div class="radio m-r-xs inline mb15">
					<?php echo smarty_function_html_radios(array('name'=>"display_indefinite",'values'=>1,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_indefinite'])===null||$tmp==='' ? "1" : $tmp),'output'=>"設定しない"),$_smarty_tpl);?>
&nbsp;&nbsp;
					<?php echo smarty_function_html_radios(array('name'=>"display_indefinite",'values'=>0,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_indefinite'])===null||$tmp==='' ? "1" : $tmp),'output'=>"設定する"),$_smarty_tpl);?>

				</div>
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['display_start'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['display_start'];?>
</p><?php }?>
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['display_end'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['display_end'];?>
</p><?php }?>
				<div class="input-daterange input-group" id="datepicker">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
					<input type="text" class="input-sm form-control datepicker" name="display_start" id="display_start" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_start'])===null||$tmp==='' ? '' : $tmp);?>
" readonly>
					<span class="input-group-addon">～</span>
					<input type="text" class="input-sm form-control datepicker" name="display_end" id="display_end"  value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_end'])===null||$tmp==='' ? '' : $tmp);?>
" readonly>
				</div>
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">表示／非表示</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['display_flg'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['display_flg'];?>
</p><?php }?>
				<div class="radio m-r-xs inline">
					<?php echo smarty_function_html_radios(array('name'=>"display_flg",'values'=>1,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_flg'])===null||$tmp==='' ? "1" : $tmp),'output'=>"する"),$_smarty_tpl);?>
&nbsp;&nbsp;
					<?php echo smarty_function_html_radios(array('name'=>"display_flg",'values'=>0,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_flg'])===null||$tmp==='' ? "1" : $tmp),'output'=>"しない"),$_smarty_tpl);?>

				</div>
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="button clearfix mb20">
			<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_ID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['_CONTENTS_ID']->value];?>
" /><?php }?>
			<input type="hidden" name="_contents_dir" id="_contents_dir" value="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value;?>
" />
			<input type="hidden" name="_contents_conf_path" id="_contents_conf_path" value="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_CONF_PATH']->value;?>
" />
			<div class="form-group">
				<div style="text-align:right;">
					<input type="button" class="btn btn-primary" value="この内容で登録" id="<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?>updateBtn<?php } else { ?>insertBtn<?php }?>" />
				</div>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript">
$(function(){
	// プレビューボタンを押すとプレビューが別窓で表示される
	$('input[id="preview"]').on("click", function() {
		window.open("about:blank", "preview");
		document.inputForm.target = "preview";
		document.inputForm.submit();
	});
});
</script>

<?php }} ?>
