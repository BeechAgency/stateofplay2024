
<?php
/**
 * Accordions Wrapper
 *
 * @param array $block The block settings and attributes.
 */



// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.

$class_name = ' ';

$allowed_blocks = array( 'beech/accordion-item' );
$template = array(
    array('beech/accordion-item'),
    array('beech/accordion-item'),
    array('beech/accordion-item')
);

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <InnerBlocks 
        allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
        template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
        className="accordion__accordion-items"
    />
</div>