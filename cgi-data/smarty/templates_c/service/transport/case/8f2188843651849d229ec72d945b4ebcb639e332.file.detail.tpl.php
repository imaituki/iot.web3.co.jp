<?php /* Smarty version Smarty-3.1.18, created on 2019-11-05 17:40:14
         compiled from "./detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4209432275db67bb140e167-25900636%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f2188843651849d229ec72d945b4ebcb639e332' => 
    array (
      0 => './detail.tpl',
      1 => 1572943211,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4209432275db67bb140e167-25900636',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db67bb15615c6_69623752',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    't_case' => 0,
    'OptionCaseCategory' => 0,
    'arr_get' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db67bb15615c6_69623752')) {function content_5db67bb15615c6_69623752($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/js/lightbox/import.js"></script>
</head>
<body id="case">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/service/transport/case/top.jpg" alt="運行例"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">運行例</span><span class="sub">Case</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/transport/case/">運行例</a></li>
				<li><?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
</li>
			</ul>
		</div>
	</div>
	<section>
		<div id="info_detail" class="wrapper-t center">
			<div class="box">
				<div class="box_in">
					<div class="mb20"><span class="date cg2"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['t_case']->value['date'],"%Y/%m/%d");?>
</span><span class="tag _c1"><?php echo $_smarty_tpl->tpl_vars['OptionCaseCategory']->value[$_smarty_tpl->tpl_vars['t_case']->value['case_category']];?>
</span></div>
					<h2 class="title"><?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
</h2>
					<?php if ($_smarty_tpl->tpl_vars['t_case']->value['image1']) {?>
					<div class="pos_ac mb50"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image1/l_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image1'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
"></div>
					<?php }?>
					<div class="entry mb50">
						<?php echo $_smarty_tpl->tpl_vars['t_case']->value['comment'];?>

					</div>
					<?php if ($_smarty_tpl->tpl_vars['t_case']->value['image2']||$_smarty_tpl->tpl_vars['t_case']->value['image3']||$_smarty_tpl->tpl_vars['t_case']->value['image4']||$_smarty_tpl->tpl_vars['t_case']->value['image5']) {?>
					<div class="row">
						<?php if ($_smarty_tpl->tpl_vars['t_case']->value['image2']) {?>
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image2/l_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image2'];?>
" rel="lightbox">
								<div class="img_rect"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image2/m_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image2'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
"></div></a>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['t_case']->value['image3']) {?>
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image3/l_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image3'];?>
" rel="lightbox">
								<div class="img_rect"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image3/m_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image3'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
"></div></a>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['t_case']->value['image4']) {?>
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image4/l_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image4'];?>
" rel="lightbox">
								<div class="img_rect"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image4/m_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image4'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
"></div></a>
						</div>
						<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['t_case']->value['image5']) {?>
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image5/l_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image5'];?>
" rel="lightbox">
								<div class="img_rect"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/photo/case/image5/m_<?php echo $_smarty_tpl->tpl_vars['t_case']->value['image5'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['t_case']->value['title'];?>
"></div></a>
						</div>
						<?php }?>
					</div>
				<?php }?>
				</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="button _type_2"><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/case/<?php if ($_smarty_tpl->tpl_vars['arr_get']->value['page']!=null) {?>?page=<?php echo $_smarty_tpl->tpl_vars['arr_get']->value['page'];?>
<?php }?>"><i class="arrow_cg2"></i>一覧へ戻る</a></div>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
