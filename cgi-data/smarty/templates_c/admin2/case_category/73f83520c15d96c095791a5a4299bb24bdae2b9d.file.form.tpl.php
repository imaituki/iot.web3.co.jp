<?php /* Smarty version Smarty-3.1.18, created on 2019-11-05 15:51:24
         compiled from "/virtual/119.245.151.134/home/admin/contents/case_category/template/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13456425445db285fe44a628-64530362%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73f83520c15d96c095791a5a4299bb24bdae2b9d' => 
    array (
      0 => '/virtual/119.245.151.134/home/admin/contents/case_category/template/form.tpl',
      1 => 1572936679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13456425445db285fe44a628-64530362',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db285fe53c0b2_48343366',
  'variables' => 
  array (
    'message' => 0,
    'arr_post' => 0,
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
<?php if ($_valid && !is_callable('content_5db285fe53c0b2_48343366')) {function content_5db285fe53c0b2_48343366($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/function.html_radios.php';
?><form id="inputForm" name="inputForm" class="form-horizontal" action="./preview.php?preview=1" method="post" enctype="multipart/form-data">
	<div class="ibox-content">
		<div class="hr-line-dashed"></div>
		<div class="form-group required">
			<label class="col-sm-2 control-label">実績紹介カテゴリ名</label>
			<div class="col-sm-3">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['name'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['name'];?>
</p><?php }?>
				<input type="text" class="form-control" name="name" id="name" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['name'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
		<label class="col-sm-2 control-label">一言コメント</label>
		<div class="col-sm-9">
			<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['short_comment'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['short_comment'];?>
</p><?php }?>
			<input  type="text" class="form-control" name="short_comment" id="short_comment" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['short_comment'])===null||$tmp==='' ? '' : $tmp);?>
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
			<label class="col-sm-2 control-label">表示／非表示</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['display_flg'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['display_flg'];?>
</p><?php }?>
				<div class="radio m-r-xs inline">
					<?php echo smarty_function_html_radios(array('name'=>"display_flg",'values'=>1,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['display_flg'])===null||$tmp==='' ? "1" : $tmp),'output'=>"する"),$_smarty_tpl);?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
<?php }} ?>
