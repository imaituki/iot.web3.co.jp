<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
{include file=$template_meta}
<link rel="stylesheet" href="/common/css/import.css">
{include file=$template_javascript}
</head>
<body id="case">
<div id="base">
{include file=$template_header}
<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="/common/image/contents/form_top.jpg" alt="実績紹介"></div>
		<div class="page_title_wrap">
			<div class="center mincho c2">
				<h2><span class="main">実績紹介</span><span class="sub">Case</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu">
		<div class="center">
			<ul>
				<li><a href="/"><i class="fa fa-home"></i></a></li>
				<li>実績紹介</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center">
			<div class="row">
				{foreach from=$t_case item="case" key="key" name="LoopCase"}
				<div class="col-sm-4 col-xs-6 mb30">
					<a class="ov" href="./detail.php?id={$case.id_case}{if $arr_get.page != NULL}&page={$arr_get.page}{/if}">
						<div class="img_unit">
							<div class="img_rect"><img src="{if $case.image1}/common/photo/case/image1/m_{$case.image1}{else}http://placehold.jp/ccc/66a5ad/600x450.png?text=null{/if}" alt="{$case.title}"></div>
						</div>
						<div class="text_unit height-2">
							<p class="mb10">
								<span class="date c1">{$case.date|date_format:"%Y/%m/%d"}</span>
								<span class="tag c1">{$OptionCaseCategory[$case.id_case_category]}</span>
							</p>
							<h3>{$case.title}</h3>
						</div>
					</a>
				</div>
				{foreachelse}
				<div class="pos_ac">実績紹介はありません。</div>
				{/foreach}
			</div>
			{if $page_navi.LinkPage}
			<div class="list_pager">
				<ul class="mt10">
					{$page_navi.LinkPage}
				</ul>
			</div>
			{/if}
		</div>
	</section>
</div>
</main>
{include file=$template_footer}
</div>
</body>
</html>
