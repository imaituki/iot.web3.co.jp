<?php /* Smarty version Smarty-3.1.18, created on 2019-07-30 17:43:47
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9660834775d301b2c3d5836-03510575%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1564476226,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9660834775d301b2c3d5836-03510575',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d301b2c3eb610_71958154',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d301b2c3eb610_71958154')) {function content_5d301b2c3eb610_71958154($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="doctor">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="top_img">
		<div class="img_back"><img src="/common/image/contents/introduction/top.jpg" alt="医師紹介"></div>
		<div class="moji">
			<div class="center">
				<h2>医師紹介<span>doctor</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu">
		<ul class="center">
			<li><a href="/">TOP</a></li>
			<li>医師紹介</li>
		</ul>
	</div>
	<section>
		<div class="wrapper-b introduction">
			<div class="name_box mb20">
				<div class="img_back"><img src="/common/image/contents/introduction/1.jpg" alt="院長"></div>
				<div class="center">
					<h2 class="name mincho c1"><span>院長（医学博士）</span>松井 浩明</h2>
				</div>
			</div>
			<div class="center p30">
				<div class="row">
					<div class="col-sm-6">
						<p class="mb30"><img src="/common/image/contents/introduction/ishi1.jpg" alt="院長"></p>
					</div>
					<div class="col-sm-6">
						<p class="c1 large mb30">医学博士 / 皮膚科専門医 / 東洋医学専門医 /<br class="hidden-only">
							介護支援専門医 / 岡山市医師会 副会長 /<br class="hidden-only">
							岡山大学医学部臨床教授 / 吉備国際大学客員教授 /<br class="hidden-only">
							日本東洋医学学会岡山県部会理事</p>
						<div class="border mb20">
							<h2 class="hl_1">略歴</h2>
						</div>
						<table class="tbl_doctor">
							<tbody>
								<tr>
									<th>昭和60年</th>
									<td>川崎医科大学医学部卒業</td>
								</tr>
								<tr>
									<th>昭和60年～平成2年</th>
									<td>川崎医科大学付属病院皮膚科</td>
								</tr>
								<tr>
									<th>平成2年～平成3年</th>
									<td>水島中央病院皮膚科医長</td>
								</tr>
								<tr>
									<th>平成3年</th>
									<td>岡山市のまつい皮ふ科を開院</td>
								</tr>
								<tr>
									<th>平成25年</th>
									<td>岡山市医師会　副会長就任</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="wrapper-b introduction">
			<div class="name_box mb20">
				<div class="img_back"><img src="/common/image/contents/introduction/2.jpg" alt="芝田 晴子"></div>
				<div class="center">
					<h2 class="name mincho c1"><span>医師</span>芝田 晴子</h2>
				</div>
			</div>
			<div class="center p30">
				<div class="row">
					<div class="col-sm-6 col-sm-push-6">
						<p class="mb30"><img src="/common/image/contents/introduction/ishi2.jpg" alt="医師"></p>
					</div>
					<div class="col-sm-6 col-sm-pull-6">
						<div class="border mb20">
							<h2 class="hl_1">略歴</h2>
						</div>
						<table class="tbl_doctor mb20">
							<tbody>
								<tr>
									<th>平成21年</th>
									<td>香川大学卒業</td>
								</tr>
								<tr>
									<th>平成21年</th>
									<td>岡山大学病院勤務</td>
								</tr>
								<tr>
									<th>平成23年</th>
									<td>川崎病院勤務</td>
								</tr>
								<tr>
									<th>平成25年</th>
									<td>勤務</td>
								</tr>
								<tr>
									<th>平成26年</th>
									<td>津山中央病院勤務</td>
								</tr>
							</tbody>
						</table>
						<p>※芝田医師は土曜午前のみの診療です。</p>
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
