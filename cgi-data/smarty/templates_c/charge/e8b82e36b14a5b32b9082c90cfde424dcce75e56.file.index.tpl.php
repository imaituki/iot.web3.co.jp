<?php /* Smarty version Smarty-3.1.18, created on 2019-10-02 21:19:35
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12819557735d303a2172da87-78707227%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1570018718,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12819557735d303a2172da87-78707227',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d303a217442c0_85018827',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d303a217442c0_85018827')) {function content_5d303a217442c0_85018827($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="charge">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/charge/top.jpg" alt="料金表"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">料金表<span class="sub">charge list</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li>料金表</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper-t center">
			<h2 class="hl_1 mb30"><span class="cp mincho">メディカルエステ</span><span class="sub">medical aesthetic</span></h2>
			<h3 class="hl_4 mincho cp mb10">XEO（ゼオ）・トリニティプラス</h3>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。</p>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th colspan="2"><span class="th">施術名</span></th>
							<th><span class="th">1回</span></th>
							<th><span class="th">詳細</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_genesis.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_lime.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_acutip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_triniti.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">1回</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_genesis.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_lime.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_acutip.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_triniti.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho cp mb10">メソアクティス</h3>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。</p>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">料金</span></th>
							<th><span class="th">トライアル</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mesoacthys.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">料金</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mesoacthys.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">施術時間</span></th>
							<th><span class="th">料金</span></th>
							<th><span class="th">トライアル</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mesoacthys_body.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th style="width:70px"><span class="th">時間</span></th>
							<th><span class="th">料金</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mesoacthys_body.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">10回コース</span></th>
							<th><span class="th">トライアル</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mesoacthys_hair.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">10回コース</span></th>
							<th><span class="th">トライアル</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mesoacthys_hair.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho cp mb10">サイトプロMDメソアクティス</h3>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。</p>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">5回コース</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_md_mesoacthys.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">5回コース</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_md_mesoacthys.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>


			<h3 class="hl_4 mincho cp mb10">SHE LINE</h3>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。<br>
				※お試し価格は、全顔のみです。</p>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th colspan="2"><span class="th">施術名</span></th>
							<th><span class="th">詳細</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_sheline.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th colspan="2"><span class="th">施術名</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_sheline.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho cp mb10">コラーゲンピール</h3>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">施術箇所</span></th>
							<th><span class="th">単品</span></th>
							<th><span class="th">5回コース（5％off）</span></th>
							<th><span class="th">10回コース（10％off）</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_collagen.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">単品</span></th>
							<th><span class="th">5回コース</span></th>
							<th><span class="th">10回コース</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_collagen.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb10">（消費税抜）</p>
			<p class="mb50">初回お試し（顔のみ）<strong class="cp">9,000円</strong>、他の施術と併用できるお得なコースもございます。<br>
				お気軽にご予約ください。</p>

			<h3 class="hl_4 mincho cp mb10">単独施術</h3>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。</p>
			<div class="hidden-only">
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
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_clear.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_peeling.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_ion.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">9回目以降</span></th>
							<th><span class="th">割引</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_clear.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_peeling.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_ion.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho cp mb10">Mix療法</h3>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。</p>
			<div class="hidden-only">
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
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mix.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">9回目-</span></th>
							<th><span class="th">割引</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_mix.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho cp mb10">肝斑トーニング治療メニュー</h3>
			<p class="mb20">（Qスイッチヤグレーザー）</p>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th colspan="3"><span class="th">施術</span></th>
							<th><span class="th">金額</span></th>
							<th><span class="th">プレゼント内容</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_kanpan.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th colspan="2"><span class="th">施術</span></th>
							<th><span class="th">金額</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_kanpan.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb10">（消費税抜）</p>
			<p class="mb50">※治療期間は2週間に1回、1クールは5回です。<br>
				※メソアクティスはレーザー照射と同日に施術可能です。別日でも構いません。<br>
				※2週～3週に1回来院できない方は、トーニング治療を行えません。推奨は2週間に1度になります。<br>
				※美白内服セット（シナール、トラネキサム酸）は相乗効果を上げるために内服を推奨しております。</p>
		</div>
	</section>
	<section>
		<div class="wrapper-t center">
			<h2 class="hl_1 mb30"><span class="cp mincho">脱毛料金表</span><span class="sub">hair removed</span></h2>
			<h3 class="hl_4 mincho cp mb10">YAGレーザー脱毛（クールグライド）</h3>
			<div class="hidden-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th><span class="th">顔</span></th>
							<th><span class="th">顔2/3</span></th>
							<th><span class="th">ホホ</span></th>
							<th><span class="th">あご</span></th>
							<th><span class="th">口囲（男）</span></th>
							<th><span class="th">口囲（女）</span></th>
							<th><span class="th">1ショット</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_yag1.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th><span class="th">両前腕<br>両上腕</span></th>
							<th><span class="th">両前腕2/3<br>両上腕2/3</span></th>
							<th><span class="th">両ワキ</span></th>
							<th><span class="th">両手甲</span></th>
							<th><span class="th">両膝</span></th>
							<th><span class="th">両下腿</span></th>
							<th><span class="th">両大腿</span></th>
							<th><span class="th">胸腹部（上下）</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_yag2.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th><span class="th">うなじ</span></th>
							<th><span class="th">背中（大）腰まで</span></th>
							<th><span class="th">背中（小）（ブラ線上）殿部</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_yag3.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cp mb10">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th><span class="th">1-5回</span></th>
							<th><span class="th">6-4回</span></th>
							<th><span class="th">10回目-</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_yag-sp.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb10">（消費税抜）</p>
			<p class="mb50">※当院では、ビキニラインについては対応しておりません。<br>
				※未成年の方は保護者の同意書が必要です。<br>
				※脱毛2カ所以上の場合10％OFF（ワキとショット打ちは対象外）<br>
				※学生証提示にて10%OFF（ワキも対象、ショットは対象外）<br>
				※要予約（086-255-1171）</p>
		</div>
	</section>
	<section>
		<div class="wrapper bg_po">
			<div class="center">
				<h2 class="hl_1 mb30"><span class="cp mincho">メディカルアロマセラピー</span><span class="sub">medical aromatherapy</span></h2>
				<p class="mb10">※脂肪溶解は、一部位（腹部・大腿・二の腕）の中から選択できます。</p>
				<div class="hidden-only">
					<table class="tbl_charge cp mb10">
						<thead>
							<tr>
								<th colspan="2"><span class="th">施術名</span></th>
								<th><span class="th">施術時間</span></th>
								<th><span class="th">通常1回</span></th>
								<th><span class="th">トライアル</span></th>
							</tr>
						</thead>
						<tbody>
							<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_aroma.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</tbody>
					</table>
				</div>
				<div class="visible-only">
					<table class="tbl_charge cp mb10">
						<thead>
							<tr>
								<th><span class="th">施術名</span></th>
								<th style="width:70px;"><span class="th">時間</span></th>
								<th><span class="th">料金</span></th>
							</tr>
						</thead>
						<tbody>
							<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_aroma.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</tbody>
					</table>
				</div>
				<p class="pos_ar c_gray mb50">（消費税抜）</p>
				<div class="hidden-only">
					<table class="tbl_charge cp mb10">
						<thead>
							<tr>
								<th><span class="th">施術名</span></th>
								<th><span class="th">施術時間</span></th>
								<th><span class="th">料金</span></th>
							</tr>
						</thead>
						<tbody>
							<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_massage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</tbody>
					</table>
				</div>
				<div class="visible-only">
					<table class="tbl_charge cp mb10">
						<thead>
							<tr>
								<th><span class="th">時間</span></th>
								<th><span class="th">料金</span></th>
							</tr>
						</thead>
						<tbody>
							<?php echo $_smarty_tpl->getSubTemplate ("./tmp_beauty_massage.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

						</tbody>
					</table>
				</div>
				<p class="pos_ar c_gray">（消費税抜）</p>
			</div>
		</div>
	</section>
	<section>
		<div class="wrapper-t center">
			<h2 class="hl_1 mb30"><span class="cb mincho">リジュー（発毛・育毛）</span><span class="sub">hair growing</span></h2>
			<p class="mb20">※未成年の方は保護者の同意書が必要です。<br>
				※コースにするとお得です。学割もあります。</p>
			<div class="hidden-only">
				<table class="tbl_charge cb mb10">
					<thead>
						<tr>
							<th><span class="th">施術名</span></th>
							<th><span class="th">トライアル</span></th>
							<th><span class="th">通常1回</span></th>
							<th><span class="th">10回コース</span></th>
							<th><span class="th">20回コース</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_hair.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<div class="visible-only">
				<table class="tbl_charge cb mb10">
					<thead>
						<tr>
							<th><span class="th">トライアル</span></th>
							<th><span class="th">1回</span></th>
							<th><span class="th">10回</span></th>
							<th><span class="th">20回</span></th>
						</tr>
					</thead>
					<tbody>
						<?php echo $_smarty_tpl->getSubTemplate ("./tmp_hair.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

					</tbody>
				</table>
			</div>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>
		</div>
	</section>
	<section>
		<div class="wrapper center">
			<h3 class="hl_4 mincho c2 mb10">美容点滴</h3>
			<p class="mb10">※未成年の方は保護者の同意書が必要です。<br>
				※2種類以上をMIXする場合、1種類につき＋2,000円。</p>
			<table class="tbl_charge mb10">
				<thead>
					<tr>
						<th><span class="th">施術名</span></th>
						<th><span class="th">料金</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>ダイエット</td>
						<td>3,600円</td>
					</tr>
					<tr>
						<td>美白</td>
						<td>3,600円</td>
					</tr>
					<tr>
						<td>アンチエイジング</td>
						<td>3,600円</td>
					</tr>
					<tr>
						<td>疲労回復</td>
						<td>3,600円</td>
					</tr>
				</tbody>
			</table>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho c2 mb10">高濃度ビタミン注射</h3>
			<p class="mb10">※未成年の方は保護者の同意書が必要です。<br>
				※2種類以上をMIXする場合、1種類につき＋2,000円</p>
			<table class="tbl_charge mb10">
				<thead>
					<tr>
						<th><span class="th">ビタミンC</span></th>
						<th><span class="th">料金</span></th>
						<th><span class="th">時間</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>12.5g</td>
						<td>8,000円</td>
						<td>約60分</td>
					</tr>
					<tr>
						<td>25g</td>
						<td>10,000円</td>
						<td>約90分</td>
					</tr>
					<tr>
						<td>50g</td>
						<td>16,000円</td>
						<td>約120分</td>
					</tr>
				</tbody>
			</table>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho c2 mb10">その他の施術</h3>
			<p class="mb10">※未成年の方は保護者の同意書が必要です。</p>
			<table class="tbl_charge mb10">
				<thead>
					<tr>
						<th colspan="2"><span class="th">施術名</span></th>
						<th><span class="th">料金</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td rowspan="2">ヒアルロン酸 全顔</td>
						<td>1回目</td>
						<td>47,500円</td>
					</tr>
					<tr>
						<td>2回目</td>
						<td>40,000円</td>
					</tr>
					<tr>
						<td colspan="2">肌診断 ロボスキンアナライザー</td>
						<td>3,000円</td>
					</tr>
				</tbody>
			</table>
			<p class="pos_ar c_gray mb50">（消費税抜）</p>

			<h3 class="hl_4 mincho c2 mb10">ピアス穴あけ</h3>
			<p class="mb10">※20歳未満の方は保護者の同意書が必要です。<br>
				※ピアスをご持参ない場合は別途ピアス料金がかかります。</p>
			<table class="tbl_charge mb10">
				<thead>
					<tr>
						<th><span class="th">施術名</span></th>
						<th><span class="th">料金</span></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>ピアス穴あけ（1ヶ所）</td>
						<td>1,500円</td>
					</tr>
				</tbody>
			</table>
			<p class="pos_ar c_gray mb10">（消費税抜）</p>
			<p class="pos_ar">2018年1月よりメニュー改訂</p>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
