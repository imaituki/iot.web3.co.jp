<?php /* Smarty version Smarty-3.1.18, created on 2019-08-05 14:20:24
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19173538675d3559ee2f40d4-78488164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1564982127,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19173538675d3559ee2f40d4-78488164',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d3559ee30c3a4_71898735',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d3559ee30c3a4_71898735')) {function content_5d3559ee30c3a4_71898735($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="treatment">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="top_img">
		<div class="img_back"><img src="/common/image/contents/various_treatment/top.jpg" alt="診療・各種治療"></div>
		<div class="moji">
			<div class="center">
				<h2>診療・各種治療<span>medical treatment list</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu">
		<ul class="center">
			<li><a href="/">TOP</a></li>
			<li>診療・各種治療</li>
		</ul>
	</div>
	<section>
		<div class="wrapper-t center various_treatment">
			<h2 class="hl_1">診療・各種治療一覧<span class="sub">medical treatment list</span></h2>
			<div class="border">
				<h2 class="hl_1">皮膚</h2>
				<p>skin care</p>
			</div>
			<div class="link_list mb20">
				<ul>
					<li><a href="/treatment/atopy/">アトピー性皮膚炎<span>詳細を見る</span></a></li>
					<li><a href="/treatment/curly_nail/">巻き爪<span>詳細を見る</span></a></li>
					<li><a href="/treatment/insect_bites/">虫刺され<span>詳細を見る</span></a></li>
				</ul>
			</div>
			<div class="row">
				<div class="col-xs-6">
					<p class="link_list_sub">尋常性乾癬</p>
				</div>
				<div class="col-xs-6">
					<p class="link_list_sub">尋常性白斑</p>
				</div>
				<div class="col-xs-6">
					<p class="link_list_sub">水虫・爪水虫</p>
				</div>
				<div class="col-xs-6">
					<p class="link_list_sub">腫瘍</p>
				</div>
				<div class="col-xs-6">
					<p class="link_list_sub">ほくろ・イボ</p>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="wrapper-t center">
			<div class="border">
				<h2 class="hl_1">東洋医療</h2>
				<p class="pos_al">oriental medicine</p>
			</div>
			<div class="link_list">
				<ul>
					<li><a href="/treatment/oriental_medicine/">東洋医療<span>詳細を見る</span></a></li>
				</ul>
			</div>
	</section>
	<section>
		<div class="wrapper center">
			<div class="border">
				<h2 class="hl_1">各種検査</h2>
				<p class="pos_al">measurement</p>
			</div>
			<div class="link_list">
				<ul>
					<li><a href="/treatment/measurement/">遺伝子検査<span>詳細を見る</span></a></li>
					<li><a href="/treatment/measurement/#mineral">体内ミネラル測定<span>詳細を見る</span></a></li>
				</ul>
			</div>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
