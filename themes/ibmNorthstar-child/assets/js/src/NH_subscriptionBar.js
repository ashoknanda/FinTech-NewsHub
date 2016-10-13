jQuery(function(){

  window.newshub = (function(app, $, cookieManager){
    console.log('NH_subscriptionBar.js:app===', app);

    app.subscriptionBar = (function(module, $, cookieManager){

      var 
        $theBar = $('#nh-social-bar'),
        $theChevron = $theBar.find('.minimized-cta'),
        $theForm = $theBar.find('.nh-subscribe-form'),
        $theCloseButton = $theBar.find('.ibm-close-link'),
        COOKIE_NAME = 'ibm-digital-marketing-hub-subscriptionbar',
        lSource = getURLParameter('sp_lsource')
      ;

      // window resize
      function onWindowResize(e){
        // console.log('onWindowResize...');

        if(
          $theBar.is('.user-touched') !== true
          && $('body').is('.home') === true
          && cookieManager.get(COOKIE_NAME) == null
        ){
          if($(window).width() < 500){
            $theChevron.fadeIn();
            $theBar.addClass('minimized');
          }else{
            $theChevron.fadeOut();
            $theBar.removeClass('minimized');
          }
        }
      }

      module.showState = function(state){
        var $widgetContainerWrapper = $theForm;

        switch(state){

          case 'loading':{
            // $widgetContainerWrapper.find('.nh-loading').fadeIn();
            $widgetContainerWrapper.removeClass('nh-wpsp-display-error').removeClass('nh-wpsp-display-success').addClass('nh-wpsp-display-loading').trigger('NH_WPSP_DISPLAY_LOADING');
            
            break;
          }

          case 'success':{
            // $widgetContainerWrapper.find('.nh-loading').fadeOut();
            // $widgetContainerWrapper.find(".nh-content-original").addClass('nh-content-original-hide');
            // $widgetContainerWrapper.find(".nh-content-success").removeClass('nh-content-success-hide').addClass('nh-content-success-display');
            // console.log($widgetContainerWrapper.find(".nh-content-original"));            
            $widgetContainerWrapper.removeClass('nh-wpsp-display-error').removeClass('nh-wpsp-display-loading').addClass('nh-wpsp-display-success').trigger('NH_WPSP_DISPLAY_SUCCESS');

            setTimeout(function(){
              // $('#nh-social-bar').removeClass('nh-social-bar-open');
              // $('#nh-social-bar .nh-subscribe-form').slideUp();
              module.minimize(true);
            },5000);
            
            break;
          }

          case 'error':{
            // $widgetContainerWrapper.find('.nh-loading').fadeOut();
            $widgetContainerWrapper.removeClass('nh-wpsp-display-loading').removeClass('nh-wpsp-display-success').addClass('nh-wpsp-display-error').trigger('NH_WPSP_DISPLAY_ERROR');
            // $("#story-space-2[data-widget='masonry']").masonry("reloadItems");
            //   $("#story-space-2[data-widget='masonry']").imagesLoaded(function(){
            //       $("#story-space-2[data-widget='masonry']").masonry();
            //   });
            break;
          }
        }
      }

      module.minimize = function(userMinimized){
        module.closeForm();
        $theBar.addClass(userMinimized === true ? 'user-minimized' : '').addClass('minimized');
        $theChevron.fadeIn();
        $('body').removeClass('sp_lsource-email');
        $('#nh-social-bar-overlay-bg').fadeOut(400);
      }

      module.unminimize = function(){
        $theBar.removeClass('user-minimized').removeClass('minimized');
        $theChevron.fadeOut();
      }

      module.toggleForm = function(userTouched){
        // console.log('toggleForm...', $theForm);
        var isItOpen = $theBar.hasClass('nh-social-bar-open') === true;
        if(isItOpen === true){
          
          module.minimize(userTouched);
          module.closeForm();
          
        }else{

          module.unminimize();
          module.openForm();

        }
        $theForm.removeClass('nh-wpsp-display-error').removeClass('nh-wpsp-display-success').removeClass('nh-wpsp-display-loading');
        
        
      }

      module.closeForm = function(){
        $theBar.removeClass('nh-social-bar-open');
        $theForm.slideUp( $('body').hasClass('sp_lsource-email') === true ? 400 : 100 );
      }

      module.openForm = function(){
        $theBar.addClass('nh-social-bar-open');
        $theForm.slideDown( $('body').hasClass('sp_lsource-email') === true ? 400 : 100 );
      }

      module.userTouched = function(userTouched){
        $theBar.addClass('user-touched');
        cookieManager.set(COOKIE_NAME, userTouched, {
          'expires':0.1
        });
      }

      module.init = function(){
        // console.log('subscriptionBar.init...');

        // close button
        $theCloseButton.click(function(e){
          e.preventDefault();
          module.userTouched('closed');
          module.minimize(true);
        });

        // subscribe
        $('#nh-social-bar .subscribe').click(function(e){
          e.preventDefault();
          module.toggleForm(true);
        });

        // the chevron in the minimized state
        $theChevron.click(function(e){
          e.preventDefault();
          module.userTouched('open');
          module.unminimize();
        });

        onWindowResize();
        $(window).resize(onWindowResize);

        if(
          $('body').is('.home') !== true
          || cookieManager.get(COOKIE_NAME) === 'closed'
          && lSource !== 'email'
        ){
          module.minimize(true);
        }

        if(lSource === 'email'){
          // console.log('email source!!!');
          $('#nh-social-bar-overlay-bg').fadeIn();
          $('body').addClass('sp_lsource-email');
          // $('#nh-social-bar-overlay-bg').addClass('sp_source-email');
          module.toggleForm();
        }else{
          // console.log('email source no!');
          $('#nh-social-bar-overlay-bg').hide();
        }
      }

      return module;
    })(app.subscriptionBar || {}, $, cookieManager);

    return app;
  })(window.newshub || {}, jQuery, window.Cookies);
});
