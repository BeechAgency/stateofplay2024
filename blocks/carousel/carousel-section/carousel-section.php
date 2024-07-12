<?php
/**
 * Carousel Section Block
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

$allowed_blocks = array( 'beech/carousel', 'core/heading', 'core/paragraph', 'core/button', 'core/buttons' );

$templateCaroCard = array(
    'content' => '',
    'data' => array(
        'name' => 'Carousel Card Name',
        'title' => 'Carousel Card Title',
        'message' => 'Carousel Card Message',
        'image'=> '162'
    )
    );

$template = array(
    array('core/heading', array(
                'level' => 2,
                'content' => 'This is a carousel section',
    )),
	array('beech/carousel', 
        array(), 
        array(
            array('beech/carousel-card', $templateCaroCard),
            array('beech/carousel-card', $templateCaroCard),
            array('beech/carousel-card', $templateCaroCard)
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
        className="carousel-section__inner"
        />
</div>