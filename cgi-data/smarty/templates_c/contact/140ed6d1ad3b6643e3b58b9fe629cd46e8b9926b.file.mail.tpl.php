<?php /* Smarty version Smarty-3.1.18, created on 2019-11-07 15:34:11
         compiled from "./mail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20353915845d318193c8a8e6-11984331%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '140ed6d1ad3b6643e3b58b9fe629cd46e8b9926b' => 
    array (
      0 => './mail.tpl',
      1 => 1573108446,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20353915845d318193c8a8e6-11984331',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5d318193ce0e51_25120634',
  'variables' => 
  array (
    'arr_post' => 0,
    'OptionContent' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5d318193ce0e51_25120634')) {function content_5d318193ce0e51_25120634($_smarty_tpl) {?>--------------------------------------------------------
■ お問い合わせ内容
--------------------------------------------------------
[お問い合わせ項目]
<?php echo $_smarty_tpl->tpl_vars['OptionContent']->value[$_smarty_tpl->tpl_vars['arr_post']->value['content']];?>


<?php if ($_smarty_tpl->tpl_vars['arr_post']->value['company']) {?>[会社名]
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


[お問い合わせ内容]
<?php echo (($tmp = @$_smarty_tpl->tpl_vars['arr_post']->value['comment'])===null||$tmp==='' ? '' : $tmp);?>

<?php }} ?>
