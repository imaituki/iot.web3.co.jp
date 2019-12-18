<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 18:20:16
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13268136405db139df84af50-54633059%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1573118411,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13268136405db139df84af50-54633059',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db139df8cbcd6_57324491',
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
<?php if ($_valid && !is_callable('content_5db139df8cbcd6_57324491')) {function content_5db139df8cbcd6_57324491($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="construction">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/construction/top.jpg" alt="施工"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">施工</span><span class="sub">Construction</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/">事業案内</a></li>
				<li>施工</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper-t center">
			<div class="service_box_up">
				<div class="photo pos_ac"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/construction/image1.jpg" alt="施工"></div>
				<div class="text center2">
					<h2 class="mincho cg">岡山県南の住宅基礎を<br>地盤改良で守り続けて25年</h2>
					<p>当社では、住宅をはじめとする建築物や土木構造物を施工する際の不同沈下対策である地盤改良工事を行っております。<br>
						25年の施工実績があり、現在8チーム、17名の地盤改良の熟練した職人が在籍し、岡山県南の地盤環境の安心・安全をお届けしております。</p>
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
/service/transport/">
							<div class="photo"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/foot2.jpg" alt="運搬・回送"></div>
							<div class="text">
								<div class="disp_td">
									<h4><i class="fas fa-caret-right cg"></i> 運搬・回送</h4>
								</div>
							</div>
						</a>
					</div>
				</div>
				<div class="col-xs-6">
					<div class="page_link">
						<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/system/">
							<div class="photo"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/foot3.jpg" alt="システム開発"></div>
							<div class="text">
								<div class="disp_td">
									<h4><i class="fas fa-caret-right cg"></i> システム開発</h4>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			<div class="pos_ac"><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/" class="button _type_2"><i class="arrow_cg2"></i>事業内容一覧へ</a></div>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
