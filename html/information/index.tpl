<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
{include file=$template_meta}
<link rel="stylesheet" href="/common/css/import.css">
{include file=$template_javascript}
</head>
<body id="information">
<div id="base">
{include file=$template_header}
<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="/common/image/contents/form_top.jpg" alt="お知らせ"></div>
		<div class="page_title_wrap">
			<div class="center mincho c2">
				<h2><span class="main">お知らせ</span><span class="sub">Information</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu">
		<div class="center">
			<ul>
				<li><a href="/"><i class="fa fa-home"></i></a></li>
				<li>お知らせ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center">
			{foreach from=$t_information item="information" key="key" name="LoopInfomation"}
			<div class="info_box">
				<a class="ov" href="./detail.php?id={$information.id_information}{if $arr_get.page != NULL}&page={$arr_get.page}{/if}">
					<div class="photo img_rect">
						<img src="{if $information.image1}/common/photo/information/image1/m_{$information.image1}{else}http://placehold.jp/ccc/66a5ad/600x450.png?text=null{/if}" alt="{$information.title}">
					</div>
					<div class="text">
						<div class="disp_td">
							<p class="mb10">
								<span class="date c1">{$information.date|date_format:"%Y/%m/%d"}</span>
								<span class="tag c1">{$OptionInformationCategory[$information.id_information_category]}</span></p>
							<h3>{$information.title}</h3>
						</div>
					</div>
				</a>
			</div>
			{foreachelse}
			<div class="pos_ac">お知らせはありません。</div>
			{/foreach}
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
