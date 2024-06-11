<?php
/*
 * Add columns to post list
 */
function add_posts_columns ( $columns ) {
    $newColumns = array(
        'industry' => __('Industry')
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
add_filter ( 'manage_posts_columns', 'add_posts_columns' );
 

function add_projects_posts_columns ( $columns ) {
    $newColumns = array(
        'product' => __('Product')
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
* Add columns to post list
*/
function post_custom_column ( $column, $post_id ) {
    // get intiative
    $terms = get_the_terms( $post_id, 'industry');
    $industries = array();
    $industryString = '';

    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            // Output the term name
            if($term) { $industries[] = $term->name; }
        }
    }

    $productTerms = get_the_terms( $post_id, 'product');
    $products = array();
    $productString = '';

    if ($productTerms && !is_wp_error($productTerms)) {
        foreach ($productTerms as $productTerm) {
            // Output the productTerm name
            if($productTerm) { $products[] = $productTerm->name; }
        }
    }

    $industryString = implode(', ', $industries);
    $productString = implode(', ', $products);

    switch ( $column ) {
        case 'industry':
            echo !empty($industryString) ? $industryString : '—';
            break;
        case 'product':
            echo !empty($productString) ? $productString : '—';
        break;
    }
}
add_action ( 'manage_posts_custom_column', 'post_custom_column', 10, 2 );


function remove_wpseo_wincher_dashboard_widget() {
    remove_meta_box('wpseo-wincher-dashboard-overview', 'dashboard', 'normal');
}
add_action('wp_dashboard_setup', 'remove_wpseo_wincher_dashboard_widget');


add_action( 'admin_enqueue_scripts', 'beech_admin_style');

function beech_admin_style() {
  wp_enqueue_style( 'admin-style', get_stylesheet_directory_uri() . '/admin-style.css' );
}