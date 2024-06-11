<?php
/**
 * Scroll Video Block!
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.

$type = get_field( 'type');
$video = get_field('video');


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
    <div class="video-wrapper">
        <div class="video-inner">
            <?= do_video_field($video, $type); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    const parent = document.querySelector('.video-wrapper');
    const child = document.querySelector('.video-inner');
    const windowHeight = window.innerHeight;

    function updateAnimation() {
        const parentRect = parent.getBoundingClientRect();
        const animationProgress = Math.min(1, Math.max(0, (windowHeight - parentRect.top) / windowHeight));

        const animationMap = 0.8 + animationProgress * 0.2;

        //console.log(animationProgress, animationMap);
        // Apply animation progress to the custom property
        child.style.setProperty('--scroll-progress', animationMap);
    }

    // Listen for scroll events
    window.addEventListener('scroll', updateAnimation);

    // Initial update
    updateAnimation();
</script>