{foreach from=$_ARR_FILE item="file"}
<div class="form-group{if $file.notnull|default:'' == 1} required{/if}">
	<label class="col-sm-2 control-label">{$file.column}</label>
	<div class="col-sm-6">
		{if $message.ng[$file.name]|default:"" != NULL}<p class="error">{$message.ng[$file.name]}</p>{/if}
		<div class=" mb5">
		{if $mode == 'edit'}
			{assign var="fnkey" value=$file.name|cat:"_name"}
			{if $arr_post[$file.name] == NULL}
				NOT FILE<br />
			{else}
				<i class="icon-doc-text"></i> <a href="{$_UPLOADFULLPATH}/{$dir}/{$file.name}/{$arr_post[$file.name]}" target="_blank">{$arr_post[$fnkey]|default:"添付ファイル"}</a>
				{if $file.notnull|default:"" != 1}
				<input type="checkbox" name="_delete_file[{$file.name}]" value="{$arr_post[$file.name]|default:''}" /> このファイルを削除する<br />
				{/if}
			{/if}
			<input type="hidden" name="_{$file.name}_name_now" value="{$arr_post[$fnkey]|default:''}" />
			<input type="hidden" name="_{$file.name}_now" value="{$arr_post[$file.name]|default:''}" />
		{/if}
		</div>
		<input type="file" name="{$file.name}" id="{$file.name}" size="50" />
	</div>
</div>
<div class="hr-line-dashed"></div>
{if $file.name2 != NULL}
<div class="form-group{if $file.notnull2|default:'' == 1} required{/if}">
	<label class="col-sm-2 control-label">{$file.column2}</label>
	<div class="col-sm-6">
		{if $message.ng[$file.name2]|default:"" != NULL}<p class="error">{$message.ng[$file.name2]}</p>{/if}
		<input type="text" class="form-control" name="{$file.name2}" id="{$file.name2}" value="{$arr_post[$file.name2]|default:''}" maxlength="255" />
	</div>
</div>
<div class="hr-line-dashed"></div>
{/if}
{/foreach}