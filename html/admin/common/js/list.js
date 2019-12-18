//-------------------------------------------
//  設定
//-------------------------------------------
$(function() {

	// Submit無効処理
	$(document).on('submit', '#formList', function(){
		return false;
	});
	$(document).on('submit', '#formSearch', function(){
		return false;
	});

	// 検索
	$(document).on('click', '.btn_search', function(){
		searchList();
	});

	// 検索リセット
	$(document).on('click', '.btn_reset', function(){
		searchReset();
	});

	// ソート画面
	$(document).on('click', '.btn_sort', function(){
		getList("mode=sort");
	});

	// 表示切替
	$(document).on('change', '.btn_display', function(){
		updateDisplay(this);
	});

	// 削除
	$(document).on('click', '.btn_delete', function(){
		updateDelete( $(this).attr('data-id') );
	});

});


//-------------------------------------------
//  リスト取得処理
//-------------------------------------------
function getList(data) {

	// 検索PHP
	var php = $('#search_php').val();

	// 検索PHPの指定がない場合
	if( typeof php === "undefined" ) {
		php = "./search.php";
	}

	// 検索処理
	$.ajax({
		type: "POST",
		url:  php,
		data: data,
		success: function(e){
			$("#searchList").html(e);
			$("#searchList").css('display','block');

			// ライトボックス
			if( $('a[rel^=lightbox]').length ) {
				$('a[rel^=lightbox]').lightBox();
			}

			// TOPへ
			$('body,html').animate({scrollTop: 0},0);
		}
	});

}


//-------------------------------------------
//  検索処理
//-------------------------------------------
function searchList() {

	// データ（シリアライズ）
	var pers = $("#formSearch").serialize() + "&mode=search";

	// 検索
	getList(pers);

	// 処理終了後
	$(document).ajaxComplete(function(){

		// リセットボタン表示
		$(".btn_reset").css('display','inline');

		// メッセージ
		dispMessage( "<i class=\"icon-search\"></i>&nbsp;検索が完了いたしました。", "ok mb20" );

	});
}


//-------------------------------------------
//  検索リセット処理
//-------------------------------------------
function searchReset() {

	// リセット
	$("#formSearch").find(':input').each(function() {
		switch ( this.type ) {
			case 'password':
			case 'select-multiple':
			case 'select-one':
			case 'text':
			case 'textarea':
				$(this).val('');
				break;
			case 'checkbox':
			case 'radio':
				this.checked = false;
			break;
			case 'hidden':
			break;
		}

		// 日付
		var date = new Date();

		// 日付リセット
		switch( $(this).attr('class') ) {
			case 'reset_year':
				$(this).val(toDoubleDigits(date.getFullYear()));
			break;
			case 'reset_month':
				$(this).val(toDoubleDigits(date.getMonth()+1));
			break;
			case 'reset_day':
				$(this).val(date.getDate());
			break;
		}

	});

	// データ
	var pers = $("#formSearch").serialize() + "&mode=reset";

	// 検索
	getList(pers);

	// 処理終了後
	$(document).ajaxComplete(function(){

		// リセットボタン表示
		$(".btn_reset").css('display','none');

		// メッセージ
		dispMessage( "<i class=\"icon-back\"></i>&nbsp;検索をリセットいたしました。", "ok mb20" );

	});

}


//-------------------------------------------
//  ページ切替処理
//-------------------------------------------
function changePage(e) {

	// メッセージ削除
	$("#msg").css('display','none');

	// ページ切替
	$("#page").val(e)

	// リストチェック
	var style = $("#style").val();

	// データ
	var pers = $("#formSearch").serialize() + "&page=" + e;

	if( style != undefined ){
		pers = pers + "&style=" + style;
	}

	// 検索
	getList(pers);

}


