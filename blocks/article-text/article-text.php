<?php
/**
 * Text Area Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.

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


$allowed_blocks = array( 
    'core/heading', 
    'core/paragraph',
    'core/list',
    'core/list-item', 
    'core/embed',
    'core/pullquote',
    'core/quote',
    'core/table' 
);

$template = array(
    array( 'core/heading', array(
        'level' => 6,
        'content' => 'Section Title',
    )),
    array( 'core/paragraph', array(
        'content' => 'Enter text here, make sure it is interesting! Lorem ipsum.',
    ))
);


?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="article-text__inner">
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            orientation="horizontal"
            className="article-text__inner-blocks" />
    </div>
</div>

