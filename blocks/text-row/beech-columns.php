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


$allowed_blocks = array( 'beech/text-area' );

$style = 'equal';
// Switch on the style
if(!empty($block['className'])):
    switch (true) {
        case strpos($block['className'], 'single') !== false:
            $style = 'single';
            break;

        default:
            $style = 'equal';
    }
endif;

$template = array(
	array( 
        'beech/text-area', 
        array(),
        array(
            array(
                'core/heading', 
                array(
                    'level' => 3,
                    'content' => 'Rainbow Thunder'
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

if($style === 'single') {
    $template = array(
        array( 
            'beech/text-area', array(),
            array(
                array('core/heading', array(
                    'level' => 3,
                    'content' => 'State of Play is a Culture is a non-commercial initiative that works to preserve and bring the world’s art and culture online so it’s accessible to anyone, anywhere. The GAC team tasked Parker with developing a unique identity that communicates their mission while still feeling at home within the primary Google brand.' 
                ))
            )
        
        )
    );
}

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