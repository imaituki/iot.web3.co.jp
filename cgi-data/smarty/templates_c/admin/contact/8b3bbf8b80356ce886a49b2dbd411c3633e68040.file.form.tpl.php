<?php /* Smarty version Smarty-3.1.18, created on 2019-06-20 17:34:09
         compiled from "/home/jwcc/8071/html/admin/contents/contact/template/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4511513895d0b3a31d93110-28844587%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8b3bbf8b80356ce886a49b2dbd411c3633e68040' => 
    array (
      0 => '/home/jwcc/8071/html/admin/contents/contact/template/form.tpl',
      1 => 1561019408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4511513895d0b3a31d93110-28844587',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d0b3a31e61314_65944417',
  'variables' => 
  array (
    'message' => 0,
    'arr_post' => 0,
    'mode' => 0,
    '_CONTENTS_ID' => 0,
    '_CONTENTS_DIR' => 0,
    '_CONTENTS_CONF_PATH' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d0b3a31e61314_65944417')) {function content_5d0b3a31e61314_65944417($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include '/home/jwcc/8071/data/smarty/libs/plugins/function.html_radios.php';
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
			<label class="col-sm-2 control-label">名前</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['name'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['name'];?>
</p><?php }?>
				<input type="text" class="form-control" name="name" id="name" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['name'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">電話番号</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['tel'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['tel'];?>
</p><?php }?>
				<input type="text" class="form-control" name="tel" id="tel" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['tel'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group required">
			<label class="col-sm-2 control-label">メールアドレス</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['mail'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['mail'];?>
</p><?php }?>
				<input type="text" class="form-control" name="mail" id="mail" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['mail'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed required"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">質問内容 </label>
			<div class="col-sm-9">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['comment'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['comment'];?>
</p><?php }?>
				<textarea name="comment" id="comment" rows="7" class="form-control ckeditor"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['comment'])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
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
				<div class="col-sm-offset-1 fl_left">
					<input type="button" id="preview" class="btn btn-info" value="プレビュー" />
				</div>
				<div class="fl_right">
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
