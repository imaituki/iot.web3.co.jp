<?php /* Smarty version Smarty-3.1.18, created on 2019-09-20 16:46:57
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15923239635d84830f9bb7b0-98422571%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1568965607,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15923239635d84830f9bb7b0-98422571',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d84830f9db472_88150219',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d84830f9db472_88150219')) {function content_5d84830f9db472_88150219($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="acne" class="beauty">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/beauty/acne/top.jpg" alt="美容皮ふ科"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">ケミカルピーリング</span><span class="sub">chemical peeling/span></h2>
		</div>
	</div>
</div>
<div id="body">
	<section>
		<div class="wrapper bg_po" id="peeling">
			<div class="center">
				<h2 class="hl_1 mb30"><span class="cp mincho">ケミカルピーリング</span><span class="sub">chemical peeling</span></h2>
				<div class="row">
					<div class="col-xs-5">
						<p class="mb30"><img src="/common/image/contents/beauty/acne/image2.jpg" alt="ケミカルピーリング"></p>
					</div>
					<div class="col-xs-7">
						<h3 class="hl_4 mincho c2">みずみずしく、張りのある、<br>美しいお肌に生まれ変わります。</h3>
						<p class="mb10">ケミカルピーリングとは、果実からとれたフルーツ酸を使用し、みずみずしく透き通ったお肌をよみがえらせる治療法です。フルーツ酸はお肌に浸透しやすく、コラーゲンの合成や促進、美白といった効果があるため、ニキビ跡だけではなく、くすみ、にきび、しみ、こじわにとても効果的です。</p>
						<p class="mb10">医療機関用にpH調整をした適量のフルーツ酸をお肌の状態を診ながら数分間、塗布することにより、もっとも安心、確実な方法でお肌の角質除去ができます。施術時間は1回につき約45分程度です。</p>
						<p class="mb30">治療後は、徐々にフルーツ酸の濃度を上げていきます。1～2週間に1度のペースで合計7～8回を目安としてください。この回数は、あくまで満足な効果を得られるための目安です。当院では、次回のピーリングを受けていただくかどうかを、毎回、患者さんご自身で決めていただいております。</p>
						<div class="box bg0 _bg_po">
							<h3 class="title"><span class="bg_p">料金</span></h3>
							<table class="tbl_charge cp mb10">
								<thead>
									<tr>
										<th><span class="th">施術名</span></th>
										<th><span class="th">通常1回</span></th>
										<th><span class="th">9回目以降</span></th>
										<th><span class="th">割引</span></th>
									</tr>
								</thead>
								<tbody>
									<?php echo $_smarty_tpl->getSubTemplate ("./../../../charge/tmp_beauty_peeling.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

								</tbody>
							</table>
							<p class="pos_ar c_gray">（消費税込）</p>
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
