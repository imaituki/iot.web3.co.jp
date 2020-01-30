<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
{include file=$template_meta}
<link rel="stylesheet" href="/common/css/import.css">
{include file=$template_javascript}
<script type="text/javascript" src="/common/js/lightbox/import.js"></script>
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
				<li><a href="/information/">お知らせ</a></li>
				<li>{$t_information.title}</li>
			</ul>
		</div>
	</div>
	<section>
		<div id="info_detail" class="wrapper-t center">
			<div class="box">
				<div class="box_in">
					<div class="mb20"><span class="date c1">{$t_information.date|date_format:"%Y/%m/%d"}</span><span class="tag c1">{$OptionInformationCategory[$t_information.id_information_category]}</span></div>
					<h2 class="title">{$t_information.title}</h2>
					{if $t_information.image1}
					<div class="pos_ac mb50"><img src="/common/photo/information/image1/l_{$t_information.image1}" alt="{$t_information.title}"></div>
					{/if}
					<div class="entry mb50">
						{$t_information.comment}
					</div>
					{if $t_information.image2 || $t_information.image3 || $t_information.image4 || $t_information.image5}
					<div class="row">
						{if $t_information.image2}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/information/image2/l_{$t_information.image2}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/information/image2/m_{$t_information.image2}" alt="{$t_information.title}"></div></a>
						</div>
						{/if}
						{if $t_information.image3}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/information/image3/l_{$t_information.image3}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/information/image3/m_{$t_information.image3}" alt="{$t_information.title}"></div></a>
						</div>
						{/if}
						{if $t_information.image4}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/information/image4/l_{$t_information.image4}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/information/image4/m_{$t_information.image4}" alt="{$t_information.title}"></div></a>
						</div>
						{/if}
						{if $t_information.image5}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/information/image5/l_{$t_information.image5}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/information/image5/m_{$t_information.image5}" alt="{$t_information.title}"></div></a>
						</div>
						{/if}
					</div>
				{/if}
				</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="button _type_2"><a href="/information/{if $arr_get.page != NULL}?page={$arr_get.page}{/if}"><i class="arrow_cg2"></i>一覧へ戻る</a></div>
		</div>
	</section>
</div>
</main>
{include file=$template_footer}
</div>
</body>
</html>
