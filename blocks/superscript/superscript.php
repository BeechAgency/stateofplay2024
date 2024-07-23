<?php
/**
 * Read More Block
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
$class_name = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}
$text = get_field('text');


$allowed_blocks = array( 'core/paragraph' );

    
$template = array(
	array('core/paragraph', array(
		'content' => '01',
	))
);
?>
<!--
<h6 <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" fill="currentColor" viewBox="0 0 6 6">
        <circle id="Ellipse_55" data-name="Ellipse 55" cx="3" cy="3" r="3"/>
    </svg>
    <?= $text; ?>
</h6>
-->
<!--<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>-->
<InnerBlocks 
        allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
        template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
        className="superscript__wrap"
        templateLock="all" 
         />
<!--</div>-->