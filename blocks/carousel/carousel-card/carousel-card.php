<?php
/**
 * Carousel Card Item
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$name        = get_field('name');
$title        = get_field( 'title' );
$image        = get_field( 'image' );
$message        = get_field( 'message');
$background_color = get_field( 'background_color' );

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

$type ='logos';
$class_name = 'carousel-item card__'.$type;
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="carousel-card__inner">        
        <div class="carousel-card__image">
            <?= wp_get_attachment_image( $image, 'full'); ?>
        </div>
        <div class="carousel-card__content <?= $background_color; ?>">
            <h6 class='carsouel-card__name'><?= $name ?></h6>
            <?= !empty($title) ? "<p class='carsouel-card__title'>$title</p>" : '' ?>
            <p class='carsouel-card__message'><?= $message ?></p>
        </div>
    </div>
</div>