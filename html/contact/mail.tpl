--------------------------------------------------------
■ お問い合わせ内容
--------------------------------------------------------
{if $arr_post.company}
[会社名]
{$arr_post.company|default:""}
{/if}
[名前]
{$arr_post.name|default:""}

[フリガナ]
{$arr_post.ruby|default:""}

[住所]
〒{$arr_post.zip}<br>
{html_select_ken selected=$arr_post.prefecture|default:"" pre=1} {$arr_post.address1}{$arr_post.address2}

[電話番号]
{$arr_post.tel|default:""}

[メール]
{$arr_post.mail|default:""}

[お問い合わせ内容]
{$arr_post.comment|default:""}
