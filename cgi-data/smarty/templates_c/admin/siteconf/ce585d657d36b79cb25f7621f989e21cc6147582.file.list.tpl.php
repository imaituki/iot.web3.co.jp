<?php /* Smarty version Smarty-3.1.18, created on 2019-09-04 14:02:23
         compiled from "/home/jwcc/8071/html/admin/contents/siteconf/template/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16964310785d08b671e37144-98362347%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ce585d657d36b79cb25f7621f989e21cc6147582' => 
    array (
      0 => '/home/jwcc/8071/html/admin/contents/siteconf/template/list.tpl',
      1 => 1564048363,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16964310785d08b671e37144-98362347',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d08b671eb0552_05541228',
  'variables' => 
  array (
    'template_pagenavi' => 0,
    'data' => 0,
    '_ARR_IMAGE' => 0,
    'file' => 0,
    '_IMAGEFULLPATH' => 0,
    '_CONTENTS_DIR' => 0,
    '_ADMIN' => 0,
    'conf' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d08b671eb0552_05541228')) {function content_5d08b671eb0552_05541228($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_pagenavi']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15">
	<tbody>
		<tr class="gray-bg">
			<th colspan="2">サイトSEO設定</th>
		</tr>
		<tr>
			<th width="250">デフォルトタイトル</th>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['data']->value['default_title'])===null||$tmp==='' ? '' : $tmp);?>
</td>
		</tr>
		<tr>
			<th>デフォルトデスクリプション</th>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['data']->value['default_description'])===null||$tmp==='' ? '' : $tmp);?>
</td>
		</tr>
		<tr>
			<th>デフォルトキーワード</th>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['data']->value['default_keyword'])===null||$tmp==='' ? '' : $tmp);?>
</td>
		</tr>
		<tr>
			<th>デフォルトOGP画像</th>
			<td>
				<div class="lightBoxGallery pos_al">
					<?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_ARR_IMAGE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['file']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['file']['iteration']++;
?>
						<?php if ($_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['file']->value['name']]) {?>
							<a href="<?php echo $_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['file']->value['name'];?>
/l_<?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['file']->value['name']];?>
" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['file']->value['comment'])===null||$tmp==='' ? '' : $tmp);?>
" rel="lightbox[]">
								<img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['file']->value['name'];?>
/s_<?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['file']->value['name']];?>
" />
							</a>
						<?php }?>
						<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['file']['iteration']%3==0) {?><br /><?php }?>
					<?php } ?>
				</div>
			</td>
		</tr>
	</tbody>
</table>
<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15">
	<tbody>
		<tr class="gray-bg">
			<th colspan="2">企業情報設定</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['conf'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['conf']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_ADMIN']->value['siteconf']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['conf']->key => $_smarty_tpl->tpl_vars['conf']->value) {
$_smarty_tpl->tpl_vars['conf']->_loop = true;
?>
		<tr>
			<th width="250"><?php echo $_smarty_tpl->tpl_vars['conf']->value['title'];?>
</th>
			<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['conf']->value['name']])===null||$tmp==='' ? '' : $tmp);?>
</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_pagenavi']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
