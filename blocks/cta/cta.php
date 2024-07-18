<?php
/**
 * CTA Block!
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}


$allowed_blocks = array( 
    'core/paragraph'
);
$template = array(
    array( 'core/paragraph', array(
        'level' => 2,
        'content' => 'Enter the radness that is this title',
    )),
    array( 'core/paragraph', array(
        'level' => 2,
        'content' => '<a href="#">Click me</a>',
    ))
);

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';
$is_borderless = false;

if(!empty($block['className'])) {
    if( strpos($block['className'], 'borderless') !== false ) {
        $is_borderless = true;
    }
}

if(!empty($block['backgroundColor']) && $block['backgroundColor'] == 'jet-black') {
    $class_name .= ' has-jet-black-background-color';
}


?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="cta-wrapper">
        <div class="cta-line"></div>
        <div class="cta-inner">
            <InnerBlocks 
                allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>"
                template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
                className="cta-blocks"
                templateLock="true"
            />
        </div>
    </div>
</div>