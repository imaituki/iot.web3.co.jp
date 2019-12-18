<?php /* Smarty version Smarty-3.1.18, created on 2019-10-18 14:04:16
         compiled from "/home/jwcc/8063/html/admin/contents/case_category/template/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15931759925da947d0eb6115-74084908%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '241f482df53f1d3ff68bd7032b357dbd0080f477' => 
    array (
      0 => '/home/jwcc/8063/html/admin/contents/case_category/template/list.tpl',
      1 => 1571371679,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15931759925da947d0eb6115-74084908',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'template_pagenavi' => 0,
    't_case_category' => 0,
    'case_category' => 0,
    '_ARR_IMAGE' => 0,
    'file' => 0,
    '_IMAGEFULLPATH' => 0,
    '_CONTENTS_DIR' => 0,
    '_CONTENTS_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5da947d0f1f615_22967077',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5da947d0f1f615_22967077')) {function content_5da947d0f1f615_22967077($_smarty_tpl) {?>			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_pagenavi']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15">
				<thead>
					<tr>
						<th>実績紹介カテゴリ名</th>
						<th class="photo">写真</th>
						<th class="showhide">表示</th>
						<th class="delete">削除</th>
					</tr>
				</thead>
				<tbody>
					<?php  $_smarty_tpl->tpl_vars["case_category"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["case_category"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['t_case_category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["case_category"]->key => $_smarty_tpl->tpl_vars["case_category"]->value) {
$_smarty_tpl->tpl_vars["case_category"]->_loop = true;
?>
					<tr>
						<td><a href="./edit.php?id=<?php echo $_smarty_tpl->tpl_vars['case_category']->value['id_case_category'];?>
"><?php echo $_smarty_tpl->tpl_vars['case_category']->value['name'];?>
</a></td>
						<td class="pos_al">
							<div class="lightBoxGallery">
								<?php  $_smarty_tpl->tpl_vars['file'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['file']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['_ARR_IMAGE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['file']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['file']->key => $_smarty_tpl->tpl_vars['file']->value) {
$_smarty_tpl->tpl_vars['file']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['file']['iteration']++;
?>
									<?php if ($_smarty_tpl->tpl_vars['case_category']->value[$_smarty_tpl->tpl_vars['file']->value['name']]) {?>
										<a href="<?php echo $_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['file']->value['name'];?>
/l_<?php echo $_smarty_tpl->tpl_vars['case_category']->value[$_smarty_tpl->tpl_vars['file']->value['name']];?>
" title="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['file']->value['comment'])===null||$tmp==='' ? '' : $tmp);?>
" rel="lightbox[]">
											<img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEFULLPATH']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['file']->value['name'];?>
/s_<?php echo $_smarty_tpl->tpl_vars['case_category']->value[$_smarty_tpl->tpl_vars['file']->value['name']];?>
" width="50" />
										</a>
									<?php }?>
									<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['file']['iteration']%3==0) {?><br /><?php }?>
								<?php } ?>
							</div>
						</td>
						<td class="pos_ac">
							<div class="switch">
								<div class="onoffswitch">
									<input type="checkbox" value="1" class="onoffswitch-checkbox btn_display" id="display<?php echo $_smarty_tpl->tpl_vars['case_category']->value['id_case_category'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['case_category']->value['id_case_category'];?>
"<?php if ($_smarty_tpl->tpl_vars['case_category']->value['display_flg']==1) {?> checked<?php }?>>
									<label class="onoffswitch-label" for="display<?php echo $_smarty_tpl->tpl_vars['case_category']->value['id_case_category'];?>
">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</div>
						</td>
						<td class="pos_ac" style="text-align:unset;">
							<a href="javascript:void(0)" class="btn btn-sm btn-danger btn_delete" data-id="<?php echo $_smarty_tpl->tpl_vars['case_category']->value['id_case_category'];?>
">削除</a>
						</td>
					</tr>
					<?php }
if (!$_smarty_tpl->tpl_vars["case_category"]->_loop) {
?>
					<tr>
						<td colspan="6"><?php echo $_smarty_tpl->tpl_vars['_CONTENTS_NAME']->value;?>
は見つかりません。</td>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10"><ul class="pagination pull-right">
							</ul></td>
					</tr>
				</tfoot>
			</table>
			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_pagenavi']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
