<?php
/**
 * Image + Text Block!
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$image        = get_field( 'image' );

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
		'level' => 5,
		'content' => 'This is a sneaky little subtitle',
	)),
    array('core/heading', array(
		'level' => 2,
		'content' => 'Robust title',
	)),
    array( 'core/paragraph', array(
        'content' => 'Some sweet paragraph text that is sharp and concise!',
    ))
);

if( empty($block['align']) ) {
    $class_name .= ' aligncontent';
}
/*
echo '<pre>';
var_dump( $block['align']);
echo '</pre>';
*/

$substring = "image-right";
$image_is_right = strpos($block['className'], $substring);
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>

    <div class="image-text__inner-wrap">
        <?php if($image_is_right === false && $image): ?>
            <div class="image-text__image-wrap">
                <?= wp_get_attachment_image( $image, 'full'); ?>
            </div>
        <?php endif; ?>

        <div class="image-text__inner">        
            <InnerBlocks 
                allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
                template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
                className="image-text__inner-blocks"
            />
        </div>
        <?php if($image_is_right !== false && $image): ?>
            <div class="image-text__image-wrap">
                <?= wp_get_attachment_image( $image, 'full'); ?>
            </div>
        <?php endif; ?>

    </div>

</div>