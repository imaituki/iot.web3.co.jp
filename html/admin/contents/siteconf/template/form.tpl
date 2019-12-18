<form class="form-horizontal" action="./{if $mode == 'edit'}update{else}insert{/if}.php" method="post" enctype="multipart/form-data">
	<div class="ibox-content">
		<div class="form-group required">
			<label class="col-sm-2 control-label">デフォルトタイトル</label>
			<div class="col-sm-6">
				{if $message.ng.default_title|default:"" != NULL}<p class="error">{$message.ng.default_title}</p>{/if}
				<input type="text" class="form-control" name="default_title" id="default_title" value="{$arr_post.default_title|default:''}" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group required">
			<label class="col-sm-2 control-label">デフォルトデスクリプション</label>
			<div class="col-sm-9">
				{if $message.ng.default_description|default:"" != NULL}<p class="error">{$message.ng.default_description}</p>{/if}
				<textarea name="default_description" id="default_description" rows="7" class="form-control">{$arr_post.default_description|default:""}</textarea>
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		<div class="form-group">
			<label class="col-sm-2 control-label">デフォルトキーワード</label>
			<div class="col-sm-6">
				{if $message.ng.default_keyword|default:"" != NULL}<p class="error">{$message.ng.default_keyword}</p>{/if}
				<p>※半角カンマ「,」区切りで記入してください。</p>
				<input type="text" class="form-control" name="default_keyword" id="default_keyword" value="{$arr_post.default_keyword|default:''}" />
			</div>
		</div>
		<div class="hr-line-dashed"></div>
		{if $_ARR_IMAGE != NULL}
			{include file=$template_image path=$_IMAGEFULLPATH dir=$_CONTENTS_DIR prefix="s_"}
		{/if}
		{foreach from=$_ADMIN.siteconf item=conf}
			{if $conf.single == 1}{* 1行ものの項目 *}
			<div class="form-group">
				<label class="col-sm-2 control-label">{$conf.title}</label>
				<div class="col-sm-6">
					{if $message.ng[$conf.name]|default:"" != NULL}<p class="error">{$message.ng[$conf.name]}</p>{/if}
					{if !empty( $conf.description )}<p>{$conf.description}</p>{/if}
					<input type="text" class="form-control" name="{$conf.name}" id="{$conf.name}" value="{$arr_post[$conf.name]|default:''}" />
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			{else}{* 複数行を想定している項目 *}
			<div class="form-group">
				<label class="col-sm-2 control-label">{$conf.title}</label>
				<div class="col-sm-9">
					{if $message.ng[$conf.name]|default:"" != NULL}<p class="error">{$message.ng[$conf.name]}</p>{/if}
					{if !empty( $conf.description )}<p>{$conf.description}</p>{/if}
					<textarea name="{$conf.name}" id="{$conf.name}" rows="7" class="form-control">{$arr_post[$conf.name]|default:""}</textarea>
				</div>
			</div>
			<div class="hr-line-dashed"></div>
			{/if}
		{/foreach}
		{if $mode == 'edit'}<input type="hidden" name="{$_CONTENTS_ID}" value="1" />{/if}
		<input type="hidden" name="_contents_dir" id="_contents_dir" value="{$_CONTENTS_DIR}" />
		<input type="hidden" name="_contents_conf_path" id="_contents_conf_path" value="{$_CONTENTS_CONF_PATH}" />
		<div class="form-group">
			<div class="col-sm-10 col-sm-offset-2 pos_ar">
				<button class="btn btn-primary"  type="submit">この内容で登録</button>
			</div>
		</div>
	</div>
</form>