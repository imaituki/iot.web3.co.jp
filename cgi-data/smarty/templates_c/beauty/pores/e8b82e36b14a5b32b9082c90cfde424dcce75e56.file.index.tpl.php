<?php /* Smarty version Smarty-3.1.18, created on 2019-09-26 15:07:16
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8870410555d369c9d0faff1-95028262%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1569478034,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8870410555d369c9d0faff1-95028262',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d369c9d1139a9_22490453',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'OptionMenuList' => 0,
    'menu' => 0,
    'key' => 0,
    'tag' => 0,
    'OptionMenuTag' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d369c9d1139a9_22490453')) {function content_5d369c9d1139a9_22490453($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="pores" class="beauty">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/beauty/pores/top.jpg" alt="美容皮ふ科"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">毛穴の開き・たるみ・リフトアップ</span><span class="sub">pores care / liftup</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li><a href="../">美容皮ふ科治療</a></li>
		<li>毛穴の開き・たるみ・リフトアップ</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper-t center3" id="collagen">
			<h2 class="hl_1 mb30"><span class="cp mincho">グッとシャープに、小顔効果</span></h2>
			<p class="mb10">シワ・たるみの一つとして、加齢・紫外線の影響・ストレスなどによって、お肌の真皮層にあるコラーゲンなどが減少することが挙げられます。</p>
			<p>自己のコラーゲンを活性化させ、たるみや小ジワを改善させ、お肌のハリが甦り、肌が元気になる施術を行っております。特に赤外線とRFを組み合わせた治療は、安全性と効果が立証されており、現在世界各国で注目されています。</p>
		</div>
	</section>
	<section>
		<div class="wrapper">
			<div class="center4">
				<h2 class="hl_1 mb30"><span class="cp mincho">施術方法から探す</span><span class="sub">menu list</span></h2>
				<div class="row">
<?php if ($_smarty_tpl->tpl_vars['OptionMenuList']->value) {?>
<?php  $_smarty_tpl->tpl_vars["menu"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["menu"]->_loop = false;
 $_smarty_tpl->tpl_vars["key"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['OptionMenuList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["menu"]->key => $_smarty_tpl->tpl_vars["menu"]->value) {
$_smarty_tpl->tpl_vars["menu"]->_loop = true;
 $_smarty_tpl->tpl_vars["key"]->value = $_smarty_tpl->tpl_vars["menu"]->key;
?>
				<div class="col-sm-3 col-xs-6">
					<div class="card_unit cp">
						<a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['url'];?>
" class="height-2">
							<div class="photo"><img src="/common/image/contents/beauty/menu<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
"></div>
							<div class="text height-1">
								<h3 class="cp"><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</h3>
								<p><?php echo $_smarty_tpl->tpl_vars['menu']->value['comment'];?>
</p>
							</div>
							<div class="tag_area">
							<?php  $_smarty_tpl->tpl_vars["tag"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["tag"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['tag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["tag"]->key => $_smarty_tpl->tpl_vars["tag"]->value) {
$_smarty_tpl->tpl_vars["tag"]->_loop = true;
?>
								<span class="tag"><?php echo $_smarty_tpl->tpl_vars['OptionMenuTag']->value[$_smarty_tpl->tpl_vars['tag']->value];?>
</span>
							<?php } ?>
							</div>
						</a>
					</div>
				</div>
<?php } ?>
<?php }?>
				<div class="col-sm-3 col-xs-6">
					<div class="card_unit cp">
						<a href="/beauty/triniti/#sublime" class="height-2" style="height: 287.361px;">
							<div class="photo"><img src="/common/image/contents/beauty/menu14.jpg" alt="サブライム"></div>
							<div class="text height-1" style="height: 98.8889px;">
								<h3 class="cp">Sublime</h3>
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
					<div class="card_unit cp">
						<a href="/beauty/triniti/#motif" class="height-2" style="height: 287.361px;">
							<div class="photo"><img src="/common/image/contents/beauty/menu1.jpg" alt="Mortif IR"></div>
							<div class="text height-1" style="height: 98.8889px;">
								<h3 class="cp">Mortif IR</h3>
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
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
