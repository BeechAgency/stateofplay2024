<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package sop
 */



function sop_register_custom_menus() {
    // Define the menu locations and their names
    $menu_locations = array(
        'header-menu' => 'Header Menu',
        'footer-menu' => 'Footer Menu',
		'footer-social' => 'Footer Social', 
    );

    // Register the menu locations
    register_nav_menus($menu_locations);
}

// Hook into the 'init' action to register the menu locations
add_action('init', 'sop_register_custom_menus');


function sop_logo_svg() {
	echo '<svg id="beechLogo" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 649.26 134.76">
	<defs>
	  <style>
		.logo-letter {
		  fill: currentColor;
		  stroke-width: 0px;
		}
	  </style>
	</defs>
	<path class="logo-letter" d="m84.22,131.55H0V3.21h84.22c25.51,0,42.03,14.28,42.03,30.64s-9.46,28.72-23.74,32.41c9.31,2.41,23.74,10.43,23.74,31.44,0,17.49-17.81,33.85-42.03,33.85Zm-12.35-89.52h-21.18v13.15h21.18c3.53,0,6.58-2.89,6.58-6.58s-3.05-6.58-6.58-6.58Zm0,37.7h-21.18v13.15h21.18c3.53,0,6.58-3.05,6.58-6.58s-3.05-6.58-6.58-6.58Z"/>
	<path class="logo-letter" d="m134.6,131.55V3.21h115.99v38.82h-65.29v13.15h31.76v24.55h-31.76v13.15h65.29v38.66h-115.99Z"/>
	<path class="logo-letter" d="m260.7,131.55V3.21h115.99v38.82h-65.29v13.15h31.76v24.55h-31.76v13.15h65.29v38.66h-115.99Z"/>
	<path class="logo-letter" d="m448.88,134.76c-36.74,0-66.42-30.16-66.42-67.38S412.14,0,448.88,0c33.21,0,56.79,24.55,60.32,56.79h-41.71c-1.6-12.35-9.95-17.33-16.68-17.33-8.66,0-17.33,8.02-17.33,27.91s8.66,27.91,17.33,27.91c6.58,0,14.92-4.97,16.52-16.84h41.87c-3.53,32.09-27.27,56.31-60.32,56.31Z"/>
	<path class="logo-letter" d="m598.56,131.55v-45.08h-30v45.08h-50.69V3.21h50.69v46.36h30V3.21h50.7v128.34h-50.7Z"/>
  </svg>';
	//get_template_part( 'assets/beech-logo.svg', null, array() );
}


