;(function ($, window, undefined) {
	'use strict';

	var $doc = $(document),
			win = $(window),
			Modernizr = window.Modernizr,
			scrollTime = null,
			scrollTimer = null;

	var SITE = SITE || {};
	
	SITE = {
		init: function() {
			var self = this,
					obj;
			
			for (obj in self) {
				if ( self.hasOwnProperty(obj)) {
					var _method =  self[obj];
					if ( _method.selector !== undefined && _method.init !== undefined ) {
						if ( $(_method.selector).length > 0 ) {
							if ( _method.dependencies !== undefined ) {
								(function(_async) {
									Modernizr.load([
									{
										load: _async.dependencies,
										complete: function () {
											_async.init();
										}
									}]);
								})(_method);             
							} else {
								_method.init();
							}
						}
					}
				}
			}
		},
		hoverEvents: {
			selector: 'body',
			init: function() {
				var base = this,
						container = $(base.selector);
			  win.on('scroll', function(){
			 		clearTimeout(scrollTime);
			 	  if(!container.hasClass('disable-hover')) {
			 	    container.addClass('disable-hover')
			 	  }
			 	  
			 	  scrollTime = setTimeout(function(){
			 	    container.removeClass('disable-hover')
			 	  },400);
			 	});
			}
		},
		categoryColors: {
			selector: '#nav a, .extendmenu a',
			init: function() {
				var base = this,
						container = $(base.selector);
        
        container.live({
					mouseenter: function() {
            var color = $(this).data('color');
            $(this).css('background-color', color ).css('border-color', color );
					},
          mouseleave: function() {
            $(this).removeAttr("style");
          }
        });
			}
		},
		responsiveNav: {
			selector: '#mobile-toggle',
			target: '#mobile-menu',
			init: function() {
				var base = this,
				container = $(base.selector),
				target = $(base.target);
				container.click(function(){
					target.stop(true,true).slideToggle(500);
					return false;
				});
				
				target.find('ul li').each(function(){
					if($(this).find('> ul').length > 0) {
						$(this).find('> a').append('<span><i class="fa fa-plus"></i></span>');
						$(this).find('li a').prepend('<span><i class="fa fa-angle-right"></i></span>');
					}
				});
				
				target.find('ul li:has(">ul") > a').click(function(){
					$(this).find('i').toggleClass('fa fa-plus').toggleClass('fa fa-minus');
					$(this).parent().find('> ul').stop(true,true).slideToggle();
					return false;
				});
			},
			toggle: function() {
				var deviceAgent = navigator.userAgent.toLowerCase();
				if( win.width() > 767 && deviceAgent.indexOf('ipad') == -1) {
					var base = this,
						target = $(base.target);
					
					target.hide();
				} 
			}
		},
		superfish: {
			selector: '.sf-menu',
			init: function() {
				var base = this,
				container = $(base.selector);
				container.supersubs({
							minWidth:	12,	// minimum width of submenus in em units
							maxWidth:	27,	// maximum width of submenus in em units
							extraWidth:	1	// extra width can ensure lines don't sometimes turn over
						}).superfish({ 
						delay:       100,              // one second delay on mouseout 
						animation:   {height:'show'},  // fade-in and slide-down animation 
						speed:       'fast',           // faster animation speed 
						cssArrows:  false             // disable generation of arrow mark-up 
				});
			}
		},
		megamenu: {
			selector: '.mega-menu',
			init: function() {
				var base = this,
						container = $(base.selector),
						item = container.find('li').has('.category-holder');
						
				
					item.each(function() {
						var that = $(this),
								holder = that.find('.category-holder'),
								list = that.find('.category-holder > ul'),
								subitems = list.find('li'),
								subposts = that.find('.category-children>div'),
								offset = that.offset(),
								w = holder.width();
						
						that.live({
              mouseenter: function () {
								if( offset.left + w > $(window).width() ) {
                  holder.addClass('menu-left');
								}
                holder.stop(true).animate({ height: 'show' });
              },
              mouseleave: function () {
                holder.stop(true).hide( 0, function() {
                  holder.removeClass('menu-left');
                }).removeAttr('style');
              }
            });
            subitems.each(function() {
              var that = $(this);
              that.on('hover', function() {
                var i = that.index(),
                    h = subposts.eq(i).outerHeight() + 40;
                
                subitems.find('a').removeClass('active');
                that.find('a').addClass('active');
                subposts.removeClass('active').eq(i).addClass('active');
                //holder.height(Math.max(h, list.outerHeight()));
                holder.stop(true).animate({ height: 'show' });
              });
            });
					});
				
					SITE.megamenu.control();
			},
			control: function() {
				var base = this,
						container = $(base.selector);
				
				$('<li class="smallmenu"><a href="#" data-color="#222"><i class="fa fa-plus"></i></a><div class="extendmenu"></div></li>').appendTo(container).hide()
				.mouseenter(function() {
					container.find('.extendmenu').stop(true).animate({ height: 'show' });
				})
				.mouseleave(function() {
          container.find('.extendmenu').stop(true).hide().removeAttr('style');
				});
				
				function organizeMenuItems(){
					var containerWidth = $(base.selector).width(),
							smallMenuWidth = $(".smallmenu").width(),
							widthSum = 0;
							
					container.find('>li:not(.smallmenu)').each(function(){
						widthSum += $(this).outerWidth(true);
						if (widthSum + smallMenuWidth > containerWidth)
							$(this).hide();
						else
							$(this).show();
					});
					
					var hiddenItems = container.find('>li:not(.smallmenu):not(:visible)');
					
					if (hiddenItems.length > 0)
						$(".smallmenu").show();
					else
						$(".smallmenu").hide();

					container.find('.extendmenu').html(hiddenItems.find('>a').clone());
				}
				organizeMenuItems();

				win.on('resize', function() {
					organizeMenuItems();
				});
			}
		},
		shareThisArticle: {
			selector: '#sharethispost',
			init: function() {
				var base = this,
						container = $(base.selector),
						done;
				
				container.toggle(function() {
          container.add(container.find('.placeholder')).animate({ height: 40}, function() {
          	// COMMENTING OUT SHARRRE STUFF, USING ADDTHIS BUTTONS INSTEAD
            // if(!done) {
            //   container.find('.placeholder').sharrre({
            //     share: {
            //       googlePlus: true,
            //       facebook: true,
            //       linkedin: true,
            //       twitter: true,
            //       pinterest: true
            //     },
            //     buttons: {
            //       googlePlus : {
            //         annotation: 'bubble'
            //       },
            //       facebook: {
            //         width: '85',
            //       },
            //     },
            //     enableHover: false,
            //     enableCounter: false,
            //     enableTracking: false
            //   });
            //   done = true;
            // }

            if(!done) {
            	container.find('.placeholder').toggle();
            	done = true;
            }

            container.find('i').removeClass('fa-plus').addClass('fa-minus');
          });
        }, function() {
          container.add(container.find('.placeholder')).animate({ height: 0}, 600, function() {
            container.find('i').removeClass('fa-minus').addClass('fa-plus');
          });
        });
      }
    },
		endPage: {
			selector: '#endpage-box',
			init: function() {
				var base = this,
						container = $(base.selector),
						close = container.find('.close');
						
				if ( win.width() > 767 && ($.cookie('end_page_box') !== 'hide') ){
					container.endpage_box({
            animation: "slide",  // There are several animations available: fade, slide, flyInLeft, flyInRight, flyInUp, flyInDown, or false if you don't want it to animate. The default value is fade.
            from: "50%",
            to: "110%"
					});
					
					close.on('click', function() {
						container.hide().remove();
						$.cookie('end_page_box', 'hide', { expires: 1 });
						return false;
					});
				}
			}
		},
		scrollBubble: {
			selector: '#scrollbubble',
			init: function() {
				var base = this,
						container = $(base.selector);
						
				if ( win.width() > 940 ){
					var viewportHeight = win.height(),
							scrollbarHeight = viewportHeight / $doc.height() * viewportHeight,
							progress = win.scrollTop() / ($doc.height() - viewportHeight),
							distance = progress * (viewportHeight - scrollbarHeight) + scrollbarHeight / 2 - container.height() / 2;
							
							
					container.css('top', distance).text(Math.round(progress * 100) + '%').fadeIn(100);
					
					if (scrollTimer !== null) {
						clearTimeout(scrollTimer);
					}
					scrollTimer = setTimeout(function() {
						container.fadeOut();
					}, 1000);
				}
			}
		},
		flex: {
			selector: '.flex',
			init: function() {
				var base = this,
						container = $(base.selector);
				container.each(function() {
					var that = $(this),
							controls = (that.data('controls') === false ? false : true),
							bullets = (that.data('bullets') === false ? false : true);
					that.imagesLoaded(function() {
						that.removeClass('flex-start');
						that.flexslider({
							animation: "slide",
							directionNav: controls,
							controlNav: bullets,
							animationSpeed: 800,
							useCSS: false,
							prevText: '<i class="fa fa-angle-left"></i>',
							nextText: '<i class="fa fa-angle-right"></i>'
						});
					}); 
						
				});
			}
		},
		carousel: {
			selector: '.owl',
			init: function() {
				var base = this,
						container = $(base.selector);
						
				container.each(function() {
					var that = $(this),
							columns = that.data('columns'),
							navigation = (that.data('navigation') === true ? true : false),
							autoplay = (that.data('autoplay') === false ? false : true),
							pagination = (that.data('pagination') === true ? true : false);
					
					that.owlCarousel({
            //Basic Speeds
            slideSpeed : 600,
            
            //Autoplay
            autoPlay : autoplay,
            goToFirst : true,
            stopOnHover: true,
            
            // Navigation
            navigation : navigation,
            navigationText : ['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
            pagination : pagination,
            
            // Responsive
            responsive: true,
            items : columns,
            itemsDesktop: false,
            itemsDesktopSmall : [980,(columns < 3 ? columns : 3)],
            itemsTablet: [768,(columns < 2 ? columns : 2)],
            itemsMobile : [479,1]
					});
				});
			}
		},
		headerCarousel: {
			selector: '#header-webinar-banner',
			init: function() {
				var base = this,
					container = $(base.selector),
					controls = base.selector + " .owl-controls";

				container.each(function() {
					var that = $(this);

					that.owlCarousel({
						//Basic Speeds
						slideSpeed : 600,

						//Autoplay
						autoPlay : true,
						goToFirst : true,
						stopOnHover: true,

						// Navigation
						navigation : false,
						navigationText : ['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
						pagination : true,

						// Responsive
						responsive: true,
						items : 1,
						singleItem: true,
						loop : true,

						afterMove: function() {
							alternate_bg();
						}
					});
				});

				$( controls ).prependTo( container );
				$( controls ).wrap( "<div class='row controls'><div class='twelve columns'></div></div>" );
				$( '<div class="close">X</div>').insertAfter( controls );

				// handle closing the box and keeping it closed via cookies
				$( base.selector + " .close").click(function(e) {
					e.preventDefault();
					e.stopPropagation();
					close_webinar_slider();
				});
				if (document.cookie.indexOf("hasCloseEvents=true") == -1) {
					jQuery( base.selector ).addClass('open');
				}
				function close_webinar_slider() {
					jQuery('#header-webinar-banner').css('display', 'none');
					var later = new Date();
					later.setDate(later.getDate() + 1);
					document.cookie = "hasCloseEvents=true;expires=" + later.toGMTString();
				}
				function alternate_bg() {
					if (jQuery('#header-webinar-banner div.owl-wrapper-outer div.owl-wrapper div.owl-item').length > 1) {
						jQuery('#header-webinar-banner').toggleClass('alt');
					}
				}

			}
		},

		toggle: {
			selector: '.toggle .title',
			init: function() {
				var base = this,
				container = $(base.selector);
				container.each(function() {
					$(this).toggle(function(){
						$(this).addClass("toggled").find('i').removeClass('fa fa-plus').addClass('fa fa-minus').end().closest('.toggle').find('.inner').slideDown(400);
						}, function () {
						$(this).removeClass("toggled").find('i').removeClass('fa fa-minus').addClass('fa fa-plus').end().closest('.toggle').find('.inner').slideUp(400);
					});
				});
			}
		},
		homeAjax: {
			selector: '#recentnews',
			loadmore: '#loadmore',
			init: function() {
				var base = this,
				loadmore = $(base.loadmore),
				page = 1;
				
				loadmore.live('click', function(){
					var text = loadmore.text(),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							action = loadmore.data('action');
					
					loadmore.text(loading).addClass('active');
					
					$.post( themeajax.url, { 
					
							action: action,
							count : count,
							page : page++
							
							
					}, function(data){
						
						var d = $.parseHTML(data),
								l = ($(d).length - 1) / 2;
								
						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							data = '';
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {

								return false;
							});
							
						} else if (l < count){
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
							$(d).insertBefore(loadmore).hide();
							var i = 0;
							$(d).each(function() {
								$(this).delay(i*100).slideDown('100');
								i++;
							});
							return false;
						} else{
							
							loadmore.text(text).removeClass('active');
							
							$(d).insertBefore(loadmore).hide();
							var f = 0;
							$(d).each(function() {
								$(this).delay(f*100).slideDown('100');
								f++;
							});
						}
					});
					return false;
				});
			}
		},
		contributorAjax: {
			selector: '#main-contributors',
			loadmore: '#loadmore',
			init: function() {
				var base = this,
				loadmore = $(base.loadmore),
				page = 1;
				
				loadmore.live('click', function(){
					var text = loadmore.text(),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							action = loadmore.data('action');
					
					loadmore.text(loading).addClass('active');
					
					$.post( themeajax.url, { 
					
							action: action,
							count : count,
							page : page++
							
							
					}, function(data){
						
						var d = $.parseHTML(data),
								l = ($(d).length - 1) / 2;
								
						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							data = '';
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
						} else if (l < count){
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
							$(d).insertBefore(loadmore).hide();
							var i = 0;
							$(d).each(function() {
								//$(this).delay(i*100).slideDown('100');
								$(this).slideDown('100');
								i++;
							});
							return false;
						} else{
							
							loadmore.text(text).removeClass('active');
							
							$(d).insertBefore(loadmore).hide();
							var f = 0;
							$(d).each(function() {
								//$(this).delay(f*100).slideDown('100');
								$(this).slideDown('100');
								f++;
							});
						}
					});
					return false;
				});
			}
		},
		webinarAjax: {
			selector: '#ondemand-webinars',
			loadmore: '#loadmore',
			init: function() {
				var base = this,
					loadmore = $(base.loadmore),
					page = 1;

				loadmore.live('click', function(){
					var text = loadmore.text(),
						loading = loadmore.data('loading'),
						nomore = loadmore.data('nomore'),
						count = loadmore.data('count'),
						action = loadmore.data('action');

					loadmore.text(loading).addClass('active');

					$.post( themeajax.url, {

						action: action,
						count : count,
						page : page++


					}, function(data){
						var d = $.parseHTML(data),
							l = ($(d).length - 1) / 2;

						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							data = '';
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});

						} else if (l < count){
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});

							$(d).insertBefore(loadmore).hide();
							var i = 0;
							$(d).each(function() {
								//$(this).delay(i*100).slideDown('100');
								$(this).slideDown('100');
								i++;
							});
							return false;
						} else{

							loadmore.text(text).removeClass('active');

							$(d).insertBefore(loadmore).hide();
							var f = 0;
							$(d).each(function() {
								//$(this).delay(f*100).slideDown('100');
								$(this).slideDown('100');
								f++;
							});
						}
					});
					return false;
				});
			}
		},
		mediaAjax: {
			selector: '#media-page',
			loadmore: '#loadmore',
			init: function() {
				var base = this,
				loadmore = $(base.loadmore),
				page = 1;
				
				loadmore.live('click', function(){
					var text = loadmore.text(),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							action = loadmore.data('action'),
							category = loadmore.data('category');

					loadmore.text(loading).addClass('active');
					
					$.post( themeajax.url, { 
					
							action: action,
							category: category,
							count : count,
							page : page++
							
							
					}, function(data){
						
						var d = $.parseHTML(data),
								l = ($(d).length - 1) / 2;
								
						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							data = '';
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
						} else if (l < count){
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
							$(d).insertBefore(loadmore).hide();
							var i = 0;
							$(d).each(function() {
								//$(this).delay(i*100).slideDown('100');
								$(this).slideDown('100');
								i++;
							});
							return false;
						} else{
							
							loadmore.text(text).removeClass('active');
							
							$(d).insertBefore(loadmore).hide();
							var f = 0;
							$(d).each(function() {
								//$(this).delay(f*100).slideDown('100');
								$(this).slideDown('100');
								f++;
							});
						}
					});
					return false;
				});
			}
		},
		categoryAjax: {
			selector: '#category',
			loadmore: '#loadmore',
			init: function() {
				var base = this,
				loadmore = $(base.loadmore),
				page = 1;
				
				loadmore.live('click', function(){
					var text = loadmore.text(),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							catid = loadmore.data('catid'),
							action = loadmore.data('action');
					
					loadmore.text(loading).addClass('active');
					
					$.post( themeajax.url, { 
					
							action: action,
							count : count,
							catid : catid,
							page : page++
							
							
					}, function(data){
						
						var d = $.parseHTML(data),
								l = ($(d).length - 1) / 2;
								
						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							data = '';
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
						} else if (l < count){
							loadmore.text(nomore).removeClass('active').die("click").on('click', function() {
								return false;
							});
							
							$(d).insertBefore(loadmore).hide();
							var i = 0;
							$(d).each(function() {
								$(this).delay(i*100).slideDown('100');
								i++;
							});
							return false;
						} else{
							
							loadmore.text(text).removeClass('active');
							
							$(d).insertBefore(loadmore).hide();
							var f = 0;
							$(d).each(function() {
								$(this).delay(f*100).slideDown('100');
								f++;
							});
						}
					});
					return false;
				});
			}
		},
		likethis: {
			selector: '.likeThis',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				container.live('click', function() {
					
					var that = $(this),
							id = that.data('id'),
							blogurl = $('body').data('url');
					
					if (that.hasClass('active')) {
						return false;
					} else {
						$.ajax({
							type: "POST",
							url: blogurl + "/index.php",
							data: "likepost=" + id,
							beforeSend: function() {
								$('.likeThis[data-id='+id+']').find('i').removeClass('fa fa-heart-o').addClass('fa fa-refresh fa-spin');
							},
							success: function() {
								var text = $('.likeThis[data-id='+id+']').html(),
										patt= /(\d)+/,
										num = patt.exec(text);
										
								num[0]++;
								text = text.replace(patt,num[0]);
								$('.likeThis[data-id='+id+']').html(text);
								$('.likeThis[data-id='+id+']').find('i').removeClass('fa fa-refresh fa-spin').removeClass('fa fa-heart-o').addClass('fa fa-heart');
								that.addClass("active");
							}
						});
					}
					return false;
				});
			}
		},
		blogMasonry: {
			selector: '.masonry',
			init: function() {
				var base = this,
				container = $(base.selector);
				
				$(window).load(function() {
					container.isotope({
						itemSelector : '.item',
						layoutMode : 'fitRows',
						resizable: false,
						animationOptions: {
							duration: 1000,
							easing: 'linear',
							queue: false
						}
					});
				});
				base.resize(container);
			},
			resize: function(container) {
				$(window).smartresize(function(){
						container.isotope({
						masonry: { columnWidth: container.width() / 3 }
					});	
				});
			}
		},
		magnific: {
			selector: '[rel=magnific], .wp-caption a',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				
				container.each(function() {
					$(this).magnificPopup({
						type: 'image',
						closeOnContentClick: true,
						closeBtnInside: false,
						fixedContentPos: true,
						removalDelay: 300,
						mainClass: 'my-mfp-slide-bottom',
						image: {
							verticalFit: true
						}
					});
				});
	
			}
		},
		magnificGallery: {
			selector: '[rel=gallery]',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				container.each(function() {
					$(this).magnificPopup({
						delegate: 'a',
						type: 'image',
						closeOnContentClick: true,
						closeBtnInside: false,
						fixedContentPos: true,
						removalDelay: 300,
						mainClass: 'my-mfp-slide-bottom',
						gallery: {
							enabled: true,
							navigateByImgClick: true,
							preload: [0,1] // Will preload 0 - before current, and 1 after the current image
						},
						image: {
							verticalFit: true,
							titleSrc: function(item) {
								return item.el.attr('title');
							}
						}
					});
				});
	
			}
		},
		
		tooltip:{
			selector: '.tip',
			init: function(){
				$(document).tooltip({
		          	items: this.selector,
		          	position: { my: "center top+15", at: "center bottom", collision: "flipfit" },
		         	tooltipClass: "tooltip-widget",
		          	content: function () {
		          		var _text = $(this).attr('title');
		              	var frame = "<span class='arrow-up'></span>" + _text;
		              	return frame;

		          	}
		      	});

		      	/*====================================
		      	=            Tablets fix             =
		      	====================================*/
		      	
		      	$(this.selector).on('touchstart',function(){
		      		var _text = $(this).attr('title');
		      		if($('.tooltip-tablets').length > 0){
		      			$('.tooltip-tablets').remove();
		      		}else{
		      			setTimeout(function() {
		      				$('.tip').after('<div class="tooltip-tablets"><span class="arrow-up"></span>'+_text+'</div>');
		      			}, 10);
		      		}
		      	});

		      	$(document).on('click touchstart',function(){
		      		$('.tooltip-tablets').remove();
		      	});
			}	
		},
		produtList:{
			selector: '.info-list',
			init: function(){
				var list = $(this.selector),
					btn = $('.product_btn');
				
				btn.on('click',function(event){
					event.preventDefault();
					list.toggleClass('short');
					list.hasClass('short')? btn.text('View All').attr('title', 'View All') : btn.text('Short View').attr('title', 'Short View');
				});
			}
		},
		thumbnailGallery:{
			selector: '.fancybox',
			init: function(){
				$(this.selector).fancybox({
					transitionIn	:	'elastic',
					transitionOut	:	'elastic',
					overlayShow	:	false
				});
			}
		},
		parsley: {
			selector: '.comment-form, .wpcf7-form',
			init: function() {
				var base = this,
						container = $(base.selector);
				
				if ($.fn.parsley) {
					container.parsley();
				}
			}
		},
		contact: {
			selector: '#contact-map',
			init: function() {
				var base = this,
						container = $(base.selector),
						mapzoom = container.data('map-zoom'),
						maplat = container.data('map-center-lat'),
						maplong = container.data('map-center-long'),
						mapinfo = container.data('pin-info'),
						pinimage = container.data('pin-image');
	
						
				
				var latLng = new google.maps.LatLng(maplat,maplong);
				
				var mapOptions = {
						center: latLng,
						zoom: mapzoom,
						mapTypeId: google.maps.MapTypeId.ROADMAP,
						scrollwheel: false,
						panControl: true,
						zoomControl: 1,
						mapTypeControl: false,
						scaleControl: false,
						streetViewControl: false
					};
				
				var map = new google.maps.Map(document.getElementById("contact-map"), mapOptions);
				
				google.maps.event.addListenerOnce(map, 'tilesloaded', function() {
						var venuemarker = new google.maps.Marker({
								position: latLng,
								map: map,
								icon: pinimage,
								animation: google.maps.Animation.DROP
						});
						map.setCenter(latLng);
						
					if (mapinfo) { 
						var infowindow = new google.maps.InfoWindow({
								content: '<div id="content"><div id="bodyContent"><p>'+mapinfo+'</p></div></div>'
						});
						
						infowindow.open(map,venuemarker);
						
						map.setCenter(latLng);
					
					}
				});
				
			}
		},
		styleSwitcher: {
			selector: '#style-switcher',
			init: function() {
				var base = this,
				container = $(base.selector),
				toggle = container.find('.style-toggle'),
				onoffswitch = container.find('.switch');
				
				toggle.on('click', function() {
					container.add($(this)).toggleClass('active');
					return false;
				});
				
				onoffswitch.each(function() {
					var that = $(this);
					$(this).find('a').on('click', function() {
						that.find('a').removeClass('active');
						$(this).addClass('active');
						
						if ($(this).parents('ul').data('name') === 'header') {
							$(document.body).removeClass('notfixed');
							$(document.body).addClass($(this).data('class'));
							
							$('#header, #header .logo a, #header .desktop-menu ul, #header .desktop-menu .searchlink, .headersearch').attr( "style", "" );
							$('#header').removeClass('fixed').removeClass('small');
							$('#header').addClass($(this).data('class2'));
						}
						return false;
					});
				});
				
				var style = $('<style type="text/css" id="theme_color" />').appendTo('head');
				container.find('.first').minicolors({
					defaultValue: $('.first').data('default'),
					change: function(hex) {
						style.html('.sf-menu li.current-menu-item, .sf-menu li ul li:hover, .owl-buttons>div:hover, .jp-interface, .filters li a.active, .filters li a:hover, .iconbox.left > span, .iconbox.right > span, ul.accordion > li.active div.title, .toggle .title.toggled, .btn, input[type=submit], .comment-reply-link, .label.red, .dropcap.boxed, .bargraph > span span, .pagenavi ul li.disabled a, .mobile-menu ul li a.active, .taglink:hover, .widget.widget_tag_cloud li > a:hover { background:'+hex+'; } #breadcrumb .name > div { border-color: '+hex+'; } a:hover, .iconbox.top > span { color: '+hex+'; } ::-webkit-selection{ background-color: '+hex+'; } ::-moz-selection{ background-color: '+hex+'; } ::selection{ background-color: '+hex+'; } ');	
					}
				});
				container.find('.second').minicolors({
					defaultValue: $('.second').data('default'),
					change: function(hex) {
						style.html('.flex .bulletrow .flex-control-nav.flex-control-paging a.flex-active, .pricing .item.featured .header, .flex .bulletrow .flex-control-nav.flex-control-paging a:hover, .btn.red, input[type=submit].red, .comment-reply-link.red { background:'+hex+'; } blockquote.styled, .post .post-gallery.quote, .widget.widget_calendar table caption { border-color: '+hex+'; } .iconbox.top:hover > span, .testimonials.flex blockquote p cite, .widget.widget_calendar table caption, .fresco .overlay .details, .fresco .overlay .zoom, .fresco .overlay .static { color: '+hex+'; }');	
					}
				});
			}
		},
		fitvids: {
			selector: '.post',
			init: function() {
				var container = $(this.selector);
				$(container).fitVids();
			}
		},
		event24RegisterForm : {
			selector : '#event24-register-form',
			thank_you_selector : '#div_on24_thank_you',
			form_div_selector : '#div_on24_register',
			init: function(){
				$(this.thank_you_selector).fadeOut(10);
				$(this.selector).validate({
					rules: {
						firstname: {
							required: true,
						},
						lastname:  {
							required: true,
						}, 
						email: {
							required: true,
							email: true
						},
						company: {
							required: true
						},
						job_title: {
							required: true
						},
						work_phone: {
							required: true,
							number: true
						},
						country: 'required'
					},
					messages: {
						firstname: {
							required: 'Please enter your first name',
							minlength: 'Your first name must be at least 3 characters long'
						},
						lastname: {
							required: 'Please enter your last name',
							minlength: 'Your last name must be at least 3 characters long'
						},
						email: {
							required: 'Please provide a valid email',
							minlength: 'Your email must be at least 3 characters long'
						},
						copany: {
							required: 'Please enter your company name',
							minlength: 'Your company name must be at least 4 characters long'
						},
						job_title: {
							required: 'Please enter your job title',
							minlength: 'Your job title must be at least 4 characters long'
						},
						work_phone: {
							required: 'Please enter a valid number'
						},
						country : 'Please select a country'
					}
				});
				$(this.selector).on('submit',function(){
					$('#div_on24_register').fadeOut(400);					
					$('#div-post-event-the-content').fadeOut(400);										
					$('#div_on24_thank_you').delay(400).fadeIn(400);
				})
			}
		},		
		xforceLandingChart: {
			selector: '#xforce-chart',
			init: function() {
				var data = {},
					base = this;


				data.action = "xforce_chart_data_ajax",

				$.ajax({
					type: "POST",
					url: ajaxurl,
					data: data,
					dataType: 'json',
					success: function (data) {
						SITE.xforceLandingChart.create_chart(data);
					}
				});

				$(window).resize(function() {
					var col_w = $('.chart-column').width();
					base.resize(col_w);
				});
			},
			create_chart: function(data) {					
				$(this.selector).highcharts({
					chart: {
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false,
						events: {
			            load: function(event) {
			            	var col_w = $('.chart-column').width(),
			            		chart = $('#xforce-chart').highcharts(),
			            		options = chart.options;
			                if(window.innerWidth < 400){
								$('#xforce-chart').addClass('mobile-graph').highcharts().setSize(col_w+50, 180, true);
								}
				            }
				        }
					},
					credits: {
					    enabled: false
					},
					title: {
						text: ''
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							innerSize: '18%',
							dataLabels: {
								enabled: true,
								format: '<b>{point.name}</b>: {point.percentage:.1f} %',
								connectorWidth: 3,
								distance: 10,
								connectorPadding: 15,
								style: {
									fontSize: '12px',
									fontFamily: 'Helvetica',
									color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
								}
							}
						}
					},
					series: [{
			            type: 'pie',
			            name: 'Current Vulnerabilities by Vendor',
			            data: data
			         }]
				});
			},
			resize: function(col_w){
				if(window.innerWidth < 400){
					$('#xforce-chart').addClass('mobile-graph').highcharts().setSize(col_w+50, 180, true);
				}else{
					$('#xforce-chart').removeClass('mobile-graph').highcharts().setSize(col_w, 400, true);
				}
			}
		},
		xforceFilterToggle: {
			selector: '.xff-toggle',
			init: function() {
				$( this.selector ).click(function(e) {
					e.preventDefault();
					$( '.xff-content, .xfhh-close' ).toggleClass('open');
				});
			}
		},
		xforceFilterAjax: {
			selector: '.xforce-table .xft-more',
			loadmore: '.xforce-table .xft-more #loadmore',
			form: '.xff-form :input',			
			txtsearch: '.xff-form #xfff-search',			
			init: function() {
				var form = $(this.form),
						base = this,
						loadmore = $(base.loadmore),
						selector = $(base.selector),
						page = 1,
						change_event = "change",
						txtsearch = $(this.txtsearch);

				var userAgent = navigator.userAgent;						
				if (userAgent.indexOf("MSIE ") > -1 || userAgent.indexOf("Trident/") > -1) {
					$(txtsearch).on('keyup', function(e) {
					    if(e.keyCode == 13)
					    {
					    	$( this ).trigger(change_event);
					    }
					});
				}

				$( form ).on(change_event, function() {
						var text = loadmore.data('more'),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							action = loadmore.data('action'),
							data_form = $('.xff-content form.xff-form').serializeArray(),
							types = [],
							search = $('#xfff-search').val(),
							cvss_from = $('#xfff-cvss-from').val(),
							cvss_to = $('#xfff-cvss-to').val(),
							propagation = $('#xfff-propagation').val(),
							consequences = $('#xfff-consequences').val();

					$('.no-post').hide();
					loadmore.text(loading).addClass('active').show();					
					// remove the existing results
					$( ".xft-item" ).fadeOut( 300, function() {
						$( this ).remove(); // fade out and remove from dom entirely
					});

					// populate new results
					if ($('#xfff-type1')[0].checked){
						types[types.length] = $('#xfff-type1').val();
					}
					if ($('#xfff-type2')[0].checked){
						types[types.length] = $('#xfff-type2').val();
					}
					if ($('#xfff-type3')[0].checked){
						types[types.length] = $('#xfff-type3').val();
					}

					

					data_form = $.extend(data_form, [
						{name: 'action', value: 'xforce_loadmore_ajax'},
						{name: 'count', value: 10},
						{name: 'page', value: 1},
						{name: 'xfff-type[]', value: types},
						{name: 'xfff-search', value: search},
						{name: 'xfff-cvss-from', value: cvss_from},
						{name: 'xfff-cvss-to', value: cvss_to},
						{name: 'xfff-propagation', value: propagation},
						{name: 'xfff-consequences', value: consequences}
					]);
					
					document.page_xforce_center = 1;

					$.post( themeajax.url, data_form, function(data){

						var d = $.parseHTML(data),
							l = ($(d).length - 1) / 2;

						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							data = '';
							loadmore.text(nomore).removeClass('active').hide();
							$('.no-post').show();

						} else if (l < count){
							loadmore.text(nomore).removeClass('active').hide();
							$('.no-post').show();

							$(d).insertBefore(selector).hide();
							var i = 0;
							$(d).each(function() {
								$(this).slideDown('100');
								i++;
							});
							return false;
						} else{
							$('.no-post').hide();
							loadmore.text(text).removeClass('active').show();
							$(d).insertBefore(selector);
							var f = 0;
							$(d).each(function() {
								$(this).slideDown('100');
								f++;
							});
						}
					});
				});
			}
		},
		xforceResetSearch:{
			reset: '.xfff-reset',
			selector: '.xforce-table .xft-more',
			loadmore: '.xforce-table .xft-more #loadmore',
			form: '.xff-form :input',

			init: function(){
				var form = $(this.form),
						base = this,
						loadmore = $(base.loadmore),
						selector = $(base.selector),
						page = 1;

				$(this.reset).on('click',function(event){
					var text = loadmore.data('more'),
						loading = loadmore.data('loading'),
						nomore = loadmore.data('nomore'),
						count = loadmore.data('count'),
						action = loadmore.data('action');

					event.preventDefault();
					$('.no-post').hide();											
					loadmore.text(loading).addClass('active').show();
					document.page_xforce_center = 1;

					$('.xff-form')[0].reset();
					
					// remove the existing results
					$( ".xft-item" ).fadeOut( 300, function() {
						$( this ).remove(); // fade out and remove from dom entirely
					});


					var data_form = [
						{name: 'action', value: action},
						{name: 'count', value: count},
						{name: 'page', value: page},
					];
					
					$.post( themeajax.url, data_form, function(data){
						
						var d = $.parseHTML(data),
								l = ($(d).length - 1) / 2;
								
						if( data === '' || data === 'undefined' || data === 'No More Posts to Show' || data === 'No $args array created') {
							$('.no-post').show();
							data = '';
							loadmore.text(nomore).removeClass('active').hide();
							
						} else if (l < count){
							$('.no-post').show();
							loadmore.text(nomore).removeClass('active').hide();
							
							$(d).insertBefore(selector).hide();
							var i = 0;
							$(d).each(function() {
								$(this).slideDown('100');
								i++;
							});
							return false;
						} else{
							$('.no-post').hide();							
							loadmore.text(text).removeClass('active');

							$(d).insertBefore(selector);
							var f = 0;
							$(d).each(function() {
								$(this).slideDown('100');
								f++;
							});
						}
					});

				});
			}
		},
		loadMoreXforceCenter: {
			reset: '.xfff-reset',			
			selector: '.xforce-table .xft-more',
			loadmore: '.xforce-table .xft-more #loadmore',
			form: '.xff-form :input',
				
			init: function() {
				var form = $(this.form),
						base = this,
						loadmore = $(base.loadmore),
						selector = $(base.selector);

				document.page_xforce_center = 1;
				
				loadmore.live('click', function() {
					var text = loadmore.data('more'),
							loading = loadmore.data('loading'),
							nomore = loadmore.data('nomore'),
							count = loadmore.data('count'),
							action = loadmore.data('action'),
							data_form = $('.xff-content form.xff-form').serializeArray(),
							types = [],
							search = $('#xfff-search').val(),
							cvss_from = $('#xfff-cvss-from').val(),
							cvss_to = $('#xfff-cvss-to').val(),
							propagation = $('#xfff-propagation').val(),
							consequences = $('#xfff-consequences').val();

					$('.no-post').hide();						
					loadmore.text(loading).addClass('active').show();
					
					document.page_xforce_center++;					

					if ($('#xfff-type1')[0].checked){
						types[types.length] = $('#xfff-type1').val();
					}
					if ($('#xfff-type2')[0].checked){
						types[types.length] = $('#xfff-type2').val();
					}
					if ($('#xfff-type3')[0].checked){
						types[types.length] = $('#xfff-type3').val();
					}
					
					data_form = $.extend(data_form, [
						{name: 'action', value: action},
						{name: 'count', value: count},
						{name: 'page', value: document.page_xforce_center},
						{name: 'xfff-type[]', value: types},
						{name: 'xfff-search', value: search},
						{name: 'xfff-cvss-from', value: cvss_from},
						{name: 'xfff-cvss-to', value: cvss_to},
						{name: 'xfff-propagation', value: propagation},
						{name: 'xfff-consequences', value: consequences}
					]);
					
					$.post( themeajax.url, data_form, function(data){
						
						var d = $.parseHTML(data),
								l = ($(d).length - 1) / 2;
								
						if( data === '' || data === 'undefined' || data === 'No More Posts' || data === 'No $args array created') {
							$('.no-post').show();
							data = '';
							loadmore.text(nomore).removeClass('active').hide();
							
						} else if (l < count){
							$('.no-post').show();
							loadmore.text(nomore).removeClass('active').hide();
							
							$(d).insertBefore(selector).hide();
							var i = 0;
							$(d).each(function() {
								$(this).slideDown('100');
								i++;
							});
							return false;
						} else{
							$('.no-post').hide();							
							loadmore.text(text).removeClass('active');

							$(d).insertBefore(selector);
							var f = 0;
							$(d).each(function() {
								$(this).slideDown('100');
								f++;
							});
						}
					});
					return false;
				});
			}
		},
		loadMenuIpad: {
			selector: '#subheader',
			selector_btn_container: '#subheader .row .mobile-one',
			selector_hidden: '.hide-for-small',		
			selector_hidden_menu: '#nav.hide-for-small',		
			selector_btn: '#mobile-toggle',	
				
			init: function() {
				/*
				var deviceAgent = navigator.userAgent.toLowerCase();
				if (deviceAgent.indexOf('ipad') > -1 || $('html').hasClass('touch')) {
					$(this.selector).css('height', '50px');
					$(this.selector).css('line-height', '50px');

					$(this.selector_btn_container).attr('style', 'display: block !important; padding: 0px 15px; float: left; width: 25%;');
					$(this.selector_hidden).attr('style', 'display: none !important;');
					$(this.selector_hidden_menu).remove();

					$(this.selector_btn).click(function(){
						target.stop(true,true).slideToggle(500);
						return false;
					});

				}				
				*/
			}
		},
	};
	
	// on Resize & Scroll
	$(window).resize(function() {
		SITE.responsiveNav.toggle();
	});
	$(window).scroll(function(){
		SITE.scrollBubble.init();
	});
	
	$doc.ready(function() {
		FastClick.attach(document.body);

		$.fn.foundationAlerts					? $doc.foundationAlerts() : null;
		$.fn.foundationAccordion			? $doc.foundationAccordion() : null;
		$.fn.foundationTabs						? $doc.foundationTabs() : null;

		SITE.init();
	});

})(jQuery, this);
