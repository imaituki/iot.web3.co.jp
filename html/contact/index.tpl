<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
{include file=$template_meta}
<link rel="stylesheet" href="/common/css/import.css">
{include file=$template_javascript}
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>
<body id="contact">
<div id="base">
{include file=$template_header}
<main>
<div id="body">
	<div id="page_title">
		<div class="img_back"><img src="/common/image/contents/form_top.jpg" alt="お問い合わせ"></div>
		<div class="page_title_wrap">
			<div class="center mincho cg">
				<h2><span class="main">お問い合わせ</span><span class="sub">Contact</span></h2>
			</div>
		</div>
	</div>
	<div id="pankuzu">
		<div class="center">
			<ul>
				<li><a href=""><i class="fa fa-home"></i></a></li>
				<li>お問い合わせ</li>
			</ul>
		</div>
	</div>
	<section>
		<div class="wrapper center entry">
			<form action="./check.php#form" method="post">
				<table class="tbl_form mb50">
					<tbody>
						<tr class="first">
							<th>会社名</th>
							<td>
								{if !empty($message.ng.company)}<span class="error">※{$message.ng.company}</span>{/if}
								<input type="text" name="company" value="{$arr_post.company}">
							</td>
						</tr>
						<tr>
							<th>名前<span class="need">必須</span></th>
							<td>
								{if !empty($message.ng.name)}<span class="error">※{$message.ng.name}</span>{/if}
								<input type="text" name="name" value="{$arr_post.name}">
							</td>
						</tr>
						<tr>
							<th>フリガナ<span class="need">必須</span></th>
							<td>
								{if !empty($message.ng.ruby)}<span class="error">※{$message.ng.ruby}</span>{/if}
								<input type="text" name="ruby" value="{$arr_post.ruby}">
							</td>
						</tr>
						<tr class="address">
							<th>住所<span class="need">必須</span></th>
							<td>
								<dl>
									{if !empty($message.ng.zip)}<span class="error">※{$message.ng.zip}</span>{/if}
									<dt>郵便番号<span class="c_or" style="font-size:12px;">　半角数字で入力してください</span></dt>
									<dd>
										<input name="zip" value="{$arr_post.zip|default:""}" type="text" class="zip w150" placeholder="000-000" >
										<a href="javascript:AjaxZip3.zip2addr('zip','','prefecture','address1');" class="bTn wp100 w_sm_A dis_b dis_sm_ib"><i class="fa fa-search" aria-hidden="true"></i>郵便番号から住所を自動入力する</a>
									</dd>
								</dl>
								{if !empty($message.ng.prefecture)}<span class="error">※{$message.ng.prefecture}</span>{/if}
								<dl>
									<dt>都道府県</dt>
									<dd>
										{html_select_ken name="prefecture" class="form-control inline input-s" selected=$arr_post.prefecture|default:"0"}
									</dd>
								</dl>
								{if !empty($message.ng.address)}<span class="error">※{$message.ng.address}</span>{/if}
								<dl>
									<dt>市区町村</dt>
									<dd class="w-420">
										<input name="address1" value="{$arr_post.address1|default:""}" type="text">
									</dd>
									<dt>番地／建物・マンション名等</dt>
									<dd class="w-420">
										<input name="address2" value="{$arr_post.address2|default:""}" type="text">
									</dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th>電話番号<span class="need">必須</span></th>
							<td>
								{if !empty($message.ng.tel)}<span class="error">※{$message.ng.tel}</span>{/if}
								<input type="text" name="tel" value="{$arr_post.tel}" maxlength="13" class="w150" placeholder="090-000-000">
							</td>
						</tr>
						<tr>
							<th>メールアドレス<span class="need">必須</span></th>
							<td>
								{if !empty($message.ng.mail)}<span class="error">※{$message.ng.mail}</span>{/if}
								<input type="text" name="mail" value="{$arr_post.mail}" maxlength="255" >
							</td>
						</tr>
						<tr class="last">
							<th>お問い合わせ内容<span class="need">必須</span></th>
							<td>
								{if !empty($message.ng.comment)}<span class="error">※{$message.ng.comment}</span>{/if}
								<textarea rows="5" name="comment">{$arr_post.comment}</textarea>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="pos_ac form_button">
					<button class="button" type="submit">確認する<i class="arrow_cg"></i></button>
				</div>
			</form>
		</div>
	</section>
</div>
</main>
{include file=$template_footer}
</div>
</body>
</html>
