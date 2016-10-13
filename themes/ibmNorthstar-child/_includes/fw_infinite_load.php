<?php

function fwp_infinite_load() {
?>
<script>
(function($) {
    $(function() {
        if ('object' != typeof FWP) {
            return;
        }
        
        window.refresh_triggered = false;

        wp.hooks.addFilter('facetwp/template_html', function(resp, params) {
            if (FWP.is_load_more) {
                FWP.is_load_more = false;
                $('.facetwp-template').append(params.html);
                window.refresh_triggered = false;
                return true;
            }
            return resp;
        });

        $(document).on('facetwp-loaded', function() {
            // console.log('Total Pages : ', FWP.settings.pager.total_pages);
            // if () {
                if (! FWP.loaded ) {
                    window.fwp_default_per_page = FWP.settings.pager.per_page;

                    $(window).scroll(function() {
                        var triggerHeight = Math.round(0.6 * ($(document).height() - $(window).height()));

                        // console.log("condition is : ",$(window).scrollTop() >= Math.round(triggerHeight) && !window.refresh_triggered);

                        if (FWP.settings.pager.page < FWP.settings.pager.total_pages  && $(window).scrollTop() >= Math.round(triggerHeight) && !window.refresh_triggered) {
                                FWP.is_load_more = true;
                                FWP.paged = parseInt(FWP.settings.pager.page) + 1;
                                FWP.post_count = FWP.paged - 1;
                                FWP.soft_refresh = true;
                                window.refresh_triggered = true;
                                FWP.refresh();
                        }
                    });
                }              
        });

        $(document).on('facetwp-loaded', function() {
            $('.facetwp-type-dropdown select:not(.ready)').each(function() {
                IBMCore.common.widget.selectlist.init($(this));
            });
            $('.facetwp-sort-select:not(.ready)').each(function() {
                IBMCore.common.widget.selectlist.init($(this));
            });            
            $("#story-space-2[data-widget='masonry']").masonry("reloadItems");
            // $("#story-space-2[data-widget='masonry']").masonry();
            $("#story-space-2[data-widget='masonry']").imagesLoaded(function(){
                $("#story-space-2[data-widget='masonry']").masonry();
            });
         });       
                
    });
})(jQuery);
</script>
<?php
}
add_action( 'wp_head', 'fwp_infinite_load', 99 );

?>