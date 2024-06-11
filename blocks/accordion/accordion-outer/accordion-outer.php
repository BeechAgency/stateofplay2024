
<?php
/**
 * Feature Block!
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

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/button', 'core/buttons', 'beech/outcomes-inner' );
$template = array(
    array(
        'core/heading', 
        array(
            'level' => 3,
            'content' => 'FAQs'
        )
    ),
    array(
        'beech/accordions'
    )
);

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="accordions-wrapper">        
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="accordions-outer__blocks"
        />
    </div>
</div>