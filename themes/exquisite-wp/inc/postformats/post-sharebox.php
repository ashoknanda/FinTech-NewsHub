<div id="shareBox">
    <!-- AddThis Button BEGIN -->
    <div class="addthis_toolbox addthis_counter_style">
        <a class="addthis_button_facebook_share" fb:share:layout="box_count"></a>
        <div style="height: 15px;"></div>
        <a class="addthis_button_google_plusone" g:plusone:size="tall"></a>
        <div style="height: 15px;"></div>
        <a class="addthis_button_tweet" tw:count="vertical"></a>
        <div style="height: 15px;"></div>
        <a class="addthis_button_linkedin_counter" li:counter="top"></a>
        <div style="height: 15px;"></div>
        <a class="addthis_button_facebook_like" fb:like:layout="box_count"></a>
        <div style="height: 15px;"></div>
        <a class="addthis_counter"></a>
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53591bdd1bf9985c"></script>
    <!-- AddThis Button END -->
</div>
<script type="text/javascript">
    (function($) {
        var documentHeight = 0;
        var topPadding = 15;
    	$("#shareBox").fadeIn();
        var offset = $("#shareBox").offset();
        documentHeight = $(document).height();
        $(window).scroll(function() {
            if ($('#nav').hasClass('rpg_sticky')) {
                var topPadding = 140;
            }
            var shareBoxHeight = $("#shareBox").height();
            if ($(window).scrollTop() > offset.top) {
                var newPosition = ($(window).scrollTop() - offset.top) + topPadding;
                $("#shareBox").stop().animate({
                    marginTop: newPosition
                });
            } else {
                $("#shareBox").stop().animate({
                    marginTop: 0
                });
            };
        });
    })(jQuery);
</script>