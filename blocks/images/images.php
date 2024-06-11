<?php
/**
 * Image + Text Block!
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$style        = get_field( 'style' );
$force_aspect_ratio = get_field('force_aspect_ratio');

if($style === 'letterbox') {
    $text = get_field('text');
}


$aspect_class = ( empty($force_aspect_ratio) || !$force_aspect_ratio ) ? '' :  ' has-equal-heights ';


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = ' has-'.$style.'-layout '. $aspect_class;

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

    <div class="images_block-wrapper <?= $wrapper_class ?>" data-xy="grid">        
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="images_block-inner-blocks"
            orientation="horizontal"
        />
        <?php if($style === 'letterbox') { ?>
            <div class="images_block-overlay">
                <div class="images_block-overlay--text">
                    <?= $text ?>
                </div>
            </div>
        <?php } ?>
    </div> 
</div>