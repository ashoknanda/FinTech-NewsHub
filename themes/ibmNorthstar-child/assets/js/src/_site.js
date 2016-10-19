// (function (window,$) {


    
//     // --------------------------------------------
//     // Responsive IFRAMEs

//     var initResponsiveFrames = function() {

//         var container   = $('.ibm-blog__article-content');
//         var frames      = container.find('IFRAME'); 


//         // ---

//         var onResize = function() {
//             frames.each(setSize);
//         };

//         var setSize = function() {

//             var width = container.width();
//             var height = width * $(this).data('ratio');

//             $(this).width(width);
//             $(this).height(height);

//         };

//         var setRatio = function() {

//             // Requires explicit width and height
//             if (!$(this).attr('width') || !$(this).attr('height')) return false;

//             var ratio = ($(this).attr('height') / $(this).attr('width')).toPrecision(4);

//             $(this).data('ratio', ratio);

//         };

//         var init = function() {

//             // Store the ratio, this is used to calculate future size
//             frames.each(setRatio);

//             $(window).resize(onResize).trigger('resize');

//         };


//         // ---

//         init();

//     };


//     // --------------------------------------------
//     // Social Sharing Icons

//     var initSocialSharing = function() {

//         var share_buttons = $(".share_buttons");

//         // Trickery to get Firefox to open this in a popup window
//         // https://github.com/tabalinas/jssocials/issues/16
//         window.openShareWindow = function(url) {
//             window.open(url, 'Sharing', 'menubar=no,width=500,height=500');
//         };

//         share_buttons.jsSocials({
//             _getShareUrl: function() {
//                 var url = jsSocials.Socials.prototype._getShareUrl.apply(this, arguments);
//                 return "javascript:window.openShareWindow('" + url + "');";
//             },
//             showLabel: false,
//             showCount: false, 
//             shares: ["twitter", "facebook", "googleplus", "email"]
//         });

//         // Make sure the actual button doesn't have a blank target.
//         share_buttons.find("a").removeAttr("target");

//     };

//     // --------------------------------------------
//     // Header Fading logo

//      var initHeaderCycle = function() {

//         var fader       = $('.ibm-blog__header-logo .slides');
//         var slides      = fader.find('DIV');
//         var current     = 0;
//         var count       = (slides.length - 1);
//         var speed       = 5000;

//         // ---

//         var startCycle   = function() {

//             var next_position   = (current == count) ? 0 : (current+1);
//             var next_slide      = slides.eq(next_position);

//             current = next_position;

//             $(next_slide)
//                 .css({'opacity': 0})
//                 .addClass('incoming')
//                 .animate({opacity: 1}, speed, finishCycle);

//         };

//         var finishCycle   = function() {

//             slides.removeClass('current');
//             slides.removeClass('incoming');
//             $(this).addClass('current');

//             startCycle();

//         };

//         // ---

//         startCycle();

//     };

//     var initResponsiveImages = function(){
//         var $lead_image = $('#ibm-leadspace-head'),
//             $featured_image = $('.ibm-blog__featured .ibm-home-featured-top'),
//             article_lead_images = $('.post-leadspace .w-image'),
//             grid_images = $('.post .ibm-blog__postgrid-item-top');

//         var winW = $(window).width();
//         window.devicePixelRatio = window.devicePixelRatio || window.screen.deviceXDPI / window.screen.logicalXDPI;

//         var updateImage = function($image){
//             //console.log(winW,window.devicePixelRatio);

