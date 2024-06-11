<?php
/**
 * CTA Block!
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.

$link = get_field( 'link');
$button_align = get_field('button_align');

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.

$class_name = '';

$is_borderless = false;

if(!empty($block['className'])) {
    if( strpos($block['className'], 'borderless') !== false ) {
        $is_borderless = true;
    }
}

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="cta-wrapper">
        <div class="cta-line"></div>
        <div class="cta-inner btn-<?= $button_align ?>">
            <h2><?= get_field('text'); ?></h2>
            <a href="<?= $link['url'] ?>" target="<?= $link['target']; ?>" class="big-cta-btn">
                <span><?= $link['title']; ?></span>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="57.482" height="57.482" viewBox="0 0 57.482 57.482">
                        <path id="Path_580" data-name="Path 580" d="M55.545,26.045l-1.931-2.558L35.909,0H28.172L47.417,25.528H0v6.179H47.417L27.994,57.482h7.731L53.613,33.753l1.931-2.569,1.937-2.558Z" fill="currentColor"/>
                    </svg>
                </span>
            </a>
        </div>
    </div>
</div>