<?php
/**
 * Text Area Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$do_a_think        = get_field( 'do_a_thing' );
$quote_attribution = '';

$image = false;

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.

$class_name = '';

if ( !empty($block['alignContent']) ) {
    $class_name .= ' align-content-'.$block['alignContent'];
}


$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/list','core/list-item', 'core/embed', 'core/image',
'core/pullquote',
'core/quote',
'core/table' );

$template = array(
    array( 'core/paragraph', array(
        'content' => 'Enter text here, make sure it is interesting!',
    ))
);


$style = '';
// Switch on the style
if(!empty($block['className'])):
    switch (true) {
        case strpos($block['className'], 'quote') !== false:
            $style = 'quote';
            break;
        case strpos($block['className'], 'meta') !== false:
            $style = 'meta';
            break;
        case strpos($block['className'], 'toc') !== false:
            $style = 'toc';
            break;
        default:
            $style = 'default';
    }
endif;


if($style === 'meta') {
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
}

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>

    <div class="article-text__inner" data-xy="grid">
        <div class="article-text__aside <?=  $style ?>" data-xy="col 2xl:4 2xl:start-2 xl:4 xl:start-2 lg:5 lg:start-auto md:4 md:start-auto sm:12 sm:12 xs:12">
            <?php if($style === 'meta'): 
                beech_author_profile(); 
            endif; ?>
            <?php if($style === 'quote'): ?>
            <div class="article-quote">
                <?= !empty(get_field('quote')) ? '<p class="has-large-font-size">'.get_field('quote').'</p>' : '' ; ?>
            </div>
            <?php endif; ?>
             <?php if($style === 'toc'): 
                $toc = get_post_meta(get_the_ID(), '_toc_meta_field', true);
                if ($toc) {
                    echo '<aside class="single-sidebar">';
                    echo $toc;

                    echo '<div class="social-sharers-wrap"><div class="social-sharers-title">Share:</div>';
                    beech_social_sharers();
                    echo '</div></aside>';
                }
            endif; ?>
        </div>
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            orientation="horizontal"
            className="article-text__inner-blocks" />
    </div>
</div>

