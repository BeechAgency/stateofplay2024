<?php
/**
 * Text Area Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$video_url        = get_field( 'video_url' );
$image        = get_field( 'image' );
$type        = get_field( 'type' );


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = '';

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>   
    <div class="sick-video-wrapper">
    <?php echo do_video_field($video_url, $type); ?>

    <?php /* if($type === 'direct'): ?>
        <video width="100%" height="auto" playsinline="" loop="" muted="" autoplay="" class="sick-video lozad" data-placeholder-background="hsla(0, 0.00%, 0.00%, 1.00)" data-loaded="false">
            <source data-src="<?= $video_url ?>" src="">
            Your browser does not support the video tag.
        </video>
    <?php elseif($type === 'youtube'): ?>
        <iframe 
            width="100%" 
            height="auto" 
            src="https://www.youtube.com/embed/z-_XlZvR3NU?si=L-1STxlAwL2xKTP6" 
            title="YouTube video player" 
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
            referrerpolicy="strict-origin-when-cross-origin" 
            allowfullscreen>
        </iframe>
    <?php else: ?>
        <iframe data-src="<?= $video_url ?>&autoplay=1&loop=1&autopause=0&background=1" width="100%" height="400" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" class="lozad"></iframe>
    <?php endif; */ ?>
        <?= the_image($image, ['classes'=>'lozad sick-poster']); ?>
    </div>
</div>