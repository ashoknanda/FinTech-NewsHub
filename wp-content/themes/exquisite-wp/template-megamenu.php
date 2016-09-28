<?php if(has_nav_menu('top-menu')) { ?>
	<?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'menu_class' => 'mega-menu', 'depth' => 3, 'container' => false, 'walker'	=> new rpg_walker_nav_menu  ) ); ?>
<?php } ?>