/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {
	
	// 言語設定
	config.language = 'ja';
	config.allowedContent = true;
	
	// 追加プラグイン
	config.extraPlugins = 'panelbutton,colorbutton,youtube';
	
	// 改行設定
	config.enterMode = CKEDITOR.ENTER_BR;
	
	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbar = [
		['Bold','Italic','Underline','Strike'], 
		['TextColor','BGColor'], 
		['Link','Unlink','Anchor'], 
		['Image','Youtube','Table'], 
		['JustifyLeft','JustifyCenter','JustifyRight'], 
		['Styles','FontSize'],
		['Source'] 
	];

	// font
	config.font_names='メイリオ;ＭＳ Ｐゴシック;ヒラギノ角ゴ Pro W3;Osaka;ＭＳ Ｐ明朝;ＭＳ ゴシック;ＭＳ 明朝;Arial/Arial, Helvetica, sans-serif;Comic Sans MS/Comic Sans MS, cursive;Courier New/Courier New, Courier, monospace;Georgia/Georgia, serif;Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;Tahoma/Tahoma, Geneva, sans-serif;Times New Roman/Times New Roman, Times, serif;Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;Verdana/Verdana, Geneva, sans-serif';
	config.font_defaultLabel = 'メイリオ';
	config.fontSize_defaultLabel = '14px';
	
	// Set the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// 幅指定
	config.width  = '100%';
	config.height = '500px';
	
	// KCFinder設定
	config.filebrowserBrowseUrl      = '/admin/common/js/kcfinder/browse.php?type=files';  
	config.filebrowserImageBrowseUrl = '/admin/common/js/kcfinder/browse.php?type=images';  
	config.filebrowserFlashBrowseUrl = '/admin/common/js/kcfinder/browse.php?type=flash';  
	config.filebrowserUploadUrl      = '/admin/common/js/kcfinder/upload.php?type=files';  
	config.filebrowserImageUploadUrl = '/admin/common/js/kcfinder/upload.php?type=images';  
	config.filebrowserFlashUploadUrl = '/admin/common/js/kcfinder/upload.php?type=flash';  
	config.filebrowserWindowWidth    = '1200';
	config.filebrowserWindowHeight   = '700';
	
	// Simplify the dialog windows.
	config.removeDialogTabs = 'image:advanced;link:advanced';
	
	// Remove some buttons provided by the standard plugins, which are
	// not needed in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

};
