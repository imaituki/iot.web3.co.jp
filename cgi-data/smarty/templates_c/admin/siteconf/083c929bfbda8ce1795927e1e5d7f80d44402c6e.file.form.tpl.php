<?php /* Smarty version Smarty-3.1.18, created on 2019-10-07 14:03:57
         compiled from "/home/jwcc/8063/html/admin/contents/siteconf2/template/form.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18287193275d99fcdfdde1a9-72540343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '083c929bfbda8ce1795927e1e5d7f80d44402c6e' => 
    array (
      0 => '/home/jwcc/8063/html/admin/contents/siteconf2/template/form.tpl',
      1 => 1570424583,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18287193275d99fcdfdde1a9-72540343',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d99fcdfed2a72_63923015',
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
    'key' => 0,
    'options' => 0,
    '_CONTENTS_ID' => 0,
    '_CONTENTS_CONF_PATH' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d99fcdfed2a72_63923015')) {function content_5d99fcdfed2a72_63923015($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include '/home/jwcc/8063/data/smarty/libs/plugins/function.html_radios.php';
if (!is_callable('smarty_function_html_options')) include '/home/jwcc/8063/data/smarty/libs/plugins/function.html_options.php';
?><form class="form-horizontal" action="./<?php if ($_smarty_tpl->tpl_vars['mode']->value=='edit') {?>update<?php } else { ?>insert<?php }?>.php" method="post" enctype="multipart/form-data">
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
 $_from = $_smarty_tpl->tpl_vars['_ADMIN']->value['siteconf2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['conf']->key => $_smarty_tpl->tpl_vars['conf']->value) {
$_smarty_tpl->tpl_vars['conf']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['conf']->value['type']=="date") {?>
			<div class="form-group<?php if ($_smarty_tpl->tpl_vars['conf']->value['empty']!=1) {?> required<?php }?>">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
 </label>
				<div class="col-sm-6">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<div class="input-daterange input-group" id="datepicker">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input type="text" class="input-sm form-control datepicker <?php echo $_smarty_tpl->tpl_vars['conf']->value['class'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['id'];?>
" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp);?>
" readonly>
					</div>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php } elseif ($_smarty_tpl->tpl_vars['conf']->value['type']=="text") {?>
			<div class="form-group<?php if ($_smarty_tpl->tpl_vars['conf']->value['empty']!=1) {?> required<?php }?>">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-6">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<input type="text" class="form-control <?php echo $_smarty_tpl->tpl_vars['conf']->value['class'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['id'];?>
" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp);?>
" />
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php } elseif ($_smarty_tpl->tpl_vars['conf']->value['type']=="textarea") {?>
			<div class="form-group<?php if ($_smarty_tpl->tpl_vars['conf']->value['empty']!=1) {?> required<?php }?>">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-9">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<textarea name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['id'];?>
" rows="7" class="form-control <?php echo $_smarty_tpl->tpl_vars['conf']->value['class'];?>
"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp);?>
</textarea>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php } elseif ($_smarty_tpl->tpl_vars['conf']->value['type']=="radio") {?>
			<div class="form-group<?php if ($_smarty_tpl->tpl_vars['conf']->value['empty']!=1) {?> required<?php }?>">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-9">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<div class="radio m-r-xs inline">
						<?php echo smarty_function_html_radios(array('name'=>$_smarty_tpl->tpl_vars['conf']->value['name'],'options'=>$_smarty_tpl->tpl_vars['conf']->value['options'],'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? "1" : $tmp)),$_smarty_tpl);?>

					</div>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php } elseif ($_smarty_tpl->tpl_vars['conf']->value['type']=="select") {?>
			<div class="form-group<?php if ($_smarty_tpl->tpl_vars['conf']->value['empty']!=1) {?> required<?php }?>">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-9">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					<div class="radio m-r-xs inline">
						<select class="form-control <?php echo $_smarty_tpl->tpl_vars['conf']->value['class'];?>
" name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['id'];?>
">
							<option value="0">選択してください</option>
							<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['conf']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']]),$_smarty_tpl);?>

						</select>
					</div>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			<?php } elseif ($_smarty_tpl->tpl_vars['conf']->value['type']=="checkbox") {?>
			<div class="form-group<?php if ($_smarty_tpl->tpl_vars['conf']->value['empty']!=1) {?> required<?php }?>">
				<label class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</label>
				<div class="col-sm-9">
					<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng'][$_smarty_tpl->tpl_vars['conf']->value['name']];?>
</p><?php }?>
					<?php if (!empty($_smarty_tpl->tpl_vars['conf']->value['description'])) {?><p><?php echo $_smarty_tpl->tpl_vars['conf']->value['description'];?>
</p><?php }?>
					
					<?php  $_smarty_tpl->tpl_vars["options"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["options"]->_loop = false;
 $_smarty_tpl->tpl_vars["key"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['conf']->value['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["options"]->key => $_smarty_tpl->tpl_vars["options"]->value) {
$_smarty_tpl->tpl_vars["options"]->_loop = true;
 $_smarty_tpl->tpl_vars["key"]->value = $_smarty_tpl->tpl_vars["options"]->key;
?>
					<div class="checkbox m-r-xs inline">
						<input type="checkbox" name="<?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['conf']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="<?php echo $_smarty_tpl->tpl_vars['conf']->value['class'];?>
" value="<?php echo $_smarty_tpl->tpl_vars['options']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['key']->value,$_smarty_tpl->tpl_vars['arr_post']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])) {?>checked<?php }?>>
						<label for="<?php echo $_smarty_tpl->tpl_vars['conf']->value['id'];?>
-<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['conf']->value['name'];?>
</label>
					</div>
					<?php } ?>
					
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
</form>
<?php }} ?>
