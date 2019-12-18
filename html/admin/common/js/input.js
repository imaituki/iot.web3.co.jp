//-------------------------------------------
//  ロード
//-------------------------------------------
$( function() {

	//-------------------------------------------
	//  ボタン処理
	//-------------------------------------------
	// 登録処理
	$("#insertBtn").click( function() {
		$("#inputForm").attr('action', './insert.php').attr('target', '').submit();
	});
	$("#insertBtn2").click( function() {
		$("#inputForm").attr('action', './insert.php?replay=1').attr('target', '').submit();
	});

	// 編集処理
	$("#updateBtn").click( function() {
		$("#inputForm").attr('action', './update.php').attr('target', '').submit();
	});


	//-------------------------------------------
	//  画像変更処理
	//-------------------------------------------
	// 設定
	var php_path   = "/admin/common/php/";
	var photo_path = "/common/photo/";

	$(".file").change( function(){
		if( $(this).val() != '' ){
			var clone = $(this).clone(true);
			$(this).imageupload( function(res) {
				$(this).parents('div').children('.load_image').remove();
				$(this).before(res);
				if( $(res).find('.err-img').length > 0 ) {
					$(this).after(clone).remove();

				}
				$('#fileup_cover').remove();
				$(this).val('');
			});
		}
	});


	//-------------------------------------------
	//  画像アップロード
	//-------------------------------------------
	// iframeID
	var iframeID = 0;

	// アップロード処理
	$.fn.imageupload = function ( callback ) {

		// 対象
		var my = this;

		// iframe名
		var iframeName = 'fileupload_fm' + ++iframeID;

		// iframe HTML
		var iframeHtml = '<iframe name="' + iframeName + '" style="display:none;"></iframe>';
		var fileupCoverHtml = '<div id="fileup_cover"><div id="fileup_cover_in"><div id="loader"></div>読み込み中</div></div>';

		// form HTML
		var formHtml  = '<form target="' + iframeName + '" method="post" enctype="multipart/form-data" />';
		var inputHtml = '<input type="hidden" name="_contents_dir" value="' + $('#_contents_dir').val() + '" /><input type="hidden" name="_contents_conf_path" value="' + $('#_contents_conf_path').val() + '" />';

		// 追加オプション
		$('.optimg').each( function() {
			inputHtml += this.outerHTML;
		});


		// iframe 追加（</body>上にこっそり追加）
		var iframe = $(iframeHtml).appendTo('body');
		var fileupCover = $(fileupCoverHtml).appendTo('body');

		// form 追加（対象タグの上下にこっそり追加）
		var form = my.wrapAll(formHtml).parent('form').attr( 'action', php_path + 'imageUp.php' );

		// input 追加
		my.before(inputHtml);

		// 実行
		form.submit(function() {
			iframe.on("load", function() {

				// 対象をformからはじき出してform削除
				form.after(my).remove();

				// iframeの中身取得
				data = $(iframe).contents().find('body').html();

				// iframe削除
				setTimeout(function() {
					iframe.remove();
					if( callback ) {
						callback.call( my, data );
					}

				}, 0 );

			});
		}).submit();

		// 戻り
		return this;

	}

});
