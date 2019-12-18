<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache" />
<meta http-equiv="Expires" content="0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="imagetoolbar" content="no" />
<meta http-equiv="content-script-type" content="text/javascript" />
<meta name="robots" content="index,follow" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<title><?php if(isset($page_title)){echo $page_title ;}?></title>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>js/jquery-1.7.1.min.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>
<script src="<?php echo base_url(); ?>js/jquery-ui-1.8.21.custom.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.ui.datepicker-ja.js"></script>
<script src="<?php echo base_url(); ?>js/ndsResizeImage.js"></script>

<!-- Le styles -->
<link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/nds_manage.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />

<!-- Handson table -->
<script src="<?php echo base_url(); ?>js/jquery.handsontable.full.js" ></script>
<link href="<?php echo base_url(); ?>css/jquery.handsontable.full.css" rel="stylesheet" />

<!-- Add fancyBox main JS and CSS files -->
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.fancybox.css?v=2.1.4" media="screen" />
<script type="text/javascript">
	$(document).ready(function() {
		$('.fancybox').fancybox();
	});
</script>
<style type="text/css">
	.fancybox-custom .fancybox-skin {
		box-shadow: 0 0 50px #222;
	}
</style>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>
<body>
<div class="container-fluid">

	<div class="row-fluid">
		<div class="span12">

			<!-- ヘッダー -->

				<div class="container-fluid">
					<div class="row">
						<h1 class=" pull-left"><a style="color: #000;" href="<?php echo site_url('top/top'); ?>"><img src="<?php echo base_url(); ?>img/logo.png" alt="管理画面ロゴ" /></a></h1>
						<?php if (($this->login_user !== FALSE) && is_not_blank($this->login_user->user_code)): ?>
						<div class="pull-right">
							<i class="icon-user"></i> <?php echo $this->login_user->user_name; ?>　
							<a href="<?php echo site_url('login/login/logout/'); ?>" class="btn"><i class="icon-off "></i> ログアウト</a>
						</div>
						<div class="pull-right">
						</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="navbar navbar-inverse">
					<div class="navbar-inner">
						<div class="container-fluid">
				
							<div class="nav-collapse">
								<ul class="nav">
								<li class="active"><a href="<?php echo site_url('item/item_search/search_again'); ?>"><i class="icon-arrow-left icon-white"></i> 製品検索に戻る</a></li>
								</ul>
							</div><!--/.nav-collapse -->
				
						</div><!--/.container-fluid -->
					</div><!--/.navbar-inner -->
				</div><!--/.navbar -->

			<!-- /ヘッダー -->

			<div class="row-fluid">
				<div class="span2">
					<!-- 左メニュー -->
					<?php echo $left_menu; ?>
					<!-- /左メニュー -->
				</div>
				<div class="span10">
<div class="row-fluid">

					<h3 style="margin: 0px;">製品[<?php echo h($this->application_session_data->get_stored_entity(Relation_data_type::ITEM)->post_title); ?>] - <?php echo $this->common_h3_tag; ?></h3>

</div><!--/.row-fluid-->
					<!-- メイン -->
					<?php echo $main_content; ?>
					<!-- /メイン -->
				</div>
			</div>

		</div><!--/span12-->
	</div><!--/row-fluid-->

	<hr />

	<!-- フッター -->
	<?php echo $footer; ?>
	<!-- /フッター -->

</div><!--/.fluid-container-->
</body>
</html>
