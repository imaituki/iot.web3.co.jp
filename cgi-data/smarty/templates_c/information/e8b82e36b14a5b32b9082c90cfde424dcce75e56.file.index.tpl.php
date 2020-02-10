<?php /* Smarty version Smarty-3.1.18, created on 2020-01-30 10:38:28
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13601204805d31857c601d19-75819137%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1580348306,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13601204805d31857c601d19-75819137',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d31857c650ea9_47437403',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    't_information' => 0,
    'information' => 0,
    'arr_get' => 0,
    'OptionInformationCategory' => 0,
    'page_navi' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d31857c650ea9_47437403')) {function content_5d31857c650ea9_47437403($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/data/domain/BB0B6DDA-20C6-11EA-8A14-AD6F0C460029/cgi-data/smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="information">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="/common/image/contents/form_top.jpg" alt="お知らせ"></div>
		<div class="page_title_wrap">
			<div class="center mincho c2">
				<h2><span class="main">お知らせ</span><span class="sub">Information</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu">
		<div class="center">
			<ul>
				<li><a href="/"><i class="fa fa-home"></i></a></li>
				<li>お知らせ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center">
			<?php  $_smarty_tpl->tpl_vars["information"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["information"]->_loop = false;
 $_smarty_tpl->tpl_vars["key"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['t_information']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["information"]->key => $_smarty_tpl->tpl_vars["information"]->value) {
$_smarty_tpl->tpl_vars["information"]->_loop = true;
 $_smarty_tpl->tpl_vars["key"]->value = $_smarty_tpl->tpl_vars["information"]->key;
?>
			<div class="info_box">
				<a class="ov" href="./detail.php?id=<?php echo $_smarty_tpl->tpl_vars['information']->value['id_information'];?>
<?php if ($_smarty_tpl->tpl_vars['arr_get']->value['page']!=null) {?>&page=<?php echo $_smarty_tpl->tpl_vars['arr_get']->value['page'];?>
<?php }?>">
					<div class="photo img_rect">
						<img src="<?php if ($_smarty_tpl->tpl_vars['information']->value['image1']) {?>/common/photo/information/image1/m_<?php echo $_smarty_tpl->tpl_vars['information']->value['image1'];?>
<?php } else { ?>http://placehold.jp/ccc/66a5ad/600x450.png?text=null<?php }?>" alt="<?php echo $_smarty_tpl->tpl_vars['information']->value['title'];?>
">
					</div>
					<div class="text">
						<div class="disp_td">
							<p class="mb10">
								<span class="date c1"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['information']->value['date'],"%Y/%m/%d");?>
</span>
								<span class="tag c1"><?php echo $_smarty_tpl->tpl_vars['OptionInformationCategory']->value[$_smarty_tpl->tpl_vars['information']->value['id_information_category']];?>
</span></p>
							<h3><?php echo $_smarty_tpl->tpl_vars['information']->value['title'];?>
</h3>
						</div>
					</div>
				</a>
			</div>
			<?php }
if (!$_smarty_tpl->tpl_vars["information"]->_loop) {
?>
			<div class="pos_ac">お知らせはありません。</div>
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
