<title>{if $_HTML_HEADER_ORIGINAL.title|default:"" != NULL }{$_HTML_HEADER_ORIGINAL.title|default:""}{else}{if $_HTML_HEADER.title|default:"" != NULL}{$_HTML_HEADER.title|default:""} | {/if}{$_HTML_HEADER_DEFAULT.title|default:""}{/if}</title>

<meta name="keywords" content="{if $_HTML_HEADER_ORIGINAL.keyword|default:"" != NULL }{$_HTML_HEADER_ORIGINAL.keyword|default:""}{else}{if $_HTML_HEADER.keyword|default:""}{$_HTML_HEADER.keyword|default:""},{/if}{$_HTML_HEADER_DEFAULT.keyword|default:""}{/if}">
<meta name="description" content="{if $_HTML_HEADER_ORIGINAL.description|default:"" != NULL }{$_HTML_HEADER_ORIGINAL.description|default:""}{else}{$_HTML_HEADER.description|default:""}{$_HTML_HEADER_DEFAULT.description|default:""}{/if}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, viewport-fit=cover">
<link rel="icon" href="/common/favicon/favicon.ico" type="image/x-icon">
<link rel="icon" href="/common/favicon/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" href="/common/favicon/apple-touch-icon.png">

<meta property="og:title" content="{if $_HTML_HEADER_ORIGINAL.title|default:"" != NULL }{$_HTML_HEADER_ORIGINAL.title|default:""}{else}{if $_HTML_HEADER.title|default:"" != NULL}{$_HTML_HEADER.title|default:""} | {/if}{$_HTML_HEADER_DEFAULT.title|default:""}{/if}">
<meta property="og:site_name" content="{$_HTML_HEADER_DEFAULT.title|default:""}">
<meta property="og:description" content="{if $_HTML_HEADER_ORIGINAL.description|default:"" != NULL }{$_HTML_HEADER_ORIGINAL.description|default:""}{else}{$_HTML_HEADER.description|default:""}{$_HTML_HEADER_DEFAULT.description|default:""}{/if}">
<meta name="apple-mobile-web-app-title" content=" ウェブクリエイティブ株式会社" />
