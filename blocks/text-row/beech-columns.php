<?php
/**
 * Text Row
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$border_top        = get_field( 'border_top' );
$border_bottom     = get_field( 'border_bottom' );

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.

$class_name = $border_top ? ' border-top' : ' ';
$class_name .= $border_bottom ? ' border-bottom' : ' ';

if ( !empty($block['alignContent']) ) {
    $class_name .= ' align-content-'.$block['alignContent'];
}


$allowed_blocks = array( 'beech/text-area', 'core/image' );

$template = array(
	array( 'beech/text-area', array(
		'content' => '',
	)),
    array('beech/text-area', array(
		'content' => '',
	))
);

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <?= $border_top ? '<div class="hr"></div>' : ''; ?>
    <InnerBlocks 
        allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
        template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
        className="text-row__inner" />
    <?= $border_bottom ? '<div class="hr"></div>' : ''; ?>
</div>