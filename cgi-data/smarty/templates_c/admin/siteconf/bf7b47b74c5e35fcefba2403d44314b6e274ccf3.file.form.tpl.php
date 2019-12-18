<?php /* Smarty version Smarty-3.1.18, created on 2019-10-04 17:54:34
         compiled from "/home/jwcc/8063/html/admin/contents/siteconf/template/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11326398085d9708ca001e63-68948628%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bf7b47b74c5e35fcefba2403d44314b6e274ccf3' => 
    array (
      0 => '/home/jwcc/8063/html/admin/contents/siteconf/template/form.tpl',
      1 => 1570177183,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11326398085d9708ca001e63-68948628',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mode' => 0,
    'message' => 0,
    'arr_post' => 0,
    '_ARR_IMAGE' => 0,
    'template_image' => 0,
    '_IMAGEFULLPATH' => 0,
    '_CONTENTS_DIR' => 0,
    '_ADMIN' => 0,
    'conf' => 0,
    '_CONTENTS_ID' => 0,
    '_CONTENTS_CONF_PATH' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d9708ca0c4d63_18206092',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d9708ca0c4d63_18206092')) {function content_5d9708ca0c4d63_18206092($_smarty_tpl) {?><form class="form-horizontal" action="./<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?>update<?php } else { ?>insert<?php }?>.php" method="post" enctype="multipart/form-data">
	<div class="ibox-content">
		<div class="form-group required">
			<label class="col-sm-2 control-label">デフォルトタイトル</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['default_title'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['default_title'];?>
</p><?php }?>
				<input type="text" class="form-control" name="default_title" id="default_title" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['default_title'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group required">
			<label class="col-sm-2 control-label">デフォルトデスクリプション</label>
			<div class="col-sm-9">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['default_description'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['default_description'];?>
</p><?php }?>
				<textarea name="default_description" id="default_description" rows="7" class="form-control"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['default_description'])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">デフォルトキーワード</label>
			<div class="col-sm-6">
				<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['default_keyword'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['default_keyword'];?>
</p><?php }?>
				<p>※半角カンマ「,」区切りで記入してください。</p>
				<input type="text" class="form-control" name="default_keyword" id="default_keyword" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['default_keyword'])===null||$tmp==='' ? '' : $tmp);?>
" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<?php if ($_smarty_tpl->tpl_vars['_ARR_IMAGE']->value!=null) {?>
			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_image']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('path'=>$_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value,'dir'=>$_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value,'prefix'=>"s_"), 0);?>

		<?php }?>
		<?php  $_smarty_tpl->tpl_vars['conf'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['conf']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_ADMIN']->value['siteconf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['conf']->key => $_smarty_tpl->tpl_vars['conf']->value) {
$_smarty_tpl->tpl_vars['conf']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['conf']->value['single']==1) {?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-6">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<input type="text" class="form-control" name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp);?>
" />
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php } else { ?>
			<div class="form-group">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-9">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<textarea name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" rows="7" class="form-control"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php }?>
		<?php } ?>
		<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?><input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_ID']->value;?>
" value="1" /><?php }?>
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
