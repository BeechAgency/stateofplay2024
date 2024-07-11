<?php
/**
 * The code in this file basically resets or removes some basic wordpress functionality.
 * This can be used across any site without modification.
 * 
 * It :
 *  1. Removes JQuery Migrate
 *  2. Removes some Wordpress SVG filter fluff
 *  3. Disables Comments
 *  4. Allows SVG uploads
 *  5. Sanitizes SVG files
 *  6. Removes the Image Filter Threshold
 *  7. Removes the Wincher Dashboard Widget that Yoast annoyingly adds by default.
 *  8. Removes Archive Prefixes (which I find annoying)
 */

/* 
	Remove all the extra styles and junk WP adds
*/
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


/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function sop_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'sop_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function sop_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'sop_pingback_header' );



// Disable WordPress' automatic image scaling feature
function sop_image_filter_threshold() {
	return false;
}

add_filter( 'big_image_size_threshold', 'sop_image_filter_threshold' );



function sop_remove_wpseo_wincher_dashboard_widget() {
    remove_meta_box('wpseo-wincher-dashboard-overview', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'sop_remove_wpseo_wincher_dashboard_widget');



// Allow SVG file upload
function sop_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'sop_mime_types');

// Sanitize SVG files
function sop_sanitize_svg($file) {
  if ($file['type'] == 'image/svg+xml') {
    $file_content = file_get_contents($file['tmp_name']);
    $file_content = str_replace('<script', '', $file_content);
    file_put_contents($file['tmp_name'], $file_content);
  }
  return $file;
}
add_filter('wp_handle_upload_prefilter', 'sop_sanitize_svg');

// Fix SVG display in media library
function sop_fix_svg() {
  echo '<style type="text/css">
    .attachment-266x266, .thumbnail img {
      width: 100% !important;
      height: auto !important;
    }
  </style>';
}
add_action('admin_head', 'sop_fix_svg');


/*
 * Remove archive prefixes
 */ 
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );