{if $page_navi.PageTotal|default:0 > 1}
<div class="page_navi mb20">
	{$page_navi.PageItemTotal|number_format}件中{$page_navi.PageShowStart|number_format}_{$page_navi.PageShowEnd|number_format}件目 ：
	{$page_navi.LinkBack|default:""} {$page_navi.LinkPage|default:""} {$page_navi.LinkNext|default:""}
</div>
{/if}