$(function(){

	// Sortable設定
	sortableInit();

});

// Sortable設定
function sortableInit() {
	$('#sortable-table tbody').sortable({
		handle: 'i',
		update: function( e, ui ) {
			var sort =  $("#sortable-table tbody").sortable("toArray").join(",");

			$.ajax({
				type: "POST",
				url:  "sort.php",
				data: {'sort':sort},
				success: function(e){

					// データ取得
					var parseData = JSON.parse(e);

					// メッセージ表示
					if( parseData.result == "true" ) {
						dispMessage( "<i class=\"icon-check\"></i>&nbsp;" + parseData.message, "ok mb20" );
					} else {
						dispMessage( "<i class=\"icon-attention\"></i>&nbsp;" + parseData.message, "error mb20" );
					}

					// リストの再読み込み
					var data = $("#sortable-table").serialize() + "&";
					getList(data);

				}
			});
		}
	});
}
