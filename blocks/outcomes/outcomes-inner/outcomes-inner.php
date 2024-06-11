
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

$class_name = ' ';

$allowed_blocks = array( 'beech/outcome' );
$template = array(
    array('beech/outcome'),
    array('beech/outcome'),
    array('beech/outcome')
);

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <InnerBlocks 
        allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
        template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
        className="outcomes__inner-blocks"
    />
</div>