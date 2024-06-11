
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

$class_name = ' outcome-item ';

$big_text = get_field('big_text');
$little_text = get_field('little_text');

$display_arrow = get_field('display_arrow');
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>

    <?php if($display_arrow): ?>
    <div class="outcomes-item--arrow">
        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="45.716" height="45.717" viewBox="0 0 45.716 45.717">
            <path id="Path_580" fill="currentColor" data-name="Path 580" d="M44.176,20.714,42.64,18.68,28.559,0H22.406L37.711,20.3H0v4.915H37.711l-15.448,20.5h6.149L42.64,26.845,44.176,24.8l1.541-2.034Z"/>
        </svg>
    </div>
    <?php endif; ?>

    <div class="outcomes-item--text">
        <h4 class=""><?= $big_text ?></h4><?= !empty($little_text) ? "<p>$little_text</p>" : '' ?>
    </div>
</div>