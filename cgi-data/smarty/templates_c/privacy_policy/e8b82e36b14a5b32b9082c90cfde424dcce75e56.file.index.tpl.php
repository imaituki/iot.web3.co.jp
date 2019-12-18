<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 11:14:00
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5275236845db28d7d046c01-42556994%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1572953980,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5275236845db28d7d046c01-42556994',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db28d7d0c7a56_91001015',
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
<?php if ($_valid && !is_callable('content_5db28d7d0c7a56_91001015')) {function content_5db28d7d0c7a56_91001015($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="privacy">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/form_top.jpg" alt="プライバシーポリシー"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">プライバシーポリシー</span><span class="sub">Privacy Policy</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>プライバシーポリシー</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center privacy">
			<p class="mb50">ウェブクリエイティブ株式会社（以下、「当社」）は、提供するサービス（以下、「本サービス」）における個人情報の取扱いについて、以下のとおりプライバシーポリシー（以下、「本ポリシー」）を定めます。</p>
			<h3 class="box_title cg mincho fw_bold">第一条　個人情報の管理</h3>
			<p class="mb50">当社は、お客様の個人情報を正確かつ最新の状態に保ち、個人情報への不正アクセス・紛失・破損・改ざん・漏洩などを防止するため、セキュリティシステムの維持・管理体制の整備・社員教育の徹底等の必要な措置を講じ、安全対策を実施し個人情報の厳重な管理を行ないます。</p>
			<h3 class="box_title cg mincho fw_bold">第二条　個人情報の利用目的</h3>
			<p class="mb50">お客様からお預かりした個人情報は、当社からのご連絡や業務のご案内やご質問に対する回答として、電子メールや資料のご送付に利用いたします。</p>
			<h3 class="box_title cg mincho fw_bold">第三条　個人情報の第三者への開示・提供の禁止</h3>
			<p class="mb50">当社は、お客様よりお預かりした個人情報を適切に管理し、次のいずれかに該当する場合を除き、個人情報を第三者に開示いたしません。</p>
			<h3 class="box_title cg mincho fw_bold">第四条　個人情報の安全対策</h3>
			<p class="mb50">当社は、個人情報の正確性及び安全性確保のために、セキュリティに万全の対策を講じています。</p>
			<h3 class="box_title cg mincho fw_bold">第五条　ご本人の照会</h3>
			<p class="mb50">お客様がご本人の個人情報の照会・修正・削除などをご希望される場合には、ご本人であることを確認の上、対応させていただきます。</p>
			<h3 class="box_title cg mincho fw_bold">第六条　法令、規範の遵守と見直し</h3>
			<p class="mb50">当社は、保有する個人情報に関して適用される日本の法令、その他規範を遵守するとともに、本ポリシーの内容を適宜見直し、その改善に努めます。</p>
			<h3 class="box_title cg mincho fw_bold">第七条　お問い合わせ</h3>
			<p class="mb10">当社の個人情報の取扱に関するお問い合せは下記までご連絡ください。</p>
			<p class="mb50"><?php echo nl2br($_smarty_tpl->tpl_vars['mst_siteconf']->value['company']);?>
<br />
				〒<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['zip'];?>
 <?php echo nl2br($_smarty_tpl->tpl_vars['mst_siteconf']->value['address']);?>
<br />
				TEL：<span class="tel" data-tel="<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel1'];?>
"><?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel1'];?>
</span>　FAX：<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['fax'];?>
<br>
				E-mail：<a href="mailto:<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['mail1'];?>
"><?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['mail1'];?>
</a>
			</p>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
