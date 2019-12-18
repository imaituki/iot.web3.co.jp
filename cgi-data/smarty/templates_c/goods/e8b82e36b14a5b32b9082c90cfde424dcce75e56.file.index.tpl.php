<?php /* Smarty version Smarty-3.1.18, created on 2019-10-01 16:57:38
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13600844695d38158084bf31-58641629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1569916639,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13600844695d38158084bf31-58641629',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d381580863f85_06512770',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    '_INFO' => 0,
    'mst_shopping' => 0,
    'shopping' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d381580863f85_06512770')) {function content_5d381580863f85_06512770($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/common/js/colorbox/jquery.colorbox-min.js"></script>
<link rel="stylesheet" href="/common/js/colorbox/colorbox.css">
<script>
$(function(){
	$('.colorbox').colorbox({inline:true, width:'80%'});
});
</script>
</head>
<body id="goods">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/goods/top.jpg" alt="ホームケア商品購入"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">ホームケア商品購入</span><span class="sub">homecare goods shopping</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li>ホームケア商品購入</li>
	</ul>
</div>
<div id="body">
	<section>
		<div class="wrapper center2">
			<h2 class="hl_1 mincho">ホームケア商品を購入いただけます</h2>
			<p class="mb10">当院にてメール確認後、改めて詳細をお客様にメールさせていただきますので、ご注文後、少々お待ちください。<br>
				またお電話でのご注文も承っておりますので、<strong><span class="tel" data-tel="<?php echo $_smarty_tpl->tpl_vars['_INFO']->value['tel'];?>
"><?php echo $_smarty_tpl->tpl_vars['_INFO']->value['tel'];?>
</span> まつい皮膚科</strong>までご連絡ください。</p>
			<p class="mb30">送料は、一律740円となっております。<br>
				※北海道・沖縄・その他の離島は上記送料プラス500円かかります。予めご了承ください。<br>
				また、振込手数料はお客様の負担となります。<br>
				その他、ご注文に関しては以下の特定商取引に基づく表記をご覧ください。 </p>
			<div class="pos_ac">
				<a href="/law/" class="button">特定商取引に基づく表記<i class="fa fa-chevron-right"></i></a>
			</div>
		</div>
	</section>
	<section>
		<div id="goods_list" class="wrapper-b center">
			<p class="pos_ar mb20">※表示価格は税込です。</p>
			<div class="row">
<?php  $_smarty_tpl->tpl_vars['shopping'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['shopping']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mst_shopping']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['shopping']->key => $_smarty_tpl->tpl_vars['shopping']->value) {
$_smarty_tpl->tpl_vars['shopping']->_loop = true;
?>
				<div class="col-sm-4 col-xs-6">
					<div class="item_unit height-1">
						<div class="item_unit_in">
							<div class="photo">
								<div class="img_back height-2">
									<img src="/common/photo/shopping/image1/m_<?php echo $_smarty_tpl->tpl_vars['shopping']->value['image1'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
">
								</div>
							</div>
							<div class="text">
								<h3 class="cy"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
</h3>
								<div class="price_area"><span>税込価格：</span><span class="price">￥<?php echo number_format($_smarty_tpl->tpl_vars['shopping']->value['tax']);?>
</span></div>
								<div class="inner">内容量：<?php echo $_smarty_tpl->tpl_vars['shopping']->value['weight'];?>
</div>
								<div class="cart_html"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['code'];?>
</div>
							</div>
						</div>
						<div class="comment mb20"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['comment'];?>
</div>
						<?php if (!empty($_smarty_tpl->tpl_vars['shopping']->value['detail'])) {?>
						<div class="pos_ac">
							<a href="#detail<?php echo $_smarty_tpl->tpl_vars['shopping']->value['id_shopping'];?>
" class="button colorbox">詳細はこちら<i class="fa fa-chevron-right"></i></a>
						</div>
						<div style="display:none">
							<div id="detail<?php echo $_smarty_tpl->tpl_vars['shopping']->value['id_shopping'];?>
" class="item_detail center2">
								<h2 class="hl_1 mincho mb30"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
<span class="sub">税込価格：￥<?php echo number_format($_smarty_tpl->tpl_vars['shopping']->value['tax']);?>
</span></h2>
								<div class="row">
									<div class="col-sm-4 col-sm-push-8 mb20">
									<?php if (!empty($_smarty_tpl->tpl_vars['shopping']->value['image2'])) {?>
										<img src="/common/photo/shopping/image2/l_<?php echo $_smarty_tpl->tpl_vars['shopping']->value['image2'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
">
									<?php } else { ?>
										<img src="/common/photo/shopping/image1/l_<?php echo $_smarty_tpl->tpl_vars['shopping']->value['image1'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
">
									<?php }?>
									</div>
									<div class="col-sm-8 col-sm-pull-4">
										<div class="detail_text"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['detail'];?>
</div>
									</div>
								</div>
							</div>
						</div>
						<?php }?>
					</div>
				</div>
<?php } ?>
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
