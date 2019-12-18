<?php /* Smarty version Smarty-3.1.18, created on 2019-11-08 09:20:05
         compiled from "/virtual/119.245.151.134/home/admin/common/inc/secondary.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11309742935da959fcd761e3-27617180%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cab089643e06036cf496e3511cb4cb6232e01ee8' => 
    array (
      0 => '/virtual/119.245.151.134/home/admin/common/inc/secondary.tpl',
      1 => 1572939414,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11309742935da959fcd761e3-27617180',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5da959fce12520_96880604',
  'variables' => 
  array (
    'manage' => 0,
    '_ADMIN' => 0,
    'action' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5da959fce12520_96880604')) {function content_5da959fce12520_96880604($_smarty_tpl) {?><nav class="navbar-default navbar-static-side" role="navigation">
	<div class="sidebar-collapse">
		<ul class="nav metismenu" id="side-menu" style="padding-bottom:30px;">
			<li class="nav-header">
				
			</li>
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=='') {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/"><i class="fa fa-home"></i><span class="nav-label">HOME</span></a></li>
			<li <?php if ($_smarty_tpl->tpl_vars['action']->value=='information') {?>class="active"<?php }?>>
				<a href="#"><i class="fa fa-info-circle"></i><span class="nav-label">お知らせ管理</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li <?php if ($_smarty_tpl->tpl_vars['manage']->value=='information') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/information/">お知らせ一覧</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['manage']->value=='information_category') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/information_category/">お知らせカテゴリ一覧</a></li>
				</ul>
			</li>
			<li <?php if ($_smarty_tpl->tpl_vars['action']->value=='blog') {?>class="active"<?php }?>>
				<a href="#"><i class="fa fa-pencil" aria-hidden="true"></i><span class="nav-label">ブログ管理</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li <?php if ($_smarty_tpl->tpl_vars['manage']->value=='blog') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/blog/">ブログ一覧</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['manage']->value=='blog_category') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/blog_category/">ブログカテゴリ一覧</a></li>
				</ul>
			</li>
			<li <?php if ($_smarty_tpl->tpl_vars['action']->value=='case') {?>class="active"<?php }?>>
				<a href="#"><i class="fa fa-truck"></i><span class="nav-label">実績紹介管理</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li <?php if ($_smarty_tpl->tpl_vars['manage']->value=='case') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/case/">実績紹介一覧</a></li>
					<li <?php if ($_smarty_tpl->tpl_vars['manage']->value=='case_category') {?>class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/case_category/">実績紹介カテゴリ一覧</a></li>
				</ul>
			</li>
			<li<?php if ($_smarty_tpl->tpl_vars['manage']->value=="siteconf") {?> class="active"<?php }?>><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/contents/siteconf/"><i class="fa fa-gear"></i><span class="nav-label">サイト設定</span></a></li>
		</ul>
	</div>
</nav>
<?php }} ?>
