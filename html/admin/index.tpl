<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>管理画面</title>
		<link href="{$_ADMIN.home}/common/css/bootstrap.min.css" rel="stylesheet">
		<link href="{$_ADMIN.home}/common/font-awesome/css/font-awesome.css" rel="stylesheet">
		<link href="{$_ADMIN.home}/common/css/animate.css" rel="stylesheet">
		<link href="{$_ADMIN.home}/common/css/plugins/codemirror/codemirror.css" rel="stylesheet">
		<link href="{$_ADMIN.home}/common/css/plugins/codemirror/ambiance.css" rel="stylesheet">
		<link href="{$_ADMIN.home}/common/css/style.css" rel="stylesheet">
		<!-- FooTable -->
		<link href="{$_ADMIN.home}/common/css/plugins/footable/footable.core.css" rel="stylesheet">
		<link href="{$_ADMIN.home}/common/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
		{include file=$template_javascript}
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.tooltip.min.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.spline.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.resize.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.pie.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.symbol.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/flot/jquery.flot.time.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/jquery-ui/jquery-ui.min.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/easypiechart/jquery.easypiechart.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/sparkline/jquery.sparkline.min.js"></script> 
		<script src="{$_ADMIN.home}/common/js/plugins/footable/footable.all.min.js"></script> 
		{literal}
			<!-- Page-Level Scripts --> 
			<script>
				$(document).ready(function() {
					$('.footable').footable();
				});
			</script> 
		{/literal}
	</head>
	<body class="fixed-sidebar no-skin-config">
		<div id="wrapper">
			{include file=$template_secondary}
			<div id="page-wrapper" class="gray-bg">
				{include file=$template_header}
				<div class="wrapper wrapper-content">
					{if !empty($_CLIENT_NAME)}
						<div class="alert alert-info" role="alert">
							<h3>{$_CLIENT_NAME}</h3>
							<p><a href="{$_ADMIN.home}" target="_blank">{$_CLIENT_NAME}のページはこちらです</a></p>
						</div>
					{/if}
					{*if !empty($_ADMIN.google)}
						<div class="alert alert-info" role="alert">
							<h3>Google (Googleアカウントへのログインが必要です)</h3>
							{foreach $_ADMIN.google item=google}
								<p>{$google.title}: <a href="{$google.url}" target="_blank">{$google.url}</a></p>
							{/foreach}
						</div>
					{/if}
					{if !empty($_ADMIN.sns)}
						<div class="alert alert-info" role="alert">
							<h3>SNS</h3>
							{foreach $_ADMIN.sns item=sns}
								<p>
									{if !empty($sns.icon)}{$sns.icon} {/if}
									{$sns.title}: 
									<a href="{$sns.url}" target="_blank">{$sns.url}</a>
								</p>
							{/foreach}
						</div>
					{/if}
					{if !empty($_ADMIN.server)}
						<div class="alert alert-info" role="alert">
							<h3>サーバー会社連絡先</h3>
							{foreach $_ADMIN.server item=server}
								<h4>{$server.title}</h4>
								<p>ホームページ: <a href="{$server.url}" target="_blank">{$server.url}</a></p>
								{if !empty($server.tel)}<p>TEL: {$server.tel}</p>{/if}
							{/foreach}
						</div>
					{/if*}
					<div class="alert alert-info" role="alert">
						<h3>制作会社連絡先</h3>
						<h4>ウェブクリエイティブ株式会社</h4>
						<p>ホームページ: <a href="https://web3.co.jp/" target="_blank">https://web3.co.jp/</a></p>
						<p>TEL: 086-238-9802</p>
						<p>E-mail: <a href="mailto:office@web3.co.jp">office@web3.co.jp</a></p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>