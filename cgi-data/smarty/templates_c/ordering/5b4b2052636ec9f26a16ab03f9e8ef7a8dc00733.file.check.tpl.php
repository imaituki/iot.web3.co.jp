<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 11:31:50
         compiled from "./check.tpl" */ ?>
<?php /*%%SmartyHeaderCode:90619625db810677965d0-47441617%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b4b2052636ec9f26a16ab03f9e8ef7a8dc00733' => 
    array (
      0 => './check.tpl',
      1 => 1572953849,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '90619625db810677965d0-47441617',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db810678c2134_56380844',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'arr_post' => 0,
    'OptionTime' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db810678c2134_56380844')) {function content_5db810678c2134_56380844($_smarty_tpl) {?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="ordering">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/form_top.jpg" alt="発注"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">発注</span><span class="sub">Order</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>発注</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center entry">
			<p class="mb10 c_red">まだフォームの送信は完了していません。</p>
			<p class="mb30">下記内容をご確認の上、「送信する」ボタンを押してください。</p>
			<form action="./#form" method="post">
				<table class="tbl_form mb50">
					<tbody>
						<tr>
							<th scope="row">会社名</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['company'];?>
<input type="hidden" name="company" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['company'];?>
"></td>
						</tr>
						<tr>
							<th scope="row">名前</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['name'];?>
<input type="hidden" name="name" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['name'];?>
"></td>
						</tr>
						<tr>
							<th scope="row">フリガナ</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['ruby'];?>
<input type="hidden" name="ruby" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['ruby'];?>
" ></td>
						</tr>
						<tr>
							<th scope="row">電話番号</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['tel'];?>

								<input type="hidden" name="tel" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['tel'];?>
">
							</td>
							</tr>
						<tr>
							<th scope="row">メールアドレス</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['mail'];?>

								<input type="hidden" name="mail" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['mail'];?>
">
							</td>
						</tr>
							<tr>
								<th width="100">ご希望日</th>
								<td><?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['date'])===null||$tmp==='' ? '0000-00-00' : $tmp);?>
</td>
								<input type="hidden" name="date" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['date'];?>
" >
							</tr>
						<tr>
							<th scope="row">希望時間</th>
							<td>
								<?php echo $_smarty_tpl->tpl_vars['OptionTime']->value[$_smarty_tpl->tpl_vars['arr_post']->value['time']];?>

								<input type="hidden" name="time" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['time'];?>
" >
							</td>
						</tr>
						<tr>
							<th scope="row">荷物の種類</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['type'];?>
<input type="hidden" name="type" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['type'];?>
" ></td>
						</tr>
						<tr>
							<th scope="row">荷積み場所</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['loading'];?>
<input type="hidden" name="loading" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['loading'];?>
" ></td>
						</tr>
						<tr>
							<th scope="row">荷下し場所</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['unloading'];?>
<input type="hidden" name="unloading" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['unloading'];?>
" ></td>
						</tr>
						<tr>
							<th scope="row">重さ</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['wight'];?>
<input type="hidden" name="wight" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['wight'];?>
" ></td>
						</tr>
						<?php if ($_smarty_tpl->tpl_vars['arr_post']->value['comment']) {?>
						<tr>
							<th scope="row">その他要望事項</th>
							<td><?php echo nl2br($_smarty_tpl->tpl_vars['arr_post']->value['comment']);?>

								<input type="hidden" name="comment" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['comment'];?>
" />
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<div class="row form_button">
					<div class="col-xs-6 mb20 left">
						<button class="button _back" type="submit"><i class="arrow_cg2"></i>修正する</button>
					</div>
					<div class="col-xs-6 right">
						<button id="send_button" class="button" type="submit">送信する<i class="arrow_cg"></i></button>
					</div>
				</div>
			</form>
		</div>
	</section>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
