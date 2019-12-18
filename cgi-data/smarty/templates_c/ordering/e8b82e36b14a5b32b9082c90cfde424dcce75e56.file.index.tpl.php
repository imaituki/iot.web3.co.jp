<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 10:27:14
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:727749605db290eb850684-00347035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1572953991,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '727749605db290eb850684-00347035',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db290eb8acd61_38485708',
  'variables' => 
  array (
    'template_meta' => 0,
    '_RENEWAL_DIR' => 0,
    'template_javascript' => 0,
    'template_header' => 0,
    'message' => 0,
    'arr_post' => 0,
    'OptionTime' => 0,
    'template_footer' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db290eb8acd61_38485708')) {function content_5db290eb8acd61_38485708($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/modifier.date_format.php';
if (!is_callable('smarty_function_html_options')) include '/virtual/119.245.151.134/data/smarty/libs/plugins/function.html_options.php';
?><!DOCTYPE html>
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
			<p class="mb30">ご発注の方はこちらのフォームよりお申し込みください。<br>
				※弊社のスタッフが確認しご連絡させていた時点で確定となります。</p>
			<form action="./check.php#form" method="post">
				<table class="tbl_form mb50">
					<tbody>
						<tr class="first">
							<th scope="row">会社名<span class="need">必須</span></th>
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
						<tr>
							<th scope="row">ご希望日<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['date'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['date'];?>
</span><?php }?>
								<input type="date" name="date" min="<?php echo smarty_modifier_date_format((time()+24*60*60*1),'%Y-%m-%d');?>
" class="select_date" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['date'])===null||$tmp==='' ? '0000-00-00' : $tmp);?>
" style="max-width: 100%; padding: 7px 10px; border: 1px solid #CCC;">
							</td>
						</tr>
						<tr>
							<th scope="row">希望時間<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['time'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['time'];?>
</span><?php }?>
								<select name="time" class="time">
									<option value="0">選択してください</option>
									<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['OptionTime']->value,'selected'=>$_smarty_tpl->tpl_vars['arr_post']->value['time']),$_smarty_tpl);?>

								</select>
							</td>
						</tr>
						<tr>
							<th scope="row">荷物の種類<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['type'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['type'];?>
</span><?php }?>
								<input type="text" name="type" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['type'];?>
">
							</td>
						</tr>
						<tr>
							<th scope="row">荷積み場所<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['loading'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['loading'];?>
</span><?php }?>
								<input type="text" name="loading" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['loading'];?>
">
							</td>
						</tr>
						<tr>
							<th scope="row">荷下し場所<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['unloading'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['unloading'];?>
</span><?php }?>
								<input type="text" name="unloading" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['unloading'];?>
">
							</td>
						</tr>
						<tr>
							<th scope="row">重さ<span class="need">必須</span></th>
							<td>
								<?php if (!empty($_smarty_tpl->tpl_vars['message']->value['ng']['wight'])) {?><span class="error">※<?php echo $_smarty_tpl->tpl_vars['message']->value['ng']['wight'];?>
</span><?php }?>
								<input type="text" name="wight" value="<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['wight'];?>
">
							</td>
						</tr>
						<tr class="last">
							<th scope="row">その他要望事項</th>
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
