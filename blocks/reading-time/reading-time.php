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

$content = get_the_content();
$reading_time = beechblocks_calculate_reading_time($content);

?>
<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    
    <span class="read-time"><?= $reading_time ?> MIN READ</span>
</div>