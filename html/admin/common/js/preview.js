// CSS読み込み
document.write('<link rel="stylesheet" type="text/css" href="/admin/common/css/preview.css" type="text/css" />');

$( function(){

	// iframeID
	var iframeID = 0;

	// プレビュー表示
	$('#previewBtn').click(function() {

		// iframe名
		var iframeName = 'iframe_preview' + ++iframeID;

		// dialog用パーツ出力
		var dialogHtml = '<div id="kotak-dialog"><h3 class="title">プレビュー<a href="#" class="close">&times;</a></h3><div class="isi-dialog"><div id="iframeContainer"><iframe name="'+iframeName+'" id="'+iframeName+'"></iframe></div><div class="button-wrapper"><button class="close">Close</button></div></div></div><div id="dialog-overlay"></div>';

		// 対象formの下に追加
		var iframe = $(this).closest('form').after(dialogHtml);

		// プレビューページの作成
		$("#inputForm").attr('action', './preview.php').attr('target', iframeName).submit();

		// 表示
		var w_height = $(document).height() - 200;
		$("#kotak-dialog").css("height",w_height);
		$('#kotak-dialog').show();
		$("#iframeContainer iframe").css("height",w_height - 120);
		$('#dialog-overlay').fadeTo(400, 0.8);
		$('body,html').animate({scrollTop: 0},400);

		return false;
	});

	$(document).on('click', '#kotak-dialog .close', function() {
		$('#kotak-dialog').fadeOut('normal', function() {
			$('#kotak-dialog').remove();
			$('#dialog-overlay').remove();
		});
		return false;
	});

} );
