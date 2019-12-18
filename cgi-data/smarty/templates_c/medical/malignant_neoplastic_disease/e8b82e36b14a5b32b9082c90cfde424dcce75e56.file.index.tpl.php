<?php /* Smarty version Smarty-3.1.18, created on 2019-09-27 20:59:12
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5011724355d8aeae97cf0e1-26807910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1569585445,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5011724355d8aeae97cf0e1-26807910',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d8aeae97f1477_05329162',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d8aeae97f1477_05329162')) {function content_5d8aeae97f1477_05329162($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="atopy" class="medical">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/medical/atopy/top.jpg" alt="腫瘍性疾患（悪性）"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">腫瘍性疾患（悪性）</span><span class="sub">malignant neoplastic disease</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li><a href="../">皮ふ科</a></li>
		<li>腫瘍性疾患（悪性）</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper-b center4">
			<h2 class="hl_1 mb30"><span class="cg mincho">詳しい症例で探す</span><span class="sub">find by case</span></h2>
			<div class="row">
				<div class="col-sm-3 col-xs-6">
					<div class="card_unit cg">
						<a href="/medical/malignant_neoplastic_disease/skin_cancer/" class="height-2" style="height: 287.361px;">
							<div class="photo"><img src="/common/image/contents/medical/dummy.jpg" alt="皮膚がん"></div>
							<div class="text height-1" style="height: 98.8889px;">
								<h3 class="cg">皮膚がん</h3>
								<p>テキストテキストテキストテキストテキストテキスト</p>
							</div>
							<div class="tag_area">
								<span class="tag">タグ</span>
								<span class="tag">タグ</span>
								<span class="tag">タグ</span>
							</div>
						</a>
					</div>
				</div>
				<div class="col-sm-3 col-xs-6">
					<div class="card_unit cg">
						<a href="/medical/malignant_neoplastic_disease/malignant_melanoma/" class="height-2" style="height: 287.361px;">
							<div class="photo"><img src="/common/image/contents/medical/dummy.jpg" alt="悪性黒色腫"></div>
							<div class="text height-1" style="height: 98.8889px;">
								<h3 class="cg">悪性黒色腫</h3>
								<p>テキストテキストテキストテキストテキストテキスト</p>
							</div>
							<div class="tag_area">
								<span class="tag">タグ</span>
								<span class="tag">タグ</span>
								<span class="tag">タグ</span>
							</div>
						</a>
					</div>
				</div>
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
