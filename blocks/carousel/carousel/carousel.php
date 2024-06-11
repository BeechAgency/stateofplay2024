
<?php
/**
 * Team Grid Block
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


$allowed_blocks = array( 'beech/carousel-card' );

$template = array(
	array('beech/carousel-card', array(
		'content' => '',
	))
);

$style = '';
// Switch on the style
switch (true) {
    case strpos($block['className'], 'photos') !== false:
        $style = 'photos';
        break;
    case strpos($block['className'], 'logos') !== false:
        $style = 'logos';
        break;
    default:
        $style = '';
}

//data-flickity='{ "cellAlign": "left", "contain": true }'
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="carousel">        
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="carousel__target"
         />
    </div>
</div>