<?php
/**
 * Text Area Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$do_a_think        = get_field( 'do_a_thing' );
$quote_attribution = '';

$image = false;

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


$allowed_blocks = array( 
    'core/heading', 
    'core/paragraph', 
    'core/list',
    'core/list-item',
    'core/pullquote',
    'core/quote',
    'core/table',
    'core/button', 
    'core/buttons', 
    'core/image', 
    'beech/eyebrow' 
);

$template = array(
    array( 'core/paragraph', array(
        'content' => 'Enter text here',
    ))
);

$is_spacer = false;

if(!empty($block['className'])) {
    if( strpos($block['className'], 'spacer') !== false ) {
        $is_spacer = true;
    }
}

/*
echo '<pre>';
var_dump(get_block_wrapper_attributes());
echo '</pre>';
*/
/*
echo '<pre>';
var_dump($block);
echo '</pre>';
*/
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>        
    <?php if(!$is_spacer): ?>
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            orientation="horizontal"
            className="text-area__inner-blocks" />
    <?php endif; ?>
</div>