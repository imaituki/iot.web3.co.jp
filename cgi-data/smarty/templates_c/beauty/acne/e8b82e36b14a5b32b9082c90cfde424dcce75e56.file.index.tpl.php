<?php /* Smarty version Smarty-3.1.18, created on 2019-10-02 18:13:45
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15623696075d301461a62771-27924092%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1570007624,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15623696075d301461a62771-27924092',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d301461a93a97_07220615',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'OptionMenuList' => 0,
    'menu' => 0,
    'key' => 0,
    'tag' => 0,
    'OptionMenuTag' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d301461a93a97_07220615')) {function content_5d301461a93a97_07220615($_smarty_tpl) {?><!DOCTYPE html>
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
			<h2><span class="mincho">ニキビ・ニキビ跡</span><span class="sub">acne care</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li><a href="../">美容皮ふ科治療</a></li>
		<li>ニキビ・ニキビ跡</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper center3">
			<h2 class="hl_1 mb30"><span class="cp mincho">ニキビ治療から肌質改善まで</span></h2>
			<p class="mb10">ニキビとは、皮脂腺にニキビ菌（アクネ桿菌）が感染し、炎症をおこした状態のことです。ニキビの炎症をおさえ、今あるニキビを治すことはもちろんですが、ニキビを繰り返さないように、肌質を改善することも大切です。</p>
			<p>当院では、大人のニキビに効果的な光治療だけでなく、イオン導入、ケミカルピーリングなど、美しい肌に整えることができるメニューもご準備しています。ニキビケアは早ければ早いほど効果的です。小さなニキビひとつからでも、ご相談ください。</p>
		</div>
	</section>
	<section>
		<div class="wrapper bg_po">
			<div class="center4">
				<h2 class="hl_1 mb30"><span class="cp mincho">施術方法から探す</span><span class="sub">menu list</span></h2>
				<div class="row">
<?php if ($_smarty_tpl->tpl_vars['OptionMenuList']->value) {?>
<?php  $_smarty_tpl->tpl_vars["menu"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["menu"]->_loop = false;
 $_smarty_tpl->tpl_vars["key"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['OptionMenuList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["menu"]->key => $_smarty_tpl->tpl_vars["menu"]->value) {
$_smarty_tpl->tpl_vars["menu"]->_loop = true;
 $_smarty_tpl->tpl_vars["key"]->value = $_smarty_tpl->tpl_vars["menu"]->key;
?>
				<div class="col-sm-3 col-xs-6">
					<div class="card_unit cp">
						<a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value['url'];?>
" class="height-2">
							<div class="photo"><img src="/common/image/contents/beauty/menu<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
.jpg" alt="<?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
"></div>
							<div class="text height-1">
								<h3 class="cp"><?php echo $_smarty_tpl->tpl_vars['menu']->value['title'];?>
</h3>
								<p><?php echo $_smarty_tpl->tpl_vars['menu']->value['comment'];?>
</p>
							</div>
							<div class="tag_area">
							<?php  $_smarty_tpl->tpl_vars["tag"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["tag"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menu']->value['tag']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["tag"]->key => $_smarty_tpl->tpl_vars["tag"]->value) {
$_smarty_tpl->tpl_vars["tag"]->_loop = true;
?>
								<span class="tag"><?php echo $_smarty_tpl->tpl_vars['OptionMenuTag']->value[$_smarty_tpl->tpl_vars['tag']->value];?>
</span>
							<?php } ?>
							</div>
						</a>
					</div>
				</div>
<?php } ?>
<?php }?>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="wrapper center" id="clear">
			<h2 class="hl_1 mb30"><span class="cp mincho">クリアタッチ</span><span class="sub">clear touch</span></h2>
			<div class="row">
				<div class="col-xs-5 col-xs-push-7">
					<p class="mb30"><img src="/common/image/contents/beauty/acne/image1.jpg" alt="クリアタッチ"></p>
				</div>
				<div class="col-xs-7 col-xs-pull-5">
					<h3 class="hl_4 mincho c2">治りにくい大人のニキビに効果的！<br>赤いニキビを短期間で安全に治療</h3>
					<p class="mb10">ストレス・神経性（働く女性主婦）や睡眠不足などからできる大人のにきびに効果を発揮する「クリアタッチ」。活性酸素を誘導する青色光と炎症を抑える赤色光とのコンビネーションによって、ニキビの原因となるアクネ菌と皮脂腺にダメージを与え、にきびを解消します。</p>
					<p class="mb30">1回の治療は光を数回照射するだけで、10分程度で終了。頑固なにきびにも短時間で治し、さらに再発しにくい肌質に改善します。特に炎症を起こした赤にきびには効果的。知らないうちにできている治りにくい背中のにきびにもOKです。</p>
					<div class="box bg0 _bg_po">
						<h3 class="title"><span class="bg_p">料金</span></h3>
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
									<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_clear.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
									<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_clear.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

								</tbody>
							</table>
						</div>
						<p class="pos_ar c_gray">（消費税抜）</p>
					</div>
				</div>
			</div>
		</div>
	</section>
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
										<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_peeling.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
										<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_peeling.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

									</tbody>
								</table>
							</div>
							<p class="pos_ar c_gray">（消費税抜）</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section>
		<div class="wrapper" id="ion">
			<div class="center2">
				<h2 class="hl_1 mb30"><span class="cp mincho">イオン導入</span><span class="sub">iontophoresis</span></h2>
				<h3 class="hl_4 mincho c2 pos_ac-pc">シワ、シミ、くすみ、たるみ、ニキビ、肝斑に。</h3>
				<p class="mb50">お肌に微弱な電流を流すことで、イオン化した美容液中の成分を皮膚の真皮層にまで浸透させ、細胞を活性化させることで、美しい肌に整えます。特に余分な角質が除去されている<a href="#peeling">ピーリング</a>後に行うと、有効成分が浸透しやすくなります。</p>
			</div>
			<div class="center">
				<div class="row mb30">
					<div class="col-xs-6">
						<div class="card_unit bg_po">
							<div class="text height-1">
								<h3 class="cp mb10 large">ビタミンCイオン導入</h3>
								<p class="bg10">ニキビ、美白に。メラニンの産生を抑制し、コラーゲンの生成を促進します。過剰な皮脂の分泌を抑制し、抗酸化作用があるので、ニキビ、肌老化全般に効果的です。</p>
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="card_unit bg_po">
							<div class="text height-1">
								<h3 class="cp mb10 large">トラキネム酸配合イオン導入</h3>
								<p class="bg10">しみ、肝斑に。色むらが気になる肌を、透き通るような透明感のある肌に整えます。</p>
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="card_unit bg_po">
							<div class="text height-1">
								<h3 class="cp mb10 large">アミノシナジーイオン導入</h3>
								<p class="bg10">アミノシナジーは、イオン導入に最適な成分と濃度で配合された（※1）アミノ酸トータル・スキンケア・ローションです。プラセンタと同等の効果がある非生物生体として注目を集めているアミノ酸。必須アミノ酸である「リジン」「スレオニン」を始め、10種類ものアミノ酸を配合したアミノシナジーは、プラセンタに変わるスキンケアローションです。</p>
							</div>
						</div>
					</div>
					<div class="col-xs-6">
						<div class="card_unit bg_po">
							<div class="text height-1">
								<h3 class="cp mb10 large">グリシルグリシンイオン導入</h3>
								<p class="bg10">開大した毛穴にアミノ酸の一種、グリシルグリシンが収縮作用あり。さらにイオン導入により、薬剤は、毛包を通して皮膚に吸収されます。</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="center2">
				<h4 class="hl_2"><span class="x-small">（※1）アミノ酸とは</span></h4>
				<p class="small mb50">アミノ酸とはたんぱく質を構成する最小単位です。私達の体は60～70％が水分で、20％がたんぱく質などのアミノ酸でできており、美肌には欠かせないMNFやコラーゲンもアミノ酸で構成されています。しかし、体内で構築することができない成分でもあります。<br>アミノ酸は老化や紫外線ダメージにより減少するため、毎日アミノ酸を取り入れ皮膚内で再構築させることが、美肌を保つためには必要と言われています。</p>
			</div>
			<div class="center">
				<div class="box bg0 _bg_po">
					<h3 class="title"><span class="bg_p">料金</span></h3>
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
								<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_ion.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

								<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_mix.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

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
								<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_ion.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

								<?php echo $_smarty_tpl->getSubTemplate ("./../../charge/tmp_beauty_mix.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

							</tbody>
						</table>
					</div>
					<p class="pos_ar c_gray">（消費税抜）</p>
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
