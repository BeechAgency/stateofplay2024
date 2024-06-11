<?php
/**
 * Count Indicator
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';

$section_text = get_field('section_text');

if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

$is_start = false;
$class_name = '';
if(!empty($block['className'])) {
    if( strpos($block['className'], 'start') !== false ) {
        $is_start = true;
    }
}
?>

<?php if($is_start): ?>
<div class="scrolly-boi">
    <span class="scrolly-boi__inner"><?= $section_text ?></span>
</div>
<?php endif; ?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>
    data-section-text="<?= $section_text ?>"></div>