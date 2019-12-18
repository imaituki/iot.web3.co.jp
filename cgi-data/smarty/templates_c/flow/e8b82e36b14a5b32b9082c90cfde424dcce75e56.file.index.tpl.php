<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 18:52:56
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14706995085db29345d48f98-32796226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1573120354,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14706995085db29345d48f98-32796226',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db29345dbdbc7_58784253',
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
<?php if ($_valid && !is_callable('content_5db29345dbdbc7_58784253')) {function content_5db29345dbdbc7_58784253($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="flow">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/top.jpg" alt="ご注文の流れ"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">ご注文の流れ</span><span class="sub">Flow</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>ご注文の流れ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center flow">
			<div class="row">
				<div class="col-xs-2">
					<div class="height-1 disp_tbl">
						<div class="disp_td flow_num"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/step1.jpg" alt="step1"></div>
					</div>
				</div>
				<div class="col-xs-10">
					<div class="box _flow height-1">
						<h3 class="cg"><span class="icon"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/icon1.jpg" alt="注文依頼"></span>注文依頼<span class="sub">【お客様→親幸産業】</span></h3>
						<p>まずは、お電話もしくはメールにてお問い合わせください。<br>
							当サイトからのお申し込みの場合は、<a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/estimate/" class="cg2">お見積りフォーム</a>からご連絡ください。</p>
					</div>
				</div>
			</div>
			<p class="arrow"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/shita.jpg" alt="下"></p>
			<div class="row">
				<div class="col-xs-2">
					<div class="height-1 disp_tbl">
						<div class="disp_td flow_num"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/step2.jpg" alt="step2"></div>
					</div>
				</div>
				<div class="col-xs-10">
					<div class="box _flow height-1">
						<h3 class="cg"><span class="icon"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/icon2.jpg" alt="内容を確認し返信"></span>内容を確認し返信<span class="sub">【お客様→親幸産業】</span></h3>
						<p><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/estimate/" class="cg2">お見積りフォーム</a>からご連絡いただいた場合、ご要望を確認後、担当者からご連絡させていただきます。</p>
					</div>
				</div>
			</div>
			<p class="arrow"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/shita.jpg" alt="下"></p>
			<div class="row">
				<div class="col-xs-2">
					<div class="height-1 disp_tbl">
						<div class="disp_td flow_num"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/step3.jpg" alt="step3"></div>
					</div>
				</div>
				<div class="col-xs-10">
					<div class="box _flow height-1">
						<h3 class="cg"><span class="icon"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/icon3.jpg" alt="お見積り"></span>お見積り<span class="sub">【親幸産業→お客様】</span></h3>
						<p>詳細なご要望・要件を確認後、お見積りさせていただきます。ご不明な点がございましたら、担当者にご相談ください。</p>
					</div>
				</div>
			</div>
			<p class="arrow"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/shita.jpg" alt="下"></p>
			<div class="row">
				<div class="col-xs-2">
					<div class="height-1 disp_tbl">
						<div class="disp_td flow_num"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/step4.jpg" alt="step4"></div>
					</div>
				</div>
				<div class="col-xs-10">
					<div class="box _flow height-1">
						<h3 class="cg"><span class="icon"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/icon4.jpg" alt="注文決定"></span>注文決定（配車決定）<span class="sub">【お客様→親幸産業】</span></h3>
						<p>注文書に押印いただき、弊社にメール・FAXいただいた時点で発注完了となります。運行のご依頼をお受けするにあたり「運送業務基本契約書」の締結をお願いしておりますので、ご理解・ご協力をお願いいたします。</p>
					</div>
				</div>
			</div>
			<p class="arrow"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/shita.jpg" alt="下"></p>
			<div class="row">
				<div class="col-xs-2">
					<div class="height-1 disp_tbl">
						<div class="disp_td flow_num"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/step5.jpg" alt="step5"></div>
					</div>
				</div>
				<div class="col-xs-10">
					<div class="box _flow height-1">
						<h3 class="cg"><span class="icon"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/flow/icon5.jpg" alt="指示書"></span>指示書（地図・作業計画書）<span class="sub">【お客様→親幸産業】</span></h3>
						<p>ご注文の際には、荷積み・荷降ろし地の地番もしくは詳細な地図と、エンドユーザ様・現場ご担当者様のお名前とご連絡先など、必要な作業指示書・計画書をお送りください。</p>
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