//-------------------------------------------
//  キャンセル処理
//-------------------------------------------
function updateCancel() {

	// 確認
	if( !confirm("キャンセル処理を行ってよろしいですか？") ) return false;

	// データ生成
	var id = [];
	$("input:checkbox[name^='cancel_flg[]']:checked").each( function () {
		id.push(this.value);
	});

	// 削除処理
	$.ajax({
		type: "POST",
		url:  "./cancel.php",
		data: { "id":id },
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
			var data = $("#formSearch").serialize() + "&";
			getList(data);

		}
	});

}

//-------------------------------------------
//  表示更新処理
//-------------------------------------------
function updateDisplay( my ) {

	// 確認
	if( !confirm("表示更新を行ってよろしいですか？") ) {
		( $(my).prop('checked') == true ) ? $(my).prop('checked', false) : $(my).prop('checked', true);
	}

	// 初期化
	var checked = ( $(my).prop('checked') == true ) ? 1 : 0;
	var id      = $(my).attr('data-id');

	// 表示更新処理
	$.ajax({
		type: "POST",
		url:  "./display.php",
		data: { "id":id, "display_flg":checked },
		success: function(e){

			// データ取得
			var parseData = JSON.parse(e);

			// メッセージ表示
			if( parseData.result == "true" ) {
				dispMessage( "<i class=\"icon-check\"></i>&nbsp;" + parseData.message, "ok mb20" );
			} else {
				dispMessage( "<i class=\"icon-attention\"></i>&nbsp;" + parseData.message, "error mb20" );
				( $(my).prop('checked') == true ) ? $(my).prop('checked', false) : $(my).prop('checked', true);
			}

		}
	});

}

//-------------------------------------------
//  表示順更新処理
//-------------------------------------------
function updateDisplayNum() {

	// 確認
	if( !confirm("表示順更新を行ってよろしいですか？") ) return false;

	// データ生成
	var pers = "";
	$("input:text[name^='display_num']").each( function () {
		pers = pers + this.name + "=" + this.value + "&";
	});
	$("input:hidden[name='id[]']").each( function () {
		pers = pers + "id[]=" + this.value + "&";
	});
	// 表示順更新処理
	$.ajax({
		type: "POST",
		url:  "./sort.php",
		data: pers,
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
			var data = $("#formSearch").serialize() + "&";
			getList(data);

		}
	});

}


//-------------------------------------------
//  削除処理
//-------------------------------------------
function updateDelete( id ) {

	// 確認
	if( !confirm("削除処理を行ってよろしいですか？") ) return false;

	// 削除処理
	$.ajax({
		type: "POST",
		url:  "./delete.php",
		data: { "id":id },
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
			var data = $("#formSearch").serialize() + "&";
			getList(data);

		}
	});

}

//-------------------------------------------
//  削除処理（復帰あり）
//-------------------------------------------
function updateDelete2() {

	// 確認
	if( !confirm("削除処理を行ってよろしいですか？") ) return false;

	// データ生成
	var pers = "";
	$("input:checkbox[name^='delete_flg']").each( function () {
		if( this.checked == true ) {
			pers = pers + this.name + "=" + 1 + "&";
		} else {
			pers = pers + this.name + "=" + 0 + "&";
		}
	});
	$("input:hidden[name='id[]']").each( function () {
		pers = pers + "id[]=" + this.value + "&";
	});

	// 削除処理
	$.ajax({
		type: "POST",
		url:  "./delete.php",
		data: pers,
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
			var data = $("#formSearch").serialize() + "&";
			getList(data);

		}
	});

}




//-------------------------------------------
//  ０埋め
//-------------------------------------------
var toDoubleDigits = function(num) {
  num += "";
  if (num.length === 1) {
    num = "0" + num;
  }
 return num;
};


//-------------------------------------------
//  メッセージ表示
//-------------------------------------------
function dispMessage( m, c ) {
	$('#msg').attr("class", c );
	$("#msg").html( m );
	$('#msg').fadeTo( 500, 1   );
	$('#msg').fadeTo( 500, 0.3 );
	$('#msg').fadeTo( 500, 1   );
	$('#msg').fadeTo( 500, 0.3 );
	$('#msg').fadeTo( 500, 1   );
}
