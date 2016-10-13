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
