<?php /* Smarty version Smarty-3.1.18, created on 2019-09-04 14:02:23
         compiled from "/home/jwcc/8071/html/admin/common/inc/secondary.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4320851895d08b671e0fe48-61712395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '851aaee9ae227cdbcdcb3cd4a84ade79c64356c8' => 
    array (
      0 => '/home/jwcc/8071/html/admin/common/inc/secondary.tpl',
      1 => 1564048353,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4320851895d08b671e0fe48-61712395',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d08b671e2f465_02162015',
  'variables' => 
  array (
    'manage' => 0,
    '_ADMIN' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d08b671e2f465_02162015')) {function content_5d08b671e2f465_02162015($_smarty_tpl) {?><nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu" style="padding-bottom:30px;">
			<li class="nav-header">
				
			</li>
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=='') {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/"><i class="fa fa-home"></i><span class="nav-label">HOME</span></a></li>
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=="information") {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/information/"><i class="fa fa-info-circle"></i><span class="nav-label">お知らせ管理</span></a></li>
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=="shopping") {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/shopping/"><i class="fa fa-shopping-cart"></i><span class="nav-label">商品</span></a></li>
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=="faq") {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/faq/"><i class="fa fa-question-circle"></i>Q&A</span></a></li>
			
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=="siteconf") {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/siteconf/"><i class="fa fa-gear"></i><span class="nav-label">サイト設定</span></a></li>
		</ul>
	</div>
</nav><?php }} ?>
