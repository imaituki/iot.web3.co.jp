<?php /* Smarty version Smarty-3.1.18, created on 2019-10-28 10:39:39
         compiled from "../template/edit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5230107955db646db44dd47-95395857%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'be2cd0f6d05c5ea088364c2babfac075512b457f' => 
    array (
      0 => '../template/edit.tpl',
      1 => 1571378801,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5230107955db646db44dd47-95395857',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    '_ADMIN' => 0,
    'template_javascript' => 0,
    'template_secondary' => 0,
    '_CONTENTS_DIR' => 0,
    'template_header' => 0,
    '_CONTENTS_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db646db4e6399_99433769',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db646db4e6399_99433769')) {function content_5db646db4e6399_99433769($_smarty_tpl) {?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>管理画面</title>
		<link href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/css/import.css" rel="stylesheet" />
		<link href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" />
		<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/js/input.js"></script>
		<script src="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/js/plugins/datapicker/bootstrap-datepicker-import.js"></script>
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/js/ckeditor/ckeditor.js"></script>
		<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/js/chosen/chosen.css" />
		<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/common/js/chosen/chosen.jquery.min.js"></script>
	</head>
	<body class="fixed-sidebar no-skin-config">
		<div id="wrapper">
			<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_secondary']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('action'=>'information','manage'=>$_smarty_tpl->tpl_vars['_CONTENTS_DIR']->value), 0);?>

			<div id="page-wrapper" class="gray-bg">
				<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

				<div class="row wrapper border-bottom white-bg page-heading">
					<div class="col-lg-10">
						<h2><?php echo $_smarty_tpl->tpl_vars['_CONTENTS_NAME']->value;?>
</h2>
						<ol class="breadcrumb">
							<li><a href="<?php echo $_smarty_tpl->tpl_vars['_ADMIN']->value['home'];?>
/">Home</a></li>
							<li><a href="./"><?php echo $_smarty_tpl->tpl_vars['_CONTENTS_NAME']->value;?>
</a></li>
							<li class="active"><strong>編集</strong></li>
						</ol>
					</div>
					<div class="col-lg-2"></div>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight">
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5><?php echo $_smarty_tpl->tpl_vars['_CONTENTS_NAME']->value;?>
管理　編集 </h5>
								</div>
								<?php echo $_smarty_tpl->getSubTemplate ("./form.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('mode'=>"edit"), 0);?>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }} ?>
