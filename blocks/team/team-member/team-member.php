<?php
/**
 * Team Member Block
 *
 * @param array $block The block settings and attributes.
 */

// Load values and assign defaults.
$name        = get_field( 'name' );
$title        = get_field( 'title' );
$image        = get_field( 'image' );
$bio        = get_field( 'bio' );

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}
$class_name = '';

$profile = "<svg width='1600' height='1600' viewBox='0 0 1200 1200' xmlns='http://www.w3.org/2000/svg' fill='currentColor' style='opacity: 0.1;'><path d='M1108.8 600c0-281.25-227.5-508.75-508.75-508.75S91.3 318.75 91.3 600s227.5 508.75 508.75 508.75S1108.8 881.25 1108.8 600zm-967.5 0c0-253.75 206.25-458.75 458.75-458.75s458.75 205 458.75 458.75c0 128.75-52.5 245-138.75 327.5-66.25-113.75-187.5-183.75-321.25-183.75-132.5 0-255 71.25-321.25 183.75C193.8 845 141.3 728.75 141.3 600zm176.25 361.25c56.25-102.5 165-167.5 282.5-167.5 118.75 0 226.25 63.75 282.5 167.5-77.5 61.25-176.25 97.5-282.5 97.5s-205-36.25-282.5-97.5z'/><path d='M600 678.75c110 0 200-90 200-200s-90-200-200-200-200 90-200 200 90 200 200 200zm0-350c82.5 0 150 67.5 150 150s-67.5 150-150 150-150-67.5-150-150 67.5-150 150-150z'/></svg>";

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <div class="team-member__inner">        
        <div class="team-member__inner--image">
            <?= $is_preview && empty($image) ? $profile : wp_get_attachment_image( $image, 'full'); ?>
        </div>
        <div class="team-member__inner--text">
        <h6><?= $name ?></h6>
        <?php if(!empty($title)): ?><p class="team-member__title"><?= $title ?></p><?php endif;?>
        <?php if(!empty($bio)): ?><p class="team-member__bio"><?= $bio ?></p><?php endif;?>
        </div>
    </div>
</div>