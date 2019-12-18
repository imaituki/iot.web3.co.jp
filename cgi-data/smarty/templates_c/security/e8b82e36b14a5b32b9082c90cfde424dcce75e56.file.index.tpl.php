<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 11:12:46
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12230355025db2b64c3117f6-79151481%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1572953933,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12230355025db2b64c3117f6-79151481',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db2b64c38a506_00148310',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db2b64c38a506_00148310')) {function content_5db2b64c38a506_00148310($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="security">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/form_top.jpg" alt="情報セキュリティ基本方針"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">情報セキュリティ基本方針</span><span class="sub">Security policy</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>情報セキュリティ基本方針</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center security">
			<p class="mb50">株式会社親幸産業（以下、「当社」）は、事業活動を展開するうえで、情報セキュリティの確保は重要課題のひとつであると考え、当社の情報資産を保護する指針として、情報セキュリティ基本方針を策定し、これを以下の通り実施し推進します。</p>
			<h3 class="box_title cg mincho fw_bold">1.情報資産の保護</h3>
				<p class="mb50">情報資産への不正アクセス、情報資産の紛失、漏洩、改ざん及び破壊などの予防並びに是正に適切な措置を講じます。</p>
			<h3 class="box_title cg mincho fw_bold">2.法令等の遵守</h3>
				<p class="mb50">情報セキュリティに関する法令及びその他の規範を遵守します。</p>
			<h3 class="box_title cg mincho fw_bold">3.教育、研修の実施</h3>
				<p class="mb50">当社の情報資産を取り扱う全ての者に対し、情報セキュリティの重要性を認識させて、適正な利用を行うよう周知徹底を図ります。</p>
			<h3 class="box_title cg mincho fw_bold">4.継続的な改善</h3>
				<p class="mb100">「情報セキュリティ基本方針」および関連する諸規則、管理体制の評価と見直しを定期的に行い、情報セキュリティの継続的な改善周知を行っていきます。</p>
			<p class="pos_ar">策定：2017年4月20日<br>
				改訂：2019年6月20日<br>
				株式会社親幸産業<br>
				代表取締役　藤井 忠広</p>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
