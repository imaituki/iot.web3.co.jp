{include file=$template_pagenavi}
<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15">
	<thead>
		<tr>
			<th>日付</th>
			<th>掲載期間</th>
			<th>カテゴリ</th>
			<th>タイトル</th>
			<th class="photo">写真</th>
			<th class="showhide">表示</th>
			<th class="delete">削除</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th width="100">日付</th>
			<th width="100">掲載期間</th>
			<th>カテゴリ</th>
			<th>タイトル</th>
			<th class="photo" width="220">写真</th>
			<th class="showhide" width="60">表示</th>
			<th class="delete" width="60">削除</th>
		</tr>
	</tfoot>
	<tbody>
		{foreach from=$t_information item=information}
		<tr>
			<td>{$information.date|date_format:"%Y/%m/%d"}</td>
			<td>
				{if $information.display_indefinite == 0}
					{$information.display_start|date_format:"%Y/%m/%d"}<br />
					{$information.display_end|date_format:"%Y/%m/%d"}
				{else}
					無期限
				{/if}
			</td>
			<td>
				{$OptionInformationCategory[$information.id_information_category]}
			</td>
			<td><a href="./edit.php?id={$information.$_CONTENTS_ID}">{$information.title}</a></td>
			<td class="pos_al">
				<div class="lightBoxGallery">
					{foreach from=$_ARR_IMAGE item=file name=file}
						{if $information[$file.name]}
							<a href="{$_IMAGEFULLPATH}/{$_CONTENTS_DIR}/{$file.name}/l_{$information[$file.name]}" title="{$file.comment|default:""}" rel="lightbox[]">
								<img src="{$_IMAGEFULLPATH}/{$_CONTENTS_DIR}/{$file.name}/s_{$information[$file.name]}" width="50" />
							</a>
						{/if}
						{if $smarty.foreach.file.iteration % 3 == 0}<br />{/if}
					{/foreach}
				</div>
			</td>
			<td class="pos_ac">
				<div class="switch">
					<div class="onoffswitch">
						<input type="checkbox" value="1" class="onoffswitch-checkbox btn_display" id="display{$information.$_CONTENTS_ID}" data-id="{$information.$_CONTENTS_ID}"{if $information.display_flg == 1} checked{/if}>
						<label class="onoffswitch-label" for="display{$information.$_CONTENTS_ID}">
							<span class="onoffswitch-inner"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</div>
				</div>
			</td>
			<td class="pos_ac">
				<a href="javascript:void(0)" class="btn btn-danger btn_delete" data-id="{$information.$_CONTENTS_ID}">削除</a>
			</td>
		</tr>
		{foreachelse}
		<tr>
			<td colspan="6">{$_CONTENTS_NAME}は見つかりません。</td>
		</tr>
		{/foreach}
	</tbody>
</table>
{include file=$template_pagenavi}
