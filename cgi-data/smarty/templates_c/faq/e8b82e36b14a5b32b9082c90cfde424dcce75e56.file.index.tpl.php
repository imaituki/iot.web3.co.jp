<?php /* Smarty version Smarty-3.1.18, created on 2019-09-12 19:05:58
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9608496475d353b5797be73-67968935%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1568282751,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9608496475d353b5797be73-67968935',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d353b57991dd5_74699578',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    't_faq' => 0,
    'faq' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d353b57991dd5_74699578')) {function content_5d353b57991dd5_74699578($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="faq">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/faq/top.jpg" alt="よくあるご質問"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">よくあるご質問</span><span class="sub">Faq</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li>よくあるご質問</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper center4">
<?php  $_smarty_tpl->tpl_vars['faq'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['faq']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['t_faq']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['faq']->key => $_smarty_tpl->tpl_vars['faq']->value) {
$_smarty_tpl->tpl_vars['faq']->_loop = true;
?>
			<div class="faq_unit">
				<h2 class="title"><span class="maru _q">Q</span><?php echo $_smarty_tpl->tpl_vars['faq']->value['title'];?>
</h2>
				<div class="answer bg_yo">
					<span class="maru _a">A</span>
					<div class="text"><?php echo $_smarty_tpl->tpl_vars['faq']->value['comment'];?>
</div>
				</div>
			</div>
<?php } ?>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
