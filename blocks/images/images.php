<?php
/**
 * Image + Text Block!
 *
 * @param array $block The block settings and attributes.
 */


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

$class_name = ' ';

if ( !empty($block['alignContent']) ) {
    $class_name .= ' align-content-'.$block['alignContent'];
}

$allowed_blocks = array( 'core/image', 'core/video', 'core/embed', 'beech/sick-video' );

$placeholder = get_template_directory_uri() . '/assets/gradient.jpg';

$template = array(
	array( 'core/image', array(
        'url' => $placeholder
    )),
    array( 'core/image', array(
        'url' => $placeholder
    ))
);

$wrapper_class = '';
if( empty($block['align']) ) {
    $wrapper_class =' aligncontent';
}
/*
echo '<pre>';
var_dump( $block['align']);
echo '</pre>';
*/

$substring = "image-right";
//$image_is_right = strpos($block['className'], $substring);
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>       
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="images_block-inner-blocks"
            orientation="horizontal"
        />
</div>