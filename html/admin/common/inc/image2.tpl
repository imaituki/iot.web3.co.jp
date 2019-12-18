<div class="form-group">
	<label class="col-sm-2 control-label"><a href="javascript:void(0);" id="btn_photo">＋追加</a></label>
</div>
{foreach from=$arr_post.imagelist item="imagelist" key="key" name="loopImageList"}
<div class="form-group photo_loop" id="photo" data-sirial="{$key}">
	<label class="col-sm-2 control-label">写真</label>
	<div class="col-sm-6">
		{if $message.ng.image1|default:'' != NULL}<p class="error">{$message.ng.image1}</p>{/if}
		<div class="mb5">
		{if $mode == 'edit'}
			{if $arr_post.imagelist[$key].image1|default:'' == NULL}
				<div class="load_image">
					NOT IMAGE<br />
				</div>
			{else}
				<div class="registered_image">
					<img src="{$path}/{$dir}/image1/s_{$arr_post.imagelist[$key].image1}" class="mb10" />
					{if $file.notnull|default:'' != 1}
					<label><input type="checkbox" name="imagelist[{$key}][_delete_image][image1]" value="{$arr_post.imagelist[$key].image1|default:''}" /> この写真を削除する</label>
					{/if}
				</div>
			{/if}
			<input type="hidden" name="imagelist[{$key}][_image1_now]" value="{$arr_post.imagelist[$key].image1|default:''}" />
		{/if}
		{if isset($arr_post.imagelist[$key]._preview_image_image1)}
			{if $arr_post.imagelist[$key]._preview_image_image1|default:'' != NULL}
				<div class="load_image">
					<img src="{$_ADMIN.home}/common/php/imageDisp.php?dir={$_CONTENTS_DIR}&image=image1" />
					<span class="c_red"> ※この画像はプレビュー用です。まだ保存されていません。</span>
					<input type="hidden" name="imagelist[{$key}][_preview_image1]" value="image1" />
					<input type="hidden" name="imagelist[{$key}][_preview_image_image1]" value="{$arr_post.imagelist[$key]._preview_image_image1}" />
					<input type="hidden" name="imagelist[{$key}][_preview_image_dir]" value="{$arr_post.imagelist[$key]._preview_image_dir}" />
				</div>
			{/if}
		{/if}
		</div>
		<input type="file" class="file" name="image1[{$key}]" size="50" />
	</div>
</div>
<div class="hr-line-dashed"></div>
{/foreach}