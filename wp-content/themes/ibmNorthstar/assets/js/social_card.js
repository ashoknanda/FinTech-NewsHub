$ = jQuery;
	function socialCardDisplay(ID){
		$('#' + ID + '_social').css('display', "block");
		$("[data-widget='masonry']").masonry("layout");
	};
	function socialCardHide(ID){
		$('#' + ID + '_social').css('display', "none");
		$("[data-widget='masonry']").masonry('layout');
	};

    $(document).ready(function($) {
   //  	$('.custom-head-button').hover(function(e){
   //  		var offset = $(this).offset();
   //  		var ttipObj = $(".custom-tooltip-content");
   //  		var left = offset.left - 140;
   //  		var top = offset.top - 30;

			// ttipObj.css({top:top, left:left});
   //  		ttipObj.slideDown(100);

   //  	}, function(e){
   //  		$(".custom-tooltip-content").slideUp(100);
   //  	});
	});	