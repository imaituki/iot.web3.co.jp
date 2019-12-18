<?php /* Smarty version Smarty-3.1.18, created on 2019-11-08 11:25:32
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12502666745db10567da04c7-78737018%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1573179931,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12502666745db10567da04c7-78737018',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db10567e2d178_03609945',
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
<?php if ($_valid && !is_callable('content_5db10567e2d178_03609945')) {function content_5db10567e2d178_03609945($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="service">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/top.jpg" alt="事業案内"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">事業案内</span><span class="sub">Service</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>事業案内</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center">
			<div class="box service_unit">
				<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/construction/" class="ov">
					<div class="row no-gutters">
						<div class="col-xs-7">
							<div class="photo height-1"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/service1.jpg" alt="施工"></div>
						</div>
						<div class="col-xs-5">
							<div class="text height-1">
								<div class="disp_td">
									<h2 class="mincho"><span class="cg">施工</span><span class="sub">Construction</span></h2>
									<p class="cg mincho">岡山県南の住宅基礎を地盤改良で守り続けて25年。</p>
									<div class="button _type_1"><span>詳しく見る<i class="arrow"></i></span></div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box service_unit">
				<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/transport/" class="ov">
					<div class="row no-gutters">
						<div class="col-xs-7 col-xs-push-5">
							<div class="photo height-1"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/service2.jpg" alt="運搬・回送"></div>
						</div>
						<div class="col-xs-5 col-xs-pull-7">
							<div class="text _right height-1">
								<div class="disp_td">
									<h2 class="mincho"><span class="cg">運搬・回送</span><span class="sub">Transportation</span></h2>
									<p class="cg mincho">ユニック車・セルフ車で建設現場の輸送を支えています。</p>
									<div class="button _type_1"><span>詳しく見る<i class="arrow"></i></span></div>
								</div>
							</div>
						</div>
					</div>
				</a>
			</div>
			<div class="box service_unit">
				<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/service/system/" class="ov">
					<div class="row no-gutters">
						<div class="col-xs-7">
							<div class="photo height-1"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/service3.jpg" alt="システム開発"></div>
						</div>
						<div class="col-xs-5">
							<div class="text height-1">
								<div class="disp_td">
									<h2 class="mincho"><span class="cg">システム開発</span><span class="sub">System</span></h2>
									<p class="cg mincho">業務効率化とお客様の利便性向上につながるシステムを開発します。</p>
									<div class="button _type_1"><span>詳しく見る<i class="arrow"></i></span></div>
								</div>
							</div>
						</div>
					</div>
				</a>
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
