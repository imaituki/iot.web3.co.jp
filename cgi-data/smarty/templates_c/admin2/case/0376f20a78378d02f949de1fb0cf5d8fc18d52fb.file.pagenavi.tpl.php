<?php /* Smarty version Smarty-3.1.18, created on 2019-10-25 14:14:54
         compiled from "/virtual/119.245.151.134/home/admin/common/inc/pagenavi.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12325336165db284ce23b7e0-47712157%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0376f20a78378d02f949de1fb0cf5d8fc18d52fb' => 
    array (
      0 => '/virtual/119.245.151.134/home/admin/common/inc/pagenavi.tpl',
      1 => 1571378697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12325336165db284ce23b7e0-47712157',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'page_navi' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db284ce2b9280_84094793',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db284ce2b9280_84094793')) {function content_5db284ce2b9280_84094793($_smarty_tpl) {?><?php if ((($tmp = @$_smarty_tpl->tpl_vars['page_navi']->value['PageTotal'])===null||$tmp==='' ? 0 : $tmp)>1) {?>
<div class="page_navi mb20">
	<?php echo number_format($_smarty_tpl->tpl_vars['page_navi']->value['PageItemTotal']);?>
件中<?php echo number_format($_smarty_tpl->tpl_vars['page_navi']->value['PageShowStart']);?>
_<?php echo number_format($_smarty_tpl->tpl_vars['page_navi']->value['PageShowEnd']);?>
件目 ：
	<?php echo (($tmp = @$_smarty_tpl->tpl_vars['page_navi']->value['LinkBack'])===null||$tmp==='' ? '' : $tmp);?>
 <?php echo (($tmp = @$_smarty_tpl->tpl_vars['page_navi']->value['LinkPage'])===null||$tmp==='' ? '' : $tmp);?>
 <?php echo (($tmp = @$_smarty_tpl->tpl_vars['page_navi']->value['LinkNext'])===null||$tmp==='' ? '' : $tmp);?>

</div>
<?php }?><?php }} ?>
