<?php

/* 
	Remove all the extra styles and junk WP adds
*/
//remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );


// Remove JQuery migrate
function beechblocks_remove_jquery_migrate( $scripts ) {
	if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
		 $script = $scripts->registered['jquery'];
		 
		if ( $script->deps ) { 
			// Check whether the script has any dependencies
			$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
		}	
  	}
}
 add_action( 'wp_default_scripts', 'beechblocks_remove_jquery_migrate' );

 //Remove Gutenberg Block Library CSS from loading on the frontend
 /*
 function beechblocks_remove_wp_block_library_css(){
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-blocks-style' ); // Remove WooCommerce block CSS
	wp_dequeue_style( 'classic-theme-styles-css' );
   } 
 add_action( 'wp_enqueue_scripts', 'beechblocks_remove_wp_block_library_css', 100 );
*/

/**
 * Remove support for custom gradients
 */
//add_theme_support('disable-custom-gradients', true);


/**
 * COMPLETELY DISABLE COMMENTS
 * @from https://www.wpbeginner.com/wp-tutorials/how-to-completely-disable-comments-in-wordpress/
 */

  add_action('admin_init', function () {
    // Redirect any user trying to access comments page
    global $pagenow;
     
    if ($pagenow === 'edit-comments.php') {
        wp_safe_redirect(admin_url());
        exit;
    }
 
    // Remove comments metabox from dashboard
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    // Disable support for comments and trackbacks in post types
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
});
 
// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
 
// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);
 
// Remove comments page in menu
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});
 
// Remove comments links from admin bar
add_action('init', function () {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
});

/**
 * END: COMPLETELY DISABLE COMMENTS
 */