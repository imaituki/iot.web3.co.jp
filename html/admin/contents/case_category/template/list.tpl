{literal}
<script type="text/javascript">
sortableInit();
</script>
{/literal}
			{include file=$template_pagenavi}
			<table class="footable table table-stripped toggle-arrow-tiny tbl_1" data-page-size="15" id="sortable-table">
				<thead>
					<tr>
						<th></th>
						<th>実績紹介カテゴリ名</th>
						<th class="photo">写真</th>
						<th class="showhide">表示</th>
						<th class="delete">削除</th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$t_case_category item="case_category" name="loopcase_category"}
					<tr id="{$case_category.id_case_category}">
						<td class="move_i">{if $arr_post.mode|default:"" == "search"}{else}<i class="fa fa-sort"><span></span></i>{/if}</td>
						<td><a href="./edit.php?id={$case_category.id_case_category}">{$case_category.name}</a></td>
						<td class="pos_al">
							<div class="lightBoxGallery">
								{foreach from=$_ARR_IMAGE item=file name=file}
									{if $case_category[$file.name]}
										<a href="{$_IMAGEFULLPATH}/{$_CONTENTS_DIR}/{$file.name}/l_{$case_category[$file.name]}" title="{$file.comment|default:""}" rel="lightbox[]">
											<img src="{$_IMAGEFULLPATH}/{$_CONTENTS_DIR}/{$file.name}/s_{$case_category[$file.name]}" width="50" />
										</a>
									{/if}
									{if $smarty.foreach.file.iteration % 3 == 0}<br />{/if}
								{/foreach}
							</div>
						</td>
						<td class="pos_ac">
							<div class="switch">
								<div class="onoffswitch">
									<input type="checkbox" value="1" class="onoffswitch-checkbox btn_display" id="display{$case_category.id_case_category}" data-id="{$case_category.id_case_category}"{if $case_category.display_flg == 1} checked{/if}>
									<label class="onoffswitch-label" for="display{$case_category.id_case_category}">
										<span class="onoffswitch-inner"></span>
										<span class="onoffswitch-switch"></span>
									</label>
								</div>
							</div>
						</td>
						<td class="pos_ac" style="text-align:unset;">
							<a href="javascript:void(0)" class="btn btn-sm btn-danger btn_delete" data-id="{$case_category.id_case_category}">削除</a>
						</td>
					</tr>
					{foreachelse}
					<tr>
						<td colspan="6">{$_CONTENTS_NAME}は見つかりません。</td>
					</tr>
					{/foreach}
				</tbody>
				<tfoot>
					<tr>
						<td colspan="10"><ul class="pagination pull-right">
							</ul></td>
					</tr>
				</tfoot>
			</table>
			{include file=$template_pagenavi}
