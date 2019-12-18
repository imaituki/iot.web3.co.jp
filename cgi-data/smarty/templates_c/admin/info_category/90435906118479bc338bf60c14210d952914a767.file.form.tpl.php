<?php /* Smarty version Smarty-3.1.18, created on 2019-07-24 10:28:32
         compiled from "/home/jwcc/8071/html/admin/contents/info_category/template/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12592583515d37b4400a1518-40436521%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90435906118479bc338bf60c14210d952914a767' => 
    array (
      0 => '/home/jwcc/8071/html/admin/contents/info_category/template/form.tpl',
      1 => 1563931697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12592583515d37b4400a1518-40436521',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mode' => 0,
    'message' => 0,
    'arr_post' => 0,
    '_CONTENTS_ID' => 0,
    '_CONTENTS_DIR' => 0,
    '_CONTENTS_CONF_PATH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d37b4400f62c5_36110724',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d37b4400f62c5_36110724')) {function content_5d37b4400f62c5_36110724($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include '/home/jwcc/8071/data/smarty/libs/plugins/function.html_radios.php';
?><form class="form-horizontal" action="./<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?>update<?php } else { ?>insert<?php }?>.php" method="post" enctype="multipart/form-data">
	<div class="ibox-content">
		<div class="form-group required">
			<label class="col-sm-2 control-label">タイトル</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['title'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['title'];?>
</p><?php }?>
				<input type="text" class="form-control" name="title" id="title" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['title'])===null||$tmp==='' ? '' : $tmp);?>
" />
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
		<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_ID']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['_CONTENTS_ID']->value];?>
" /><?php }?>
		<input type="hidden" name="_contents_dir" id="_contents_dir" value="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value;?>
" />
		<input type="hidden" name="_contents_conf_path" id="_contents_conf_path" value="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_CONF_PATH']->value;?>
" />
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2 pos_ar">
				<button class="btn btn-primary"  type="submit">この内容で登録</button>
			</div>
		</div>
	</div>
</form><?php }} ?>
