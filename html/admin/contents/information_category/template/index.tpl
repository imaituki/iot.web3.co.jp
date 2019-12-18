<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>管理画面</title>
	<link href="{$_ADMIN.home}/common/css/import.css" rel="stylesheet" />
	{include file=$template_javascript}
	<script src="{$_ADMIN.home}/common/js/lightbox/import.js"></script>
	<script src="{$_ADMIN.home}/common/js/plugins/datapicker/bootstrap-datepicker-import.js"></script>
	<script src="{$_ADMIN.home}/common/js/list.js"></script>
</head>
<body class="fixed-sidebar no-skin-config">
<div id="wrapper">
	{include file=$template_secondary action="information" manage="$_CONTENTS_DIR"}
	<div id="page-wrapper" class="gray-bg">
		{include file=$template_header}
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>{$_CONTENTS_NAME}</h2>
				<ol class="breadcrumb">
					<li><a href="{$_ADMIN.home}/">Home</a></li>
					<li class="active"><strong>{$_CONTENTS_NAME}</strong></li>
				</ol>
			</div>
			<div class="col-lg-2 m-b-xs pos_ar mt30">
				<a href="./new.php" class="btn btn-primary btn-s">新規登録</a>
			</div>
		</div>
		<div class="wrapper wrapper-content">
			<div class="ibox-content m-b-sm border-bottom">
				<div class="row">
					<form method="post" action="" id="formSearch" enctype="multipart/form-data">
						<div class="col-sm-4">
							<label class="control-label" for="search_keyword">キーワード</label>
							<div class="input-group">
								<input type="text" id="search_keyword" name="search_keyword" value="{$_SESSION.admin.information_category.search.POST.search_keyword|default:""}" placeholder="キーワード" class="form-control">
								<span class="input-group-btn">
									<label class="control-label" for="search_keyword">&nbsp;</label>
									<button type="button" class="btn btn-m btn-primary btn_search"> 検索</button>
									<a href="javascript:void(0)" class="reset_btn btn_reset"> リセット</a>
									<input type="hidden" name="search_area" value="{$arr_post.search_area}">
								</span>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-content">
							<div id="msg"{if $message == NULL} style="display:none"{/if}{if $message.ng|default:"" != NULL} class="error mb20"{elseif $message.ok|default:"" != NULL} class="ok mb20"{/if}>{if $message.ng|default:"" != NULL}<i class="icon-attention"></i> {$message.ng}{elseif $message.ok|default:"" != NULL}<i class="icon-check"></i> {$message.ok}{/if}</div>
							<div id="searchList">
								{include file="./list.tpl"}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
