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

function sop_o_logo_svg() {
	echo '<svg xmlns="http://www.w3.org/2000/svg" id="StateOfPlayO" width="164" height="138" viewBox="0 0 164 138" fill="none">
  <g clip-path="url(#clip0_201_104)">
    <path d="M163.07 61.77H146.88C143.87 24.8 117.47 0 81.19 0C44.91 0 18.49 24.8 15.49 61.77H0V76.95H15.57C18.9 113.45 44.99 137.88 81.19 137.88C117.39 137.88 143.46 113.46 146.81 76.95H163.08V61.77H163.07ZM81.19 15.6C107.69 15.6 125.35 33.44 127.88 61.77H34.29C36.84 33.44 54.69 15.6 81.19 15.6ZM81.19 122.28C54.95 122.28 37.2 104.8 34.37 76.95H127.8C125 104.8 107.42 122.28 81.19 122.28Z" fill="currentColor"/>
  </g>
  <defs>
    <clipPath id="clip0_201_104">
      <rect width="163.07" height="137.88" fill="transparent"/>
    </clipPath>
  </defs>
</svg>';
}

function sop_logo_svg() {
	echo '<svg id="StateOfPlayLogo" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 442 44">
  <defs>
    <style>
      .cls-1 {
        fill: currentColor;
        stroke-width: 0px;
      }
    </style>
  </defs>
  <path class="cls-1" d="M.6,30h5.5c1,5.7,5.4,9,12.1,9s10.9-2.3,10.9-7.4-2.1-5.4-6.7-6.4l-8.7-2c-5.3-1.2-11.5-3.5-11.5-11.3S8.5.4,17.7.4s15.3,5.3,15.6,12.4h-5.5c-.9-4.8-4.3-7.8-10.4-7.8s-9.5,2.7-9.5,6.6,2.1,5.2,7,6.3l8.9,2c7.2,1.7,10.9,5.3,10.9,11.2s-6.3,12.5-16.6,12.5S.9,37.4.5,29.9h.1Z"/>
  <path class="cls-1" d="M52.3,5.6h-13.9V1.1h33.2v4.5h-13.9v37.2h-5.4V5.6h0Z"/>
  <path class="cls-1" d="M85.2,1.1h6.9l15.6,41.8h-5.7l-4.1-11.1h-18.7l-4.1,11.1h-5.7L85,1.1h.2ZM96.4,27.4l-7.7-21.1-7.8,21.1h15.5Z"/>
  <path class="cls-1" d="M119.7,5.6h-13.9V1.1h33.2v4.5h-13.9v37.2h-5.4V5.6h0Z"/>
  <path class="cls-1" d="M145.9,1.1h28v4.5h-22.7v14.1h20.8v4.5h-20.8v14.2h22.7v4.5h-28V1.1h0Z"/>
  <path class="cls-1" d="M300.8,1.1h18.1c7.6,0,13,5,13,12.6s-5.4,12.6-13,12.6h-12.7v16.5h-5.4V1h0ZM317.8,21.9c5.4,0,8.4-3.2,8.4-8.1s-3-8.1-8.4-8.1h-11.7v16.2h11.7Z"/>
  <path class="cls-1" d="M339.1,1.1h5.4v37.3h20.3v4.5h-25.7V1.1Z"/>
  <path class="cls-1" d="M385.2,1.1h6.9l15.6,41.8h-5.7l-4.1-11.1h-18.7l-4.1,11.1h-5.7l15.6-41.8h.2ZM396.4,27.4l-7.7-21.1-7.8,21.1h15.5Z"/>
  <path class="cls-1" d="M420.6,26.6l-15.5-25.6h6l12.2,20.5,12.2-20.5h6l-15.5,25.6v16.2h-5.4v-16.2Z"/>
  <path class="cls-1" d="M277.1,5.6V1.1h-27.8v18.6h-8.9c-.8-11.8-8.1-19.4-19.1-19.4s-18.3,7.5-19.1,19.4h-8.9v4.5h8.9c.8,11.8,8.1,19.4,19.1,19.4s18.3-7.6,19.1-19.4h8.9v18.6h5.4v-18.6h20.9v-4.5h-20.9V5.6h22.4ZM221.2,5c8.2,0,12.9,6,13.5,14.8h-27.1c.7-8.8,5.3-14.8,13.5-14.8h.1ZM221.2,39c-8.2,0-12.9-6.1-13.5-14.8h27c-.7,8.7-5.4,14.8-13.5,14.8Z"/>
</svg>';
	//get_template_part( 'assets/beech-logo.svg', null, array() );
}




// Hides the post menu hopefully
function hide_posts_menu() {
    remove_menu_page('edit.php'); // Removes the 'Posts' menu item
}
add_action('admin_menu', 'hide_posts_menu');

// Ensure that the main posts page displays proejects
function modify_main_query_for_projects($query) {
    if ( $query->is_home() && $query->is_main_query() ) {
        $query->set('post_type', 'project');
    }
}

add_action('pre_get_posts', 'modify_main_query_for_projects');