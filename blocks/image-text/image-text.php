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

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';

if ( !empty($block['alignContent']) ) {
    $class_name .= ' align-content-'.$block['alignContent'];
}

if( empty($block['align']) ) {
    $class_name .= ' aligncontent';
}

$allowed_blocks = array('beech/text-area','core/image');

$template = array(
    array('core/image', array(
    )),
    array( 'beech/text-area', array(), 
        array(
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
        )
    )
);
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <InnerBlocks 
        allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
        template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
        className="image-text__inner-blocks"
        orientation="horizontal"
    />
</div>