//             // retina
//             if (typeof window.devicePixelRatio !== "undefined" && window.devicePixelRatio > 1) {
//                 if (winW >= 1200) { 
//                     // 2880
//                     $image.css('background-image','url('+$image.attr('data-desktop-lg-retina')+')');
//                 } else if (winW >= 780 && winW <= 1199) {
//                     // 2400
//                     $image.css('background-image','url('+$image.attr('data-desktop-retina')+')');
//                 } else if (winW >= 380 && winW <= 780) {
//                     // 1200
//                     $image.css('background-image','url('+$image.attr('data-tablet-retina')+')');
//                 } else if (winW <= 379) {
//                     // 780
//                     $image.css('background-image','url('+$image.attr('data-mobile-retina')+')');
//                 }
//             }
//             // non retina
//             else {
//                 if (winW >= 1200) { 
//                     // 1440
//                     $image.css('background-image','url('+$image.attr('data-desktop-lg')+')');
//                 } else if (winW >= 780 && winW <= 1199) {
//                     // 1200
//                     $image.css('background-image','url('+$image.attr('data-desktop')+')');
//                 } else if (winW >= 380 && winW <= 780) {
//                     // 780
//                     $image.css('background-image','url('+$image.attr('data-tablet')+')');
//                 } else if (winW <= 379) {
//                     // 380
//                     $image.css('background-image','url('+$image.attr('data-mobile')+')');
//                 }
//             }
//         }
        


//         $(window).on('resize', function(){
//             winW = $(window).width();
//             updateImage($lead_image);
//             updateImage($featured_image);
            
//             $.each(article_lead_images, function(ai,aimage){
//                 updateImage($(aimage));
//             });
//             $.each(grid_images, function(gi,gimage){
//                 updateImage($(gimage));
//             });
//         });

//         updateImage($lead_image);
//         updateImage($featured_image);

//         $.each(article_lead_images, function(ai,aimage){
//             updateImage($(aimage));
//         });
//         $.each(grid_images, function(gi,gimage){
//             updateImage($(gimage));
//         });

//         // update grid images on load more
//         window.loadGridImages = function(){
//             grid_images = $('.post .ibm-blog__postgrid-item-top');
//             $.each(grid_images, function(gi,gimage){
//                 updateImage($(gimage));
//             });
//         };
        
//     };


//     // --------------------------------------------
//     // Init

//     jQuery(document).ready(function($) {

//         initHeaderCycle();
//         initResponsiveFrames();
//         initResponsiveImages();
//         //initSocialSharing();


//     });

// })(window,jQuery);

function getURLParameter(name) {
  return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search) || [ , "" ])[1] .replace(/\+/g, '%20')) || null;
};

// if there is facetwp parameter, clear it.
var paged = parseInt(getURLParameter('fwp_paged'));
if( isNaN(paged) !== true && window.newshub.urlReset !== true){
	window.newshub.urlReset = true;
	// window.location.href = window.location.href.replace('fwp_paged', '');
	var params = window.location.search.substring(1).split('&');
	var newSearch = '?';
	params.forEach(function(param, i){
		var n = param.split('=');
		if(n[0] === 'fwp_paged'){
			params[i] = '';

		}
		newSearch = newSearch + params[i] +'&';
	});
	window.location.href = window.location.href.replace(window.location.search, newSearch);
}

/*-----------------------------------------------------
 *	browser detection
 */
