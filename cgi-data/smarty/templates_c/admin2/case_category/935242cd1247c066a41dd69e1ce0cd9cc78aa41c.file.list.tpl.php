<?php /* Smarty version Smarty-3.1.18, created on 2019-11-01 10:15:32
         compiled from "/virtual/119.245.151.134/home/admin/contents/case_category/template/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14990705855db285e0d2e568-76597803%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '935242cd1247c066a41dd69e1ce0cd9cc78aa41c' => 
    array (
      0 => '/virtual/119.245.151.134/home/admin/contents/case_category/template/list.tpl',
      1 => 1572570931,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14990705855db285e0d2e568-76597803',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db285e0de7000_26925772',
  'variables' => 
  array (
    'template_pagenavi' => 0,
    't_case_category' => 0,
    'case_category' => 0,
    'arr_post' => 0,
    '_ARR_IMAGE' => 0,
    'file' => 0,
    '_IMAGEFULLPATH' => 0,
    '_CONTENTS_DIR' => 0,
    '_CONTENTS_NAME' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db285e0de7000_26925772')) {function content_5db285e0de7000_26925772($_smarty_tpl) {?>
<script type="text/javascript">
sortableInit();
</script>

			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_pagenavi']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

			<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15" id="sortable-table">
				<thead>
					<tr>
						<th></th>
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
					<tr id="<?php echo $_smarty_tpl->tpl_vars['case_category']->value['id_case_category'];?>
">
						<td class="move_i"><?php if ((($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['mode'])===null||$tmp==='' ? '' : $tmp)=="search") {?><?php } else { ?><i class="fa fa-sort"><span></span></i><?php }?></td>
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
