// ------------------------------------------------------------------------------------------
//
//                              HOMEPAGE SCROLLING
//
// ------------------------------------------------------------------------------------------
 

jQuery(function() {
var tile_offset = homepage_infinity_scrollURL.tile_offset_size;
	jQuery('.more_arrow').on('click', function (e) {
	  e.preventDefault();

	  jQuery('.more_arrow').addClass('more_arrow_wheel');

	  // console.log('pre ' + homepage_infinity_scrollURL.tile_offset_size);
	  var post_id = jQuery("input[name=post_id]").val();
	  jQuery.ajax({
	    url: homepage_infinity_scrollURL.ajax_url,
	    type: 'post',
	    data: {
	      action: 'homepage_infinity_scroll_result',
	      page_offset: homepage_infinity_scrollURL.tile_offset_size,
	      post_id: post_id
	    }
	  }).done(function (response) {
	    // console.log('--------------------------------- SUCCESS -----------------------------------');
	    // console.log(response);
	    jQuery('.more_arrow').removeClass('more_arrow_wheel');
	    if (response === '') {
	      jQuery('.more_arrow').remove();
	      return false;
	    }
	    homepage_infinity_scrollURL.tile_offset_size += tile_offset;
	    // console.log('post ' + homepage_infinity_scrollURL.tile_offset_size);
			var el = jQuery(response);
	    jQuery('#story-space').append(el).masonry( 'appended', el, true );
	    // if (tile_offset === 16) {
	    //   jQuery('.more_arrow').remove();
	    // }

	  }).fail(function(response) {
	    // console.log('--------------------------------- done -----------------------------------');
	    // console.log(response);
	    jQuery('#story-space').append('<p>done = ' + response + '</p>');
	  });
	});

});
