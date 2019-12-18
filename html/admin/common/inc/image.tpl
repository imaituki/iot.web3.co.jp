{foreach from=$_ARR_IMAGE item=file key=key name=loopFile}
{if $imgKey|default:"" == "" || ( $imgKey|default:"" != "" && $key == $imgKey|default:"" )}
<div class="form-group {if $file.notnull|default:'' == 1} required{/if}">
	<label class="col-sm-2 control-label">{$file.column|default:""}</label>
	<div class="col-sm-6">
		{if $message.ng[$file.name]|default:"" != NULL}<p class="error">{$message.ng[$file.name]}</p>{/if}
		{assign var='preview_name' value="_preview_image_`$file.name`"}
		<div class="mb5">
		{if $mode == 'edit'}
			{if $arr_post[$file.name]|default:"" == NULL}
				<div class="load_image">
					NOT IMAGE<br />
				</div>
			{else}
				<div class="registered_image">
					<img src="{$path}/{$dir}/{$file.name}/s_{$arr_post[$file.name]}" class="mb10" />
					{if $file.notnull|default:"" != 1}
					<label><input type="checkbox" name="_delete_image[{$file.name}]" value="{$arr_post[$file.name]|default:''}" /> この写真を削除する</label>
					{/if}
				</div>
			{/if}
			<input type="hidden" name="_{$file.name}_now" value="{$arr_post[$file.name]|default:''}" />
		{/if}
		{if isset($arr_post[$preview_name])}
			{if $arr_post[$preview_name]|default:'' != NULL}
				<div class="load_image">
					<img src="{$_ADMIN.home}/common/php/imageDisp.php?dir={$_CONTENTS_DIR}&image={$file.name}" />
					<span class="c_red"> ※この画像はプレビュー用です。まだ保存されていません。</span>
					<input type="hidden" name="_preview_{$file.name}" value="{$file.name}" />
					<input type="hidden" name="_preview_image_{$file.name}" value="{$arr_post[$preview_name]}" />
					<input type="hidden" name="_preview_image_dir" value="{$arr_post._preview_image_dir}" />
				</div>
			{/if}
		{/if}
		</div>
		<input type="file" class="file" name="{$file.name}" id="{$file.name}" size="50" />
	</div>
</div>
{if $file.column2|default:"" != NULL}
<div class="hr-line-dashed"></div>
<div class="form-group{if $file.notnull2|default:'' == 1} required{/if}">
	<label class="col-sm-2 control-label">{$file.column2}</label>
	<div class="col-sm-6">
		{if $message.ng[$file.name2]|default:"" != NULL}<p class="error">{$message.ng[$file.name2]}</p>{/if}
		{if !empty($type) && $type == "text"}
		<textarea name="{$file.name2}" id="{$file.name2}" rows="3" class="form-control">{$arr_post[$file.name2]|default:""}</textarea>
		{else}
		<input type="text" class="form-control" name="{$file.name2}" id="{$file.name2}" value="{$arr_post[$file.name2]|default:""}" />
		{/if}
	</div>
</div>
{/if}
<div class="hr-line-dashed"></div>
{/if}
{/foreach}