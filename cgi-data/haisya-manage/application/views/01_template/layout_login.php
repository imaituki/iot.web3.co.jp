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
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<title><?php if(isset($page_title)){echo $page_title ;}?></title>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('js/jquery-1.7.1.min.js'); ?>"></script>
<script src="<?php echo base_url('js/bootstrap.js'); ?>"></script>

<!-- Le styles -->
<link href="<?php echo base_url(); ?>css/<?php echo $this->nds_manage_css; ?>" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/bootstrap-responsive.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>/jquery-ui-1.css" rel="stylesheet" type="text/css">

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico'); ?>" />

<script type="text/javascript">
function hideAdBar(){
    setTimeout("scrollTo(0,1)", 100);
}
</script>

</head>
<body onLoad="hideAdBar()" onOrientationChange="hideAdBar()">
<div class="container-fluid">

	<div class="row-fluid">
		<div class="span12">

			<!-- ヘッダー -->
			<?php echo $header; ?>
			<!-- /ヘッダー -->

			<!-- メイン -->
			<?php echo $main_content; ?>
			<!-- /メイン -->

		</div>
	</div><!--/row-->

	<hr />

	<!-- フッター -->
	<?php echo $footer; ?>
	<!-- /フッター -->

</div><!--/.fluid-container-->
</body>
</html>
