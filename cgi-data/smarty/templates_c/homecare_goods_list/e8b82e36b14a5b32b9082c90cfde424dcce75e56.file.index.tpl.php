<?php /* Smarty version Smarty-3.1.18, created on 2019-07-26 18:18:27
         compiled from "./index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13600844695d38158084bf31-58641629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8b82e36b14a5b32b9082c90cfde424dcce75e56' => 
    array (
      0 => './index.tpl',
      1 => 1564132705,
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
<body id="top">
<div id="fb-root"></div>
<div id="base">
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_header']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<main>
<div id="body" class="homecare_goods_list">
<div id="top_img">
    <p><img src="/common/image/contents/goods/top.jpg" alt="ホームケア商品一覧"></p>
    <p class="moji pos_al"><strong>ホームケア商品一覧</strong><br><span>homecare goods list</span></p>
</div>
<div id="pankuzu">
    <ul class="center mb30">
        <li><a href="/">TOP</a></li>
        <li>ホームケア商品</li>
    </ul>
</div>
<div id="info">
    <section>
        <div class="mt50 center pos_ac entry">
            <h2 class="hl_1">ホームケア商品一覧</h2>
            <p class="fs fw_bold mb50">homecare goods list</p>
            <div class="border">
                <h2>医師による発毛治療の効果</h2>
            </div>
            <p class="text">当院にてメール確認後、改めて詳細をお客様にメールさせていただきますので、御注文後、<br>
            少々お待ちください。<br>
            またお電話にて御注文も賜っておりますので、086-255-1171<strong>まつい皮膚科</strong>までご連絡くださいませ。<br>
            <br>
            送料は、一律740円となっております。<br>
            ※北海道・沖縄・その他の離島は上記送料プラス500円かかります。予めご了承ください。<br>
            また、振込手数料はお客様の負担となります。<br>
            その他御注文に関しては以下の特定商取引法の表示をご覧ください。 </p>
            <div class="mt20 pos_ac">
                <a href="/law/" class="button">特定商取引に基づく表示<i class="fa fa-chevron-right"></i></a>
            </div>
        </div>
    </section>
    <section>
        <div class="mt50 center pos_ac">
            <p class="text pos_ar"> ※表示価格は税込です。</p>
            <div class="row mt20">
                <section>
                <?php  $_smarty_tpl->tpl_vars['shopping'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['shopping']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mst_shopping']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['shopping']->key => $_smarty_tpl->tpl_vars['shopping']->value) {
$_smarty_tpl->tpl_vars['shopping']->_loop = true;
?>
                     <div class="col-sm-4 col-xs-4 height-1 mb50">
                        <div class="img">
                            <p><img src="/common/photo/shopping/image1/m_<?php echo $_smarty_tpl->tpl_vars['shopping']->value['image1'];?>
" alt=""></p>
                        </div>
                        <h3 class="fw_bold"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
</h3>
                        <p class="text pos_ar mt30 mb30">価格<span class="price">￥<?php echo $_smarty_tpl->tpl_vars['shopping']->value['tax'];?>
</span></p>
                        <p class="g_box">内容量：<?php echo $_smarty_tpl->tpl_vars['shopping']->value['weight'];?>
</p>
                            <?php echo $_smarty_tpl->tpl_vars['shopping']->value['code'];?>

                        <p class="text mt70 mb20" ><?php echo $_smarty_tpl->tpl_vars['shopping']->value['comment'];?>
</p>
                        <?php if (!empty($_smarty_tpl->tpl_vars['shopping']->value['detail'])) {?>
                        <div class="mt20 pos_ac mb50  parallax" data-parallax-in="vertical">
                            <a href="#detail<?php echo $_smarty_tpl->tpl_vars['shopping']->value['id_shopping'];?>
" class="button colorbox disp_b">詳細はこちら<i class="fa fa-chevron-right"></i></a>
                        </div>
                        <div style="display:none">
                            <div id="detail<?php echo $_smarty_tpl->tpl_vars['shopping']->value['id_shopping'];?>
" class="center2 voice_box">
                                <div class="pos_ac">
                                    <h2 class="h2 pos_ac" style="color:#336D00;"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
</h2>
                                    <?php if ($_smarty_tpl->tpl_vars['shopping']->value['id_shopping']==15||$_smarty_tpl->tpl_vars['shopping']->value['id_shopping']==16) {?>
                                   <?php } elseif (!empty($_smarty_tpl->tpl_vars['shopping']->value['image2'])) {?> <img src="/common/photo/shopping/image2/l_<?php echo $_smarty_tpl->tpl_vars['shopping']->value['image2'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
">
                                   <?php } else { ?>   <img src="/common/photo/shopping/image1/l_<?php echo $_smarty_tpl->tpl_vars['shopping']->value['image1'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['shopping']->value['title'];?>
"> <?php }?>
                                    <p class="pos_ac text mt50 mb50 pdnone"><?php echo $_smarty_tpl->tpl_vars['shopping']->value['detail'];?>
</p>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <?php } ?>
                    
                    </div> 
                </section>
            </div>
        </div> 
    </section>
</div>
</div>
</main>
<?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['template_footer']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</div>
</body>
</html>
<?php }} ?>
