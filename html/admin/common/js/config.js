//-------------------------------------------
//  設定
//-------------------------------------------
$(function() {
	
	//---------------------------
	//  DatePicker設定
	//---------------------------
	if( $.fn.datepicker ) {
		
		$('.datepicker').datepicker({
			language: "ja", 
			format: "yyyy/mm/dd",
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true
		});
	}
});
