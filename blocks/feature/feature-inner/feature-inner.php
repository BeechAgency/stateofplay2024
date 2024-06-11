<?php
/**
 * Feature Block!
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$image        = get_field( 'image' );
$quote_attribution = '';

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

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/button', 'core/buttons' );

$template = array(
	array('core/heading', array(
		'level' => 2,
		'content' => get_the_title(),
	)),
    array( 'core/paragraph', array(
        'content' => 'Some sweet paragraph text rocking your world!',
    ))
);


?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="feature__inner-wrap">
        <div class="feature__inner ">        
            <InnerBlocks 
                allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
                template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
                className="feature__inner-blocks"
                templateLock="false"
            />
        </div>

        <?php if ( $image ) : ?>
            <div class="feature__image-wrap">
                <?= wp_get_attachment_image( $image, 'full'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>