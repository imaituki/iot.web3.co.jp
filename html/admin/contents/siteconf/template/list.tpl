{include file=$template_pagenavi}
<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15">
	<tbody>
		<tr class="gray-bg">
			<th colspan="2">サイトSEO設定</th>
		</tr>
		<tr>
			<th width="250">デフォルトタイトル</th>
			<td>{$data.default_title|default:''}</td>
		</tr>
		<tr>
			<th>デフォルトデスクリプション</th>
			<td>{$data.default_description|default:''}</td>
		</tr>
		<tr>
			<th>デフォルトキーワード</th>
			<td>{$data.default_keyword|default:''}</td>
		</tr>
		<tr>
			<th>デフォルトOGP画像</th>
			<td>
				<div class="lightBoxGallery pos_al">
					{foreach from=$_ARR_IMAGE item=file name=file}
						{if $data[$file.name]}
							<a href="{$_IMAGEFULLPATH}/{$_CONTENTS_DIR}/{$file.name}/l_{$data[$file.name]}" title="{$file.comment|default:''}" rel="lightbox[]">
								<img src="{$_IMAGEFULLPATH}/{$_CONTENTS_DIR}/{$file.name}/s_{$data[$file.name]}" />
							</a>
						{/if}
						{if $smarty.foreach.file.iteration % 3 == 0}<br />{/if}
					{/foreach}
				</div>
			</td>
		</tr>
	</tbody>
</table>
<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15">
	<tbody>
		<tr class="gray-bg">
			<th colspan="2">企業情報設定</th>
		</tr>
		{foreach from=$_ADMIN.siteconf item=conf}
		<tr>
			<th width="250">{$conf.title}</th>
			<td>{$data[$conf.name]|default:''|nl2br}</td>
		</tr>
		{/foreach}
	</tbody>
</table>
{include file=$template_pagenavi}