var browserDetection = (function(obj){
	
	//SETS FUNCTION TO DETECT IE6, IE7 and IE8
	obj.isIE = function(upToVersion){
		var ret = false;
		upToVersion = upToVersion || 9;
		for(var version = 6;version<=upToVersion;version++){
			if(navigator.appVersion.indexOf("MSIE "+version+".") >= 0) ret = true;
		}
		return ret;
	};

	//SETS FUNCTION TO DETECT IE6
	obj.isIE6 = function(){
		return obj.isIE(6);
	};

	//SETS FUNCTION TO DETECT IE7
	obj.isIE7 = function(){
		return obj.isIE(7);
	};

	//SETS FUNCTION TO DETECT IE8
	obj.isIE8 = function(){
		return obj.isIE(8);
	};
	
	//SETS FUNCTION TO DETECT IE9
	obj.isIE9 = function(){
		return obj.isIE(9);
	};

	obj.isSafari = function(){
		return (navigator.appVersion.indexOf("Safari") >= 0) && obj.isChrome() != true;
	};

	obj.isChrome = function(){
		return (navigator.appVersion.indexOf("Chrome") >= 0);
	};

	obj.isWebkit = function(){
		return (navigator.appVersion.indexOf("WebKit") >= 0);
	};
	
	obj.isIpad = function(){
		return (navigator.userAgent.match(/iPad/i) != null);
	};

	obj.isIphone = function(){
		return (navigator.userAgent.match(/iPhone/i) != null);
	};

	obj.isAndroid = function(){
		return (navigator.userAgent.toLowerCase().match(/android/i) != null);
	};
	
	obj.isBlackBerry = function(){
		return navigator.userAgent.match(/BlackBerry/i);
	};
	
	obj.isOperaMini = function(){
		return navigator.userAgent.match(/Opera Mini/i);
	};
	
	obj.isWindowsMobile = function(){
		return navigator.userAgent.match(/IEMobile/i);
	};
	
	obj.isMobilePhone = function(){
		return obj.isIpad()==true || obj.isIphone()==true || obj.isAndroid()==true || obj.isBlackBerry()==true || obj.isOperaMini()==true || obj.isWindowsMobile()==true;
	};
	
	obj.isMobile = function(){
		return obj.isWindowsMobile()==true || obj.isIpad()==true;
	};
	
	obj.isIos = function(){
		return obj.isIphone()==true && obj.isIpad()==true;
	}
	obj.isWorklight = function(){
		return (/(worklight)/).test(navigator.userAgent.toLowerCase());
	}
	obj.isFirefox = function(){
		return navigator.userAgent.toLowerCase().indexOf('firefox')>=0;
	}

	obj.getBrowserString = function(){
		var ret;
		if(obj.isFirefox()==true){
			ret = 'firefox';
		}else if(obj.isChrome()==true){
			ret = 'chrome';
		}else if(obj.isSafari()==true){
			ret = 'safari';
		}else{
			ret = 'other'
		}
		return ret;
	}

	obj.getAppVersion =  function() {
		if (typeof appVer !== 'undefined') return appVer;
	}
	obj.requireAppVersion =  function(required) {
		// returns true if the app version is >= the passed required version
		// best practice to use in conjunction with isWorklight() to make sure you are on the app
		// returns false if the app version is older than required
		// example: required = '2.0.1' -- if required <= getAppVersion return true otherwise false
		var requiredVersion = required.split('.');
		var thisVersion = this.getAppVersion();
		if (!thisVersion) return false; // fail if no global
		thisVersion = thisVersion.split('.');
		// NOTE this logic won't work perfectly across major version numbers, but is ok for minor & patch comparisons
		for (var i = 0; i < thisVersion.length; i++) {
			debug.log('v check:', thisVersion[i], requiredVersion[i], thisVersion[i] < requiredVersion[i]);
			if (thisVersion[i] < requiredVersion[i]) return false; // fail on any part of the version
		}
		return true;
	}

	obj.constants = {
		MOBILE:'mobile',
		DESKTOP:'desktop',
		ALL_PLATFORMS:'*'
	}
	obj.getPlatform = function(){return (typeof(bowser.mobile)!=='undefined' || typeof(bowser.tablet)!=='undefined') ? obj.constants.MOBILE : obj.constants.DESKTOP; }
	
	return obj;
})(browserDetection || {});

//-----------------------------------------------------
//	let's start the show
(function(window, $){

	$(function(){
		console.log('\n\n\n\t\t\t     O O\n\t\t\t   . --- .\n\t\t\t  /| --- |\\\n\t\t\t (_) --- (_)\n\t\t\t      -\n\n\n*********************************************\n\n\tWelcome to IBM Digital Marketing Hub.\n\n*********************************************\n\n\n.');

		$('body').addClass('nh-platform-'+(browserDetection.getPlatform()||'desktop'));

		window.newshub = window.newshub || {};
		window.newshub.$ = $;

		//-----------------------------------------------------
		//	 let's add beta!
		var $beta = $('<span class="beta-designator" style="font-size:0.85em;color:#00B4A0;font-weight:normal;font-family:HelvBoldIBM;margin-left:0.5em;display:none;padding-right:1em;">BETA</span>');
		$("header .ibm-sitenav-menu-name a").append($beta);
		setTimeout(function(){
			$("header .ibm-sitenav-menu-name a .beta-designator").fadeIn(1000);
		}, 500);

	});
})(window, jQuery);