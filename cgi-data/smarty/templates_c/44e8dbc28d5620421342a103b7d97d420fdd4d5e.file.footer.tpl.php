<?php /* Smarty version Smarty-3.1.18, created on 2020-01-14 10:31:00
         compiled from "/data/domain/BB0B6DDA-20C6-11EA-8A14-AD6F0C460029/html/common/include/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3050488955e0e007b648567-32616972%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '44e8dbc28d5620421342a103b7d97d420fdd4d5e' => 
    array (
      0 => '/data/domain/BB0B6DDA-20C6-11EA-8A14-AD6F0C460029/html/common/include/footer.tpl',
      1 => 1578965333,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3050488955e0e007b648567-32616972',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5e0e007b6a8595_65099116',
  'variables' => 
  array (
    'mst_siteconf' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e0e007b6a8595_65099116')) {function content_5e0e007b6a8595_65099116($_smarty_tpl) {?><footer>
<div id="foot_contact" class="wrapper">
	<div class="center">
		<h3 class="hl_2 c0"><span class="main mincho">Contact</span><span class="sub">お問い合わせ・ご相談</span></h3>
		<p class="c0 mb20 pos_ac">IoTに関するご質問や、導入・業務提携に関するご相談等ございましたら、お気軽にお問い合わせください。</p>
		<div class="row radius_box">
			<div class="col-sm-6">
				<div class="height-1">
					<h4 class="hl_4 mincho bg_g1 c0">お電話でのお問い合わせ</h4>
					<div class="tel_unit">
						<div class="tel_wrap">
							<span class="tel mincho" data-tel="<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel'];?>
"><i class="fa fa-phone-alt"></i> <?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel'];?>
</span>
							<span class="times">受付時間　<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['worktime'];?>
</span>
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6 border_l">
				<div class="_last height-1">
					<div class="tel_unit">
						<div class="tel_wrap mb20">
							<a href="/contact/" class="button _circle bg_g1"><i class="fa fa-paper-plane"></i> お問い合わせフォーム</a>
						</div>
						<p class="small">お送りいただきましたお問い合わせには、後日折り返し返答させていただきます。お急ぎの場合は、お電話にてお問い合わせください。<br>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="foot" class="center">
	<div class="row">
		<div class="col-sm-6 height-1">
			<h5 class="site_logo"><a class="ov" href="/"><img src="https://placehold.jp/594x104.png?text=logo" alt="ウェブクリエイティブ株式会社"></a></h5>
			<address>〒<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['zip'];?>
 <?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['address'];?>
<br>
				TEL：<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['tel'];?>
　FAX：<?php echo $_smarty_tpl->tpl_vars['mst_siteconf']->value['fax'];?>
</address>
		</div>
		<div class="col-sm-6 height-1 disp_tbl">
			<div id="foot_navi" class="disp_td">
				<div class="row no-gutters">
					<div class="col-xs-6">
						<ul>
							<li><a href="/company/" class="fa_b">会社概要</a></li>
							<li><a href="/information/" class="fa_b">お知らせ</a></li>
							<li><a href="/flow/" class="fa_b">ご相談の流れ</a></li>
						</ul>
					</div>
					<div class="col-xs-6">
						<ul>
							<li><a href="/case/" class="fa_b">実績紹介</a></li>
							<li><a href="/partner/" class="fa_b">連携パートナー</a></li>
							<li><a href="/contact/" class="fa_b">お問い合わせ</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="copyright" class="bg_1">
	<div class="center">
		<div class="row">
			<div class="col-sm-6 col-sm-push-6">
				<div class="foot_sub_navi">
					<a href="/security/">情報セキュリティ基本方針</a>
					<a href="/privacy/">プライバシーポリシー</a>
				</div>
			</div>
			<div class="col-sm-6 col-sm-pull-6">&copy; Copyright 2020 ウェブクリエイティブ株式会社 All rights Reserved.</div>
		</div>
	</div>
</div>
<div id="foot_link">
	<a href="/contact/" class="request bg_g1"><span><i class="fa fa-paper-plane"></i>お問い合わせ</span></a>
</div>
<div id="pagetop"><a href="javascript:void(0);" class="fa fa-angle-up"><span>pagetop</span></a></div>
</footer>
<?php }} ?>
