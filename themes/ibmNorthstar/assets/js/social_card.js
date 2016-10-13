$ = jQuery;
	function socialCardDisplay(ID){
		$('#' + ID + '_social').css('display', "block");
		$("[data-widget='masonry']").masonry("layout");
	};
	function socialCardHide(ID){
		$('#' + ID + '_social').css('display', "none");
		$("[data-widget='masonry']").masonry('layout');
	};