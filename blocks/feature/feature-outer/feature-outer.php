<?php
/**
 * Feature Block!
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$title        = get_field( 'title' );
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

$allowed_blocks = array( 'beech/feature-inner' );
$template = array(
	array('beech/feature-inner', array(
		'content' => '',
	))
);
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="feature-outer__wrap">        
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="feature-outer__inner-blocks"
            templateLock="all"
        />
    </div>
</div>