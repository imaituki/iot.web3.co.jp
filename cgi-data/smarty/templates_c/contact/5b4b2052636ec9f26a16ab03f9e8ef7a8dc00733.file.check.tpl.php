<?php /* Smarty version Smarty-3.1.18, created on 2020-02-10 12:33:45
         compiled from "./check.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6846482525d303928db3c50-84677633%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b4b2052636ec9f26a16ab03f9e8ef7a8dc00733' => 
    array (
      0 => './check.tpl',
      1 => 1581305589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6846482525d303928db3c50-84677633',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d303928e050a8_55083477',
  'variables' => 
  array (
    'template_meta' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'arr_post' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d303928e050a8_55083477')) {function content_5d303928e050a8_55083477($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_select_ken')) include '/data/domain/BB0B6DDA-20C6-11EA-8A14-AD6F0C460029/cgi-data/smarty/libs/plugins/function.html_select_ken.php';
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="contact">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="/common/image/contents/form_top.jpg" alt="お問い合わせ"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">お問い合わせ</span><span class="sub">Contact</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="/"><i class="fa fa-home"></i></a></li>
				<li>お問い合わせ</li>
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
						<?php if ($_smarty_tpl->tpl_vars['arr_post']->value['company']) {?>
						<tr class="first">
							<th scope="row">会社名</th>
							<td><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['company'];?>
<input type="hidden" name="company" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['company'];?>
"></td>
						</tr>
						<?php }?>
						<tr <?php if ($_smarty_tpl->tpl_vars['arr_post']->value['company']==null) {?>class="first"<?php }?>>
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
							<th class="pos-vt">住所</th>
							<td>〒<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['zip'];?>
<br>
								<?php echo smarty_function_html_select_ken(array('selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['prefecture'])===null||$tmp==='' ? '' : $tmp),'pre'=>1),$_smarty_tpl);?>
 <?php echo $_smarty_tpl->tpl_vars['arr_post']->value['address1'];?>
<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['address2'];?>

								<input type="hidden" name="zip" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['zip'];?>
">
								<input type="hidden" name="prefecture" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['prefecture'];?>
">
								<input type="hidden" name="address1" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['address1'];?>
">
								<input type="hidden" name="address2" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['address2'];?>
">
							</td>
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
							<th scope="row">お問い合わせ内容</th>
							<td><?php echo nl2br($_smarty_tpl->tpl_vars['arr_post']->value['comment']);?>

								<input type="hidden" name="comment" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['comment'];?>
" />
							</td>
						</tr>
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
