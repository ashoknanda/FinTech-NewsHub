window.newshub = (function(app, $){

	/*-----------------------------------------------------
	*  this part populates window.newshub.data.articles with article data for overlay approach for showing contents.
	*/

	app.data = app.data || {};
	app.data.animatedArticles = app.data.animatedArticles || {};

	/*-----------------------------------------------------
	*  let's start staggered animation if it hasn't been animated
	*/
	
	app.functions = app.functions || {};
	app.functions.renderCard = function(postID){

		// get the elements and set up variables
		var
			$el = $('[data-post-id='+postID+']'),
			$cardEl = $el.find('.nh-card')
			delay = Math.max((parseInt($el.attr('data-post-count')) - Object.keys(window.newshub.data.animatedArticles).length), 0) * 100 + 300
		;

		// ignore the cascading fade and randomize it
		delay = Math.random() * 800 + 300;

		// if this card hasn't been animated...
		if(app.data.animatedArticles[postID] !== true){

			// register this card
			app.data.animatedArticles[postID] = true;

			// start the animation
			setTimeout(function(){
				$el.find('.nh-card')
					.addClass('start-animation')
				;
			}, delay);

		}else{
			// this card has been animated - so let's not animate
			setTimeout(function(){
				$el.find('.nh-card')
					.addClass('donot-animate')
					.addClass('start-animation')
				;
			}, delay);

		}

		$el.find('.nh-transition-triggerer').each(function(i, el){

			var
				$triggerer = $(el)
			;

			$triggerer.click(function(e){
				e.preventDefault();

				$cardEl.addClass('opened').addClass('bring-to-front');

				var $contentOverlay = $('<div class="nh-content-overlay"></div>');

				$('#ibm-content-body').append($contentOverlay);

				setTimeout(function(){
					$contentOverlay.addClass('show-up');
				},20);

				// var articleData = app.data.articles[$el.attr('data-post-id')];

				setTimeout(function(){

					var clickThroughTestCase = getURLParameter('transition_option_case');
					clickThroughTestCase = '1';
					if(clickThroughTestCase === '1'){

					//-----------------------------------------------------
					//  open the link
					window.location.href = $triggerer.attr('href');

					}else{
						//-----------------------------------------------------
						//  open an overlay
						$('#story-space-2').append('<div class="nh-content-overlay"><h2 class="title">'+unescape(articleData.title)+'</h2><div class="content-wrap">'+unescape(articleData.content)+'</div><div class="close-button">close</div></div>');

						$('#story-space-2').find('.nh-content-overlay > .close-button').click(function(e){
							$cardEl.removeClass('opened');
							$('#story-space-2').find('.nh-content-overlay > .close-button').unbind('click');
							$('#story-space-2').find('.nh-content-overlay').fadeOut(500, function(){
								$cardEl.removeClass('bring-to-front');
								$('#story-space-2').find('.nh-content-overlay').remove();
							});
						});

						$('#story-space-2').find('.nh-content-overlay').fadeIn(200);
					}

				}, 200);

			});

		}); // end of .nh-transition-triggerer .each...

	} // end of renderCard()

	return app;
})(window.newshub || {}, jQuery);