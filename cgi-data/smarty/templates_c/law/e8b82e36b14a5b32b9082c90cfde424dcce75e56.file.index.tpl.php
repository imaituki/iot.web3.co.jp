<?php /* Smarty version Smarty-3.1.18, created on 2019-10-02 12:21:51
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10348076575d352b0472ced4-56850010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1569986502,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10348076575d352b0472ced4-56850010',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d352b04745dc0_16126487',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    '_INFO' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d352b04745dc0_16126487')) {function content_5d352b04745dc0_16126487($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="law">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/law/top.jpg" alt="特定商取引に基づく表記"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">特定商取引に基づく表記</span><span class="sub">Notation based on the Specified Commercial Transaction Act</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li>特定商取引に基づく表記</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper-t center4">
			<h3 class="hl_2">販売者情報</h3>
			<table class="tbl_1">
				<tbody>
					<tr>
						<th><span class="th">販売事業者</span></th>
						<td><?php echo $_smarty_tpl->tpl_vars['_INFO']->value['company'];?>
</td>
					</tr>
					<tr>
						<th><span class="th">運営責任者</span></th>
						<td>松井 浩明</td>
					</tr>
					<tr>
						<th><span class="th">所在地</span></th>
						<td>〒<?php echo $_smarty_tpl->tpl_vars['_INFO']->value['zip'];?>
 <?php echo $_smarty_tpl->tpl_vars['_INFO']->value['address'];?>
</td>
					</tr>
					<tr>
						<th><span class="th">連絡先</span></th>
						<td>TEL：<span class="tel" data-tel="<?php echo $_smarty_tpl->tpl_vars['_INFO']->value['tel'];?>
"><?php echo $_smarty_tpl->tpl_vars['_INFO']->value['tel'];?>
</span>　FAX：<?php echo $_smarty_tpl->tpl_vars['_INFO']->value['fax'];?>
<br>
							E-mail：info●matsui-clinic.com（●を＠に変更してお送りください）</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
	<section>
		<div class="wrapper-t center4">
			<h3 class="hl_2">お支払いと発送について</h3>
			<table class="tbl_1">
				<tbody>
					<tr>
						<th><span class="th">販売価格</span></th>
						<td>商品掲載ページに記載しています。</td>
					</tr>
					<tr>
						<th><div class="th height-1 disp_tbl"><span class="disp_td">商品代金以外の必要料金</span></div></th>
						<td><div class="height-1">
								購入された商品の送料がかかります。送料は、一律740円となっております。<br>
								10,000円以上のご注文は送料無料となります。<br>
								※北海道・沖縄・その他の離島は別途費用がかかる場合がございます。予めご了承ください。<br>
								<br>
								振込手数料が必要な場合は、お客様の負担となります。
							</div>
						</td>
					</tr>
					<tr>
						<th><div class="th height-1 disp_tbl"><span class="disp_td">お支払い方法</span></div></th>
						<td><div class="height-1">
								<h3 class="fw_bold">代引き</h3>
								<p class="mb20">商品お届けの際、運送業者に代金をお支払ください。</p>
								<h3 class="fw_bold">銀行振り込み</h3>
								<p class="mb20">銀行振込は、前払いになり、入金確認後に発送いたします。<br>
									また振込手数料はお客様ご負担となります。</p>
								<h3 class="fw_bold">クレジットカード（<a href="https://www.yamatofinancial.jp/consumer/payment/credit_card.html" target="_blank">クロネコwebコレクト</a>）</h3>
								<p>クロネコヤマトのクレジットカード決済です。<br>
									お客様が入力されたカード情報は当店に送られることはありませんので、安心してご利用ください。<br>
									施術に関してはクレジットカード決済の対象外となります。</p>
								<p><img src="/common/image/contents/law/card.jpg" alt="クレジットカード払い"></p>
								<p class="small">JCB・VISA・master・ダイナース・アメリカンエキスプレスのマークが入っているクレジットカードはすべてご利用になれます。</p>
							</div>
						</td>
					</tr>
					<tr>
						<th><span class="th">お届け時期</span></th>
						<td>銀行振込の場合は、入金確認から1週間以内にて発送いたします。<br>
							代引き・クレジットカード決済の場合は、ご注文確定後1週間以内に発送いたします。</td>
					</tr>
					<tr>
						<th><span class="th">申し込みの有効期限</span></th>
						<td>ご注文をされてから7日以内となります。</td>
					</tr>
					<tr>
						<th><span class="th">消費税の扱い</span></th>
						<td>税別表記（一部を除く）</td>
					</tr>
					<tr>
						<th><span class="th">販売数量の制限</span></th>
						<td>特にありません</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
	<section>
		<div class="wrapper-t center4">
			<h3 class="hl_2">返品・交換について</h3>
			<table class="tbl_1">
				<tbody>
					<tr>
						<th><div class="th height-1 disp_tbl"><span class="disp_td">返品について</span></div></th>
						<td><div class="height-1">返品は未開封のものに限り、商品到着後1週間以内であれば対応いたしますので、詳細をお知らせください。<br>
								その場合の送料はお客様負担とさせていただきます。<br>
								お客様都合での、返品はお受けできませんので、予めご了承ください。
							</div>
						</td>
					</tr>
					<tr>
						<th><span class="th">交換について</span></th>
						<td>初期不良の場合の交換は、1週間以内であれば対応いたしますので、詳細をお知らせください。<br>
							その場合の送料は当社が負担いたします。</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
	<section>
		<div class="wrapper center4">
			<h3 class="hl_2">購入者のお問い合わせ窓口</h3>
			<table class="tbl_1">
				<tbody>
					<tr>
						<th><div class="th height-1 disp_tbl"><span class="disp_td">問い合わせ窓口</span></div></th>
						<td><div class="height-1">TEL：<span class="tel" data-tel="<?php echo $_smarty_tpl->tpl_vars['_INFO']->value['tel'];?>
"><?php echo $_smarty_tpl->tpl_vars['_INFO']->value['tel'];?>
</span>　FAX：<?php echo $_smarty_tpl->tpl_vars['_INFO']->value['fax'];?>
<br>
								E-mail：info●matsui-clinic.com（●を＠に変更してお送りください）<br>
								担当：松井
							</div>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
