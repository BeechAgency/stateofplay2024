<?php
/**
 * Group Section
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

$allowed_blocks = array( 'beech/text-row', 'beech/text-area' );

$template = array(
	array( 
        'beech/text-area', 
        array(),
        array(
            array(
                'core/heading', 
                array(
                    'level' => 3,
                    'content' => 'Our Stuff'
                )
            )
        )
    ),
    array( 'beech/text-area', array(), 
        array(
            array(
                'core/heading', 
                array('level' => 6, 'content' => 'Some title')
            ),
            array(
                'core/paragraph',
                array('content' => 'A deep dive into the problem definition, we invest time up front in research and stakeholder engagement to ensure everyone is on the same page.')
            )
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
        className="group-section__inner" />
</div>