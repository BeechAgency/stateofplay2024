<?php
/**
 * Read More Block
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
$class_name = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

$post_categories = get_the_category(); // Get the post categories

$categories_string = '';

if ($post_categories) {
    $category_links = array(); // Create an array to store category links

    foreach ($post_categories as $category) {
        $category_links[] = '<a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . '</a>'; // Generate the links
    }

    //$categories_string = implode(', ', $category_links); // Comma-separated string
    $categories_string = $category_links[0];
}   

?>
<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    
    <span class="date"><?= get_the_date(); ?></span> | 
    <span class="categories"><?= $categories_string ?></span>
</div>