<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 16:18:54
         compiled from "./mail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11536660225db81077000b66-82500779%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '140ed6d1ad3b6643e3b58b9fe629cd46e8b9926b' => 
    array (
      0 => './mail.tpl',
      1 => 1572954011,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11536660225db81077000b66-82500779',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5db810770cba92_97285564',
  'variables' => 
  array (
    'arr_post' => 0,
    'OptionTime' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5db810770cba92_97285564')) {function content_5db810770cba92_97285564($_smarty_tpl) {?>--------------------------------------------------------
■ 発注依頼内容
--------------------------------------------------------
<?php if ($_smarty_tpl->tpl_vars['arr_post']->value['company']) {?>
[会社名]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['company'])===null||$tmp==='' ? '' : $tmp);?>

<?php }?>

[名前]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['name'])===null||$tmp==='' ? '' : $tmp);?>


[フリガナ]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['ruby'])===null||$tmp==='' ? '' : $tmp);?>


[電話番号]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['tel'])===null||$tmp==='' ? '' : $tmp);?>


[メール]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['mail'])===null||$tmp==='' ? '' : $tmp);?>


[ご希望日]
<?php echo $_smarty_tpl->tpl_vars['arr_post']->value['date'];?>


[希望時間]
<?php echo $_smarty_tpl->tpl_vars['OptionTime']->value[$_smarty_tpl->tpl_vars['arr_post']->value['time']];?>


[荷物の種類]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['type'])===null||$tmp==='' ? '' : $tmp);?>


[荷積み場所]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['loading'])===null||$tmp==='' ? '' : $tmp);?>


[荷下し場所]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['unloading'])===null||$tmp==='' ? '' : $tmp);?>


[重さ]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['wight'])===null||$tmp==='' ? '' : $tmp);?>



<?php if ($_smarty_tpl->tpl_vars['arr_post']->value['comment']) {?>
[その他要望事項]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['comment'])===null||$tmp==='' ? '' : $tmp);?>

<?php }?>
<?php }} ?>
