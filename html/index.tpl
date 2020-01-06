<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
{include file=$template_meta}
<link rel="stylesheet" href="/common/css/import.css">
{include file=$template_javascript}
<script type="text/javascript" src="/common/js/top.js"></script>
<script type="text/javascript" src="/common/js/lightbox/import.js"></script>
</head>
<body id="top">
<div id="base">
{include file=$template_header}
<main>
<div id="body">
	<div id="main_image">
		<div class="unit">
			<div class="sp_none img_back"><img src="/common/image/contents/top/slide1.jpg" alt="ウェブクリエイティブ株式会社"></div>
			<div class="pc_none img_back"><img src="http://placehold.jp/800x800.png?text=slide1" alt="ウェブクリエイティブ株式会社"></div>
			<div class="text">
				<div class="center">
					<div class="text_in"><img src="http://placehold.jp/907x411.png?text=slide1_text" alt="狭い道路・狭小地・運搬・回送のことならお任せください"></div>
				</div>
			</div>
		</div>
		<div class="unit">
			<div class="sp_none img_back"><img src="/common/image/contents/top/slide2.jpg" alt="ウェブクリエイティブ株式会社"></div>
			<div class="pc_none img_back"><img src="http://placehold.jp/800x800.png?text=slide2" alt="ウェブクリエイティブ株式会社"></div>
			<div class="text">
				<div class="center">
					<div class="text_in"><img src="http://placehold.jp/907x411.png?text=slide2_text" alt="狭い道路・狭小地・運搬・回送のことならお任せください"></div>
				</div>
			</div>
		</div>
		<div class="unit">
			<div class="sp_none img_back"><img src="/common/image/contents/top/slide3.jpg" alt="ウェブクリエイティブ株式会社"></div>
			<div class="pc_none img_back"><img src="http://placehold.jp/800x800.png?text=slide3" alt="ウェブクリエイティブ株式会社"></div>
			<div class="text">
				<div class="center">
					<div class="text_in"><img src="http://placehold.jp/907x411.png?text=slide3_text" alt="狭い道路・狭小地・運搬・回送のことならお任せください"></div>
				</div>
			</div>
		</div>
	</div>
	<section>
		<div class="pos_re">
			<div class="l_sankaku1"></div>
			<h2 class="hl_5">IoTの窓口とは</h2>
			<div class="h6_unit">
				<h2 class="hl_6">これまでにない体験ができる<br>製品・サービスづくりをお客さまとともに考えます</h2>
				<p>企業のビジネス課題に対して、IoTを活用してどのように解決できるのかをご提案します。構想段階から新しい価値のある製品やサービスを世の中に出すところまでひとつの窓口で対応します。</p>
			</div>
			<div class="r_sankaku1"></div>
		</div>
		<div class="wrapper center">
			<h2 class="cyel h6_2">「IoTの窓口」5つの強み</h2>
		</div>
	</section>
	<section>
		<div id="top_info" class="wrapper center">
			<div class="center">
				<div class="row">
					<div class="col-sm-6">
						<div id="top_news" class="height-1 mb20">
							<h2 class="hl_3"><span class="mincho main cdb">News</span><span class="sub">お知らせ</span></h2>
							{assign var="new_date" value=$smarty.now-24*60*60*14}
							{foreach from=$t_information item="information" key="key" name="LoopInfomation"}
							<div class="info_unit">
								<a href="/information/detail.php?id={$information.id_information}">
									<div class="photo">
										<div class="img_sq"><img src="{if $information.image1}/common/photo/information/image1/m_{$information.image1}{else}http://placehold.jp/002C54/fff/100x100.png?text=null{/if}" alt="{$information.title}"></div>
										{if $information.date|strtotime > $new_date}<div class="new bg_or">NEW</div>{/if}
									</div>
									<div class="text">
										<div class="mb5"><span class="date cdb">{$information.date|date_format:"%Y/%m/%d"}</span><span class="tag _c1">{$OptionInformationCategory[$information.id_information_category]}</span></div>
										<h3 class="visible-only">{$information.title}</h3>
										<h3 class="hidden-only">{$information.title|truncate:30}</h3>
									</div>
								</a>
							</div>
							{foreachelse}
							<div>お知らせはありません。</div>
							{/foreach}
						</div>
						<div class="pos_ar">
							<a href="/information/">一覧を見る <i class="fa fa-arrow-alt-circle-right"></i></a>
						</div>
					</div>
					<div class="col-sm-6">
						<div id="top_case" class="height-1 mb20">
							<h2 class="hl_3"><span class="mincho main cdb">Case</span><span class="sub">実績紹介</span></h2>
							{foreach from=$t_case item="case" key="key" name="LoopCase"}
							<div class="info_unit">
								<a href="/case/detail.php?id={$case.id_case}">
									<div class="photo">
										<div class="img_sq"><img src="{if $case.image1}/common/photo/case/image1/m_{$case.image1}{else}http://placehold.jp/002C54/fff/100x100.png?text=null{/if}" alt="{$case.title}"></div>
										{if $case.date|strtotime > $new_date}<div class="new bg_or">NEW</div>{/if}
									</div>
									<div class="text">
										<div class="mb5"><span class="date cdb">{$case.date|date_format:"%Y/%m/%d"}</span><span class="tag _c1">{$OptionCaseCategory[$case.id_case_category]}</span></div>
										<h3 class="visible-only">{$case.title}</h3>
										<h3 class="hidden-only">{$case.title|truncate:30}</h3>
									</div>
								</a>
							</div>
							{foreachelse}
							<div>実績紹介はありません。</div>
							{/foreach}
						</div>
						<div class="pos_ar">
							<a href="/case/">一覧を見る <i class="fa fa-arrow-alt-circle-right"></i></a>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
</main>
{include file=$template_footer}
</div>
</body>
</html>
