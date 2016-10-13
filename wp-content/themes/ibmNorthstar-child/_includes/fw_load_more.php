<?php

function fwp_load_more() {
?>
<script>
(function($) {
    $(function() {
        if ('object' != typeof FWP) {
            return;
        }

        wp.hooks.addFilter('facetwp/template_html', function(resp, params) {
            if (FWP.is_load_more) {
                FWP.is_load_more = false;
                $('.facetwp-template').append(params.html);
                return true;
            }
            return resp;
        });

        $(document).on('click', '.fwp-load-more', function() {
            $('.fwp-load-more').html('Loading...');
            FWP.is_load_more = true;
            FWP.paged = parseInt(FWP.settings.pager.page) + 1;
            FWP.post_count = FWP.paged - 1;
            FWP.soft_refresh = true;
            FWP.refresh();
        });

        $(document).on('facetwp-loaded', function() {
            if (FWP.settings.pager.page < FWP.settings.pager.total_pages) {
                if (! FWP.loaded && 1 > $('.fwp-load-more').length) {
                    $('.facetwp-template').parent().after('<p class="ibm-ind-link ibm-padding-top-1"><a href="javascript:void(0);" class="fwp-load-more  ibm-btn-pri ibm-center-position">Load more</a></p>');
                }
                else {
                    $('.fwp-load-more').html('Load more').show();
                }                
            }
            else {
                $('.fwp-load-more').hide();
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
            $("#story-space-2[data-widget='masonry']").imagesLoaded(function(){
                $("#story-space-2[data-widget='masonry']").masonry();
            });
            if(twttr && twttr.widgets){
                twttr.widgets.load();    
            }
         });
    });
})(jQuery);
</script>
<?php
}
add_action( 'wp_head', 'fwp_load_more', 99 );