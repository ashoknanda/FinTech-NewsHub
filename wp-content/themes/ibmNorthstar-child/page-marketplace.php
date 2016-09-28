 <!DOCTYPE html>
<html lang="en-US"> 
    <head>
        <meta charset="utf-8">
        <title>IBM News Hub</title>
<style>
.button{
	background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 7.5px 9px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    top: 60px;
    /*left: 600px;*/
    position: absolute;
}

</style>
<?php
    header('X-Frame-Options: GOFORIT'); 
?>
    </head>
    <body style="padding: 0; margin: 0;">
    	<div style="height:100vh;">
			<a href="/wordpress/" class="button"> << Back to News Hub</a>
			<?php echo do_shortcode('[iframe src="https://www.ibm.com/marketplace" width="100%" height="100%"]'); ?>
    	</div>
    </body>
</html>
