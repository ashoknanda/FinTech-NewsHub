(function (window,$) {

    jQuery(document).ready(function($) {
    	console.log("This is inside document ready");
    	$('.custom-tooltip-content').on('hover', function(e){
    		console.log(e);
    	})
	});	

	// function ()

})(window,jQuery);