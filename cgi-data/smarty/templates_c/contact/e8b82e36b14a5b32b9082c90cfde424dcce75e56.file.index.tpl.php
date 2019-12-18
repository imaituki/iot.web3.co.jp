<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 13:42:53
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12088971435d3032bd7c21c6-61911211%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1573101761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12088971435d3032bd7c21c6-61911211',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d3032bd7d7ac3_50093554',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'message' => 0,
    'OptionContent' => 0,
    'arr_post' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d3032bd7d7ac3_50093554')) {function content_5d3032bd7d7ac3_50093554($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_radios')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/function.html_radios.php';
?><!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<link rel="canonical" href="http://k-shinko-s.com/contact/">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_meta']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/css/import.css">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_javascript']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</head>
<body id="contact">
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/common/image/contents/form_top.jpg" alt="お問い合わせ"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">お問い合わせ</span><span class="sub">Contact</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu" class="bg_gg">
		<div class="center">
			<ul>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['_RENEWAL_DIR']->value;?>
/"><i class="fa fa-home"></i></a></li>
				<li>お問い合わせ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center entry">
			<form action="./check.php#form" method="post">
				<table class="tbl_form mb50">
					<tbody>
						<tr class="first">
							<th scope="row">お問い合わせ項目<span class="need">必須</span></th>
							<td>
								<?php if ((($tmp = @$_smarty_tpl->tpl_vars['message']->value['ng']['content'])===null||$tmp==='' ? '' : $tmp)!=null) {?><p class="error"><?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['content'];?>
</p><?php }?>
								<?php echo smarty_function_html_radios(array('name'=>"content",'options'=>$_smarty_tpl->tpl_vars['OptionContent']->value,'selected'=>(($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['content'])===null||$tmp==='' ? 1 : $tmp)),$_smarty_tpl);?>

							</td>
						</tr>
						<tr>
							<th scope="row">会社名</th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['company'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['company'];?>
</span><?php }?>
								<input type="text" name="company" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['company'];?>
">
							</td>
						</tr>
						<tr>
							<th scope="row">名前<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['name'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['name'];?>
</span><?php }?>
								<input type="text" name="name" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['name'];?>
">
							</td>
						</tr>
						<tr>
							<th scope="row">フリガナ<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['ruby'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['ruby'];?>
</span><?php }?>
								<input type="text" name="ruby" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['ruby'];?>
">
							</td>
						</tr>
						<tr>
							<th scope="row">電話番号<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['tel'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['tel'];?>
</span><?php }?>
								<input type="text" name="tel" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['tel'];?>
" maxlength="13" class="w150" placeholder="090-000-000">
							</td>
						</tr>
						<tr>
							<th scope="row">メールアドレス<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['mail'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['mail'];?>
</span><?php }?>
								<input type="text" name="mail" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['mail'];?>
" maxlength="255" >
							</td>
						</tr>
						<tr class="last">
							<th scope="row">お問い合わせ内容<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['comment'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['comment'];?>
</span><?php }?>
								<textarea rows="5" name="comment"><?php echo $_smarty_tpl->tpl_vars['arr_post']->value['comment'];?>
</textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="pos_ac form_button">
					<button class="button" type="submit">確認する<i class="arrow_cg"></i></button>
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
