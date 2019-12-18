<?php /* Smarty version Smarty-3.1.18, created on 2019-10-30 20:12:20
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7051213925db247c4886d47-74614582%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1572433939,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7051213925db247c4886d47-74614582',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db247c4920b32_89046701',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'mst_siteconf' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db247c4920b32_89046701')) {function content_5db247c4920b32_89046701($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/js/lightbox/import.js"></script>
</head>
<body id="new_customer">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/company/new_customer/top.jpg" alt="初めてのお客様へ"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">初めてのお客様へ</span><span class="sub">To customers</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/company/">会社案内</a></li>
				<li>初めてのお客様へ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper-t center">
			<h2 class="hl_1 mincho"><span class="cg">初めてのお客様へ</span></h2>
			<p class="mb30">初めまして。岡山県岡山市で運送業を行っている「株式会社 親幸産業」です。
				弊社は、7t積み移動式クレーン車（ユニック）と７トン積み重機回送車を多数保有しております。
				4トン車の増トン車ですのでコンパクトな車両で、道幅の狭い場所の重機運搬なども対応が可能です。</p>
			<div class="button _type_2"><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/#vehicles">保有車両を見る<i class="arrow_cg"></i></a></div>
		</div>
	</section>
	<section>
		<div class="wrapper-t center">
			<h2 class="hl_1 mincho"><span class="cg">親幸産業の特徴</span></h2>
			<p>地元での取引先は建設機械のリース会社様が多いため建設機械運搬,回送を得意としております。<br><br>
			更に、移動式クレーン車を必要とするセメントの運搬や鋼材,石材など比重が高く重い物を住宅地など狭小地への運搬も多く行なっております。<br>
			４トンダンプ車のセルフローダー車も5台程度ございますのでかなり道路の狭い現場への重機の運搬も可能です。<br>
			もちろん、重機だけではなく、様々なお荷物を西日本を中心「安全・確実・親切丁寧」をモットーに配送を行っております。<br>
			このページをご覧いただいたことをご縁に、お気軽に是非、一度お問い合わせ頂きたいと思います。</p>
		</div>
	</section>
	<section>
		<div id="foot_info" class="wrapper-t center">
			<div class="cg_box  mb30">
				<div class="row">
					<div class="col-xs-6 text height-1">
						<p>お電話やメールでの<br />お申し込みはこちら</p>
					</div>
					<div class="col-xs-6 info height-1">
						<div class="tel flex mb20">
							<p><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/tel.jpg" alt="電話番号"></p>
							<p><?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel2'];?>
</p>
						</div>
						<div class="mail flex">
							<p class="flex"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/mail.jpg" alt="メール"></p>
							<p><a href="mailto:<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['mail2'];?>
"><?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['mail2'];?>
</a></p>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-6 mb20">
					<div class="tel_wrap">
						<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/contact/" class="button _circle bg_gg"><i class="fa fa-paper-plane"></i> お問い合わせフォーム</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="tel_wrap">
						<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/estimate/" class="button _circle bg_gg"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/estimate.png" alt="お見積り" style="margin-right: 5px;">お見積もりフォーム</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="wrapper center foot_navi">
			<h2 class="hl_1 mincho"><span class="cg">事業内容</span></h2>
			<div class="row mb50">
				<div class="col-xs-6">
					<div class="page_link">
						<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/company/">
							<div class="photo"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/company/foot1.jpg" alt="会社案内"></div>
							<div class="text">
								<div class="disp_td">
									<h4><i class="fas fa-caret-right cg"></i>会社案内</h4>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="page_link">
						<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/company/cooperative_company/">
							<div class="photo"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/company/foot3.jpg" alt="協力会社募集"></div>
							<div class="text">
								<div class="disp_td">
									<h4><i class="fas fa-caret-right cg"></i>協力会社募集</h4>
								</div>
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
