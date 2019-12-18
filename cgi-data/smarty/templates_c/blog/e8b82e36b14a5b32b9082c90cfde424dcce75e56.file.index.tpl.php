<?php /* Smarty version Smarty-3.1.18, created on 2019-11-06 18:35:45
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12647991965db6543d265c16-23677396%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1572954428,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12647991965db6543d265c16-23677396',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db6543d358f43_38203307',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    't_blog' => 0,
    'blog' => 0,
    'arr_get' => 0,
    'OptionBlogCategory' => 0,
    'page_navi' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db6543d358f43_38203307')) {function content_5db6543d358f43_38203307($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="blog">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/form_top.jpg" alt="ブログ"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">ブログ</span><span class="sub">Blog</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>ブログ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center">
			<?php  $_smarty_tpl->tpl_vars["blog"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["blog"]->_loop = false;
 $_smarty_tpl->tpl_vars["key"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['t_blog']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["blog"]->key => $_smarty_tpl->tpl_vars["blog"]->value) {
$_smarty_tpl->tpl_vars["blog"]->_loop = true;
 $_smarty_tpl->tpl_vars["key"]->value = $_smarty_tpl->tpl_vars["blog"]->key;
?>
			<div class="info_box">
				<a class="ov" href="./detail.php?id=<?php echo $_smarty_tpl->tpl_vars['blog']->value['id_blog'];?>
<?php if ($_smarty_tpl->tpl_vars['arr_get']->value['page']!=null) {?>&page=<?php echo $_smarty_tpl->tpl_vars['arr_get']->value['page'];?>
<?php }?>">
					<div class="photo img_rect">
						<img src="<?php if ($_smarty_tpl->tpl_vars['blog']->value['image1']) {?><?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/blog/image1/m_<?php echo $_smarty_tpl->tpl_vars['blog']->value['image1'];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/null.jpg<?php }?>" alt="<?php echo $_smarty_tpl->tpl_vars['blog']->value['title'];?>
">
					</div>
					<div class="text">
						<div class="disp_td">
							<p class="mb10">
								<span class="date cg2"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['blog']->value['date'],"%Y/%m/%d");?>
</span>
								<span class="tag _c1"><?php echo $_smarty_tpl->tpl_vars['OptionBlogCategory']->value[$_smarty_tpl->tpl_vars['blog']->value['blog_category']];?>
</span></p>
							<h3><?php echo $_smarty_tpl->tpl_vars['blog']->value['title'];?>
</h3>
						</div>
					</div>
				</a>
			</div>
			<?php }
if (!$_smarty_tpl->tpl_vars["blog"]->_loop) {
?>
			<div class="pos_ac">ブログはありません。</div>
			<?php } ?>
			<?php if ($_smarty_tpl->tpl_vars['page_navi']->value['LinkPage']) {?>
			<div class="list_pager">
				<ul class="mt10">
					<?php echo $_smarty_tpl->tpl_vars['page_navi']->value['LinkPage'];?>

				</ul>
			</div>
			<?php }?>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
