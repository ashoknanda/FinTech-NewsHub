
(function($) {
    window.fwp_is_paging = false;
    window.refresh_triggered = false;

        wp.hooks.addFilter('facetwp/template_html', function(resp, params) {
            if (FWP.is_load_more) {
                FWP.is_load_more = false;
                $('.facetwp-template').append(params.html);
                return true;
            }
            return resp;
        });

    $(document).on('facetwp-refresh', function() {
        console.log("Fwp refreshed");

        if (! window.fwp_is_paging) {
            window.fwp_page = 1;
            FWP.extras.per_page = 'default';
            window.refresh_triggered = false;
        }
        window.fwp_is_paging = false;
    });

    $(document).on('facetwp-loaded', function() {
        console.log("Facetwp Loaded .. Do as you please..");

        window.fwp_total_rows = FWP.settings.pager.total_rows;

            $('.facetwp-dropdown').each(function() {
                IBMCore.common.widget.selectlist.init($(this));
            });
            $('.facetwp-sort-select:not(.ready)').each(function() {
                IBMCore.common.widget.selectlist.init($(this));
            });            
            $("#story-space-2[data-widget='masonry']").masonry("reloadItems");
            $("#story-space-2[data-widget='masonry']").imagesLoaded(function(){
                $("#story-space-2[data-widget='masonry']").masonry({
                    isAnimated:false,
                    transitionDuration:0
                });
            });
            if(twttr && twttr.widgets){
                twttr.widgets.load();    
            }
console.log("Page number : "+window.fwp_page);
        if(window.fwp_page > 1){
            window.refresh_triggered = false;
        }

        if (! FWP.loaded) {
            window.fwp_default_per_page = FWP.settings.pager.per_page;

            $(window).scroll(function() {
                var triggerHeight = Math.round(0.8 * ($(document).height() - $(window).height()));
                // console.log('diff height : ',Math.round(triggerHeight));
                if ($(window).scrollTop() >= Math.round(triggerHeight) && !window.refresh_triggered) {
                    var rows_loaded = (window.fwp_page * window.fwp_default_per_page);
                    if (rows_loaded < window.fwp_total_rows) {
                        window.fwp_page++;
                        window.fwp_is_paging = true;
                        window.refresh_triggered = true;
                        FWP.extras.per_page = (window.fwp_page * window.fwp_default_per_page);
                        FWP.soft_refresh = true;
                        FWP.refresh();
                    }
                }
            });
        }
    });

})(jQuery);
