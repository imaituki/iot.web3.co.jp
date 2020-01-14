<?php /* Smarty version Smarty-3.1.18, created on 2019-09-09 12:19:22
         compiled from "/home/jwcc/8071/html/information/detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8442375735d393a0047b5d9-61699809%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dbcbbfc9899da5e2e7e5ba9ee3f2c6c8e2e5595f' => 
    array (
      0 => '/home/jwcc/8071/html/information/detail.tpl',
      1 => 1566899950,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8442375735d393a0047b5d9-61699809',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d393a00537253_10073022',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    't_information' => 0,
    '_IMAGEPATH' => 0,
    'arr_get' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d393a00537253_10073022')) {function content_5d393a00537253_10073022($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/home/jwcc/8071/data/smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="ja">
<head>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/common/js/lightbox/import.js"></script>
</head>
<body id="information">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="page_title">
	<div class="img_back"><img src="/common/image/contents/contact/top.jpg" alt="お知らせ"></div>
	<div class="page_title_wrap">
		<div class="center">
			<h2><span class="mincho">お知らせ</span><span class="sub">Information</span></h2>
		</div>
	</div>
</div>
<div id="pankuzu">
	<ul class="center">
		<li><a href="/">TOP</a></li>
		<li><a href="./">お知らせ</a></li>
		<li><?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
 </li>
	</ul>
</div>
<div id="body">
	<section>
		<div id="info_detail" class="wrapper center4">
			<h2 class="hl_1"><span class="mincho"><?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
</span><span class="sub"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['t_information']->value['date'],"%Y.%m.%d");?>
</span></h2>
			<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['image1'])) {?><div class="photo mb30"><img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image1/l_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image1'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
"></div><?php }?>
			<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['comment'])) {?><div class="text entry mb50"><?php echo $_smarty_tpl->tpl_vars['t_information']->value['comment'];?>
</div><?php }?>
			<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['image2'])||!empty($_smarty_tpl->tpl_vars['t_information']->value['image3'])||!empty($_smarty_tpl->tpl_vars['t_information']->value['image4'])||!empty($_smarty_tpl->tpl_vars['t_information']->value['image5'])) {?>
			<div class="row mb50">
				<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['image2'])) {?>
				<div class="col-xs-3 col-6 mb10">
					<a href="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image2/l_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image2'];?>
" rel="lightbox">
						<div class="photo img_sq"><img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image2/m_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image2'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
"></div>
					</a>
				</div>
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['image3'])) {?>
				<div class="col-xs-3 col-6 mb10">
					<a href="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image3/l_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image3'];?>
" rel="lightbox">
						<div class="photo img_sq"><img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image3/m_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image3'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
"></div>
					</a>
				</div>
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['image4'])) {?>
				<div class="col-xs-3 col-6 mb10">
					<a href="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image4/l_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image4'];?>
" rel="lightbox">
						<div class="photo img_sq"><img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image4/m_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image4'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
"></div>
					</a>
				</div>
				<?php }?>
				<?php if (!empty($_smarty_tpl->tpl_vars['t_information']->value['image5'])) {?>
				<div class="col-xs-3 col-6 mb10">
					<a href="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image5/l_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image5'];?>
" rel="lightbox">
						<div class="photo img_sq"><img src="<?php echo $_smarty_tpl->tpl_vars['_IMAGEPATH']->value;?>
/information/image5/m_<?php echo $_smarty_tpl->tpl_vars['t_information']->value['image5'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_information']->value['title'];?>
"></div>
					</a>
				</div>
				<?php }?>
			</div>
			<?php }?>
			<div class="pos_ac">
				<a href="./<?php if (!empty($_smarty_tpl->tpl_vars['arr_get']->value['page'])) {?>?page=<?php echo $_smarty_tpl->tpl_vars['arr_get']->value['page'];?>
<?php }?>" class="button"><i class="fa fa-chevron-left"></i>一覧に戻る</a>
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
