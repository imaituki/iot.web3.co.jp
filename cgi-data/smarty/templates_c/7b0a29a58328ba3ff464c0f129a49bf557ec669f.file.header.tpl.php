<?php /* Smarty version Smarty-3.1.18, created on 2020-01-19 23:30:35
         compiled from "/data/domain/BB0B6DDA-20C6-11EA-8A14-AD6F0C460029/html/common/include/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5092159645e0e007b6078a2-34130701%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b0a29a58328ba3ff464c0f129a49bf557ec669f' => 
    array (
      0 => '/data/domain/BB0B6DDA-20C6-11EA-8A14-AD6F0C460029/html/common/include/header.tpl',
      1 => 1579444211,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5092159645e0e007b6078a2-34130701',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5e0e007b643579_02934033',
  'variables' => 
  array (
    'mst_siteconf' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e0e007b643579_02934033')) {function content_5e0e007b643579_02934033($_smarty_tpl) {?><div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v4.0"></script>
<header>
<div id="head">
	<div class="center">
		<h1 class="site_logo"><a class="ov" href="/"><img src="https://placehold.jp/594x104.png?text=岡山IoTコンソーシアムみんなのIoT" alt="ウェブクリエイティブ株式会社"></a></h1>
		<div id="head_navi">
			<ul>
				<li class=""><a href="/information/">お知らせ</a></li>
				<li class=""><a href="/flow/">ご相談の流れ</a></li>
				<li class=""><a href="/case/">実績紹介</a></li>
				<li class=""><a href="/partner/">連携パートナー</a></li>
				<li class="head_contact">
					<span class="tel" data-tel="<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel2'];?>
"><i class="fa fa-phone-alt"></i> <?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel'];?>
<span class="visible-only click"><i class="fa fa-hand-point-up"></i> CLICK</span></span>
					<a href="/contact/" class="button _circle bg_or"><i class="fa fa-paper-plane"></i> お問い合わせ</a>
				</li>
			</ul>
		</div>
		<div id="btn_open"><a href="javascript:void(0);"><i class="fa fa-bars"></i></a></div>
	</div>
</div>
</header>
<?php }} ?>
