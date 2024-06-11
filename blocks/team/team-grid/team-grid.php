<?php
/**
 * Team Grid Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$title        = get_field( 'title' );
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


$allowed_blocks = array( 'beech/team-member' );

$template = array(
	array('beech/team-member', array(
		'content' => '',
        'data' => array(
            'name' => 'Jonnie Goodboy Tyler',
            'title'=> 'Saves the Universe from a cult'
        )
    )),
    array('beech/team-member', array(
		'content' => '',
        'data' => array(
            'name' => 'Froddo Baggins',
            'title'=> 'Detroyer of Rings'
        )
    )),
    array('beech/team-member', array(
		'content' => '',
        'data' => array(
            'name' => 'James Holden',
            'title'=> 'Captain of Rocinante'
        )
    ))
);

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="team-grid__inner ">        
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="team-grid__grid"
         />
    </div>
</div>