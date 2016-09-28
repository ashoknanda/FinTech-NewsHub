<?php
if ( is_page( 'x-force-center' ) ||  is_singular( array( 'ibm_malware', 'ibm_general_advisory', 'ibm_vulnerabilities' ) ) ) {
	// show x-force tracking
	?>
	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-63493929-1', 'auto');
		ga('send', 'pageview');

	</script>
<?php
} else {
	// show default tracking
	?>
	<script type="text/javascript">

		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-41848786-1']);
		_gaq.push(['_gat._forceSSL']);
		_gaq.push(['_trackPageview']);

		(function () {
			var ga = document.createElement('script');
			ga.type = 'text/javascript';
			ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0];
			s.parentNode.insertBefore(ga, s);
		})();

	</script>
<?php
}