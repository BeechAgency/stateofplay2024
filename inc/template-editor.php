<?php
/** 
 * Create the columns for the post list view
 */

function add_projects_posts_columns ( $columns ) {
    $newColumns = array(
        'client' => __('Client'),
        'tagline' => __('Tagline'),
        'has_video' => __('Video'),
        'image' => __('Image'),
    );

    $existingProperty = 'tags'; // Replace 'tags' with the property key before which you want to insert

    if (array_key_exists($existingProperty, $columns)) {
        // Get the position of the existing property in the array
        $insertPosition = array_search($existingProperty, array_keys($columns));

        // Split the original array into two parts at the insertion point
        $columnsBeforeInsertion = array_slice($columns, 0, $insertPosition, true);
        $columnsAfterInsertion = array_slice($columns, $insertPosition, null, true);

        // Merge the parts of the array with the new properties inserted in between
        $columns = $columnsBeforeInsertion + $newColumns + $columnsAfterInsertion;
    } else {
        // If the existing property doesn't exist, simply merge the new properties at the end
        $columns = array_merge($columns, $newColumns);
    }

    return $columns;
}
add_filter ( 'manage_project_posts_columns', 'add_projects_posts_columns' );


/*
* Populate the columns in the post list view. 
*/

function post_custom_column ( $column, $post_id ) {
    $client = get_field('client', $post_id);
    $tagline = get_field('tagline', $post_id);
    $has_video = get_field('featured_video', $post_id);
    $image = get_the_post_thumbnail( $post_id, 'thumbnail' );

    switch ( $column ) {
        case 'client':
            echo !empty($client) ? $client : '';
            break;
        case 'tagline':
            echo !empty($tagline) ? $tagline : '';
            break;
        case 'has_video':
            echo !empty($has_video) ? '✔️' : '';
            break;
        case 'image':
            echo !empty($image) ? $image : '';
            break;
        break;
    }
}
add_action ( 'manage_posts_custom_column', 'post_custom_column', 10, 2 );



add_action( 'admin_enqueue_scripts', 'sop_admin_style');

function sop_admin_style() {
  wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/admin-style.css' );
}
  