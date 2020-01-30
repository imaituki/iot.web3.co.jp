<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
{include file=$template_meta}
<link rel="stylesheet" href="/common/css/import.css">
{include file=$template_javascript}
<script type="text/javascript" src="/common/js/lightbox/import.js"></script>
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
				<li><a href="/case/">実績紹介</a></li>
				<li>{$t_case.title}</li>
			</ul>
		</div>
	</div>
	<section>
		<div id="info_detail" class="wrapper-t center">
			<div class="box">
				<div class="box_in">
					<div class="mb20"><span class="date c1">{$t_case.date|date_format:"%Y/%m/%d"}</span><span class="tag c1">{$OptionCaseCategory[$t_case.id_case_category]}</span></div>
					<h2 class="title">{$t_case.title}</h2>
					{if $t_case.image1}
					<div class="pos_ac {if $t_case.caption1 == NULL}mb50{/if}"><img src="/common/photo/case/image1/l_{$t_case.image1}" alt="{$t_case.title}"></div>
					{if $t_case.caption1 != NULL}<p class="mb50">キャプション１</p>{/if}
					{/if}
					<div class="entry mb50">
						{$t_case.comment}
					</div>
					{if $t_case.image2 || $t_case.image3 || $t_case.image4 || $t_case.image5}
					<div class="row">
						{if $t_case.image2}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/case/image2/l_{$t_case.image2}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/case/image2/m_{$t_case.image2}" alt="{$t_case.title}"></div>
								<p>キャプション2</p>
							</a>
						</div>
						{/if}
						{if $t_case.image3}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/case/image3/l_{$t_case.image3}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/case/image3/m_{$t_case.image3}" alt="{$t_case.title}"></div>
								<p>キャプション3</p>
							</a>
						</div>
						{/if}
						{if $t_case.image4}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/case/image4/l_{$t_case.image4}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/case/image4/m_{$t_case.image4}" alt="{$t_case.title}"></div>
								<p>キャプション4</p>
							</a>
						</div>
						{/if}
						{if $t_case.image5}
						<div class="col-xs-3 col-6 height-1 mb20">
							<a class="ov" href="/common/photo/case/image5/l_{$t_case.image5}" rel="lightbox">
								<div class="img_rect"><img src="/common/photo/case/image5/m_{$t_case.image5}" alt="{$t_case.title}"></div>
								<p>キャプション5</p>
							</a>
						</div>
						{/if}
					</div>
				{/if}
				</div>
			</div>
		</div>
		<div class="wrapper">
			<div class="button _type_2"><a href="/case/{if $arr_get.page != NULL}?page={$arr_get.page}{/if}"><i class="arrow_cg2"></i>一覧へ戻る</a></div>
		</div>
	</section>
</div>
</main>
{include file=$template_footer}
</div>
</body>
</html>
