<?php
/**
 * Header Block
 *
 * @param array $block The block settings and attributes.
 */


// Load values and assign defaults.
$text_top_left        = get_field( 'text_top_left' );
$text_bottom_right        = get_field( 'text_bottom_right' );
$links        = get_field( 'links' );
$byline        = get_field( 'byline' );
$image_url        = get_field( 'image' );
$video_url        = get_field( 'video_url' );

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

$style = '';
?>

<header <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>
    style="--scroll-percentage: 0"
    >

    <div class="epic-header__inner">
        <div class="epic-header__inner-top">
            <h1><?= $text_top_left ?></h1>
        </div>
        <div class="epic-header__inner-bottom-left">
            <p class="epic-header__byline">
                <?= $byline; ?>
            </p>
            <div class="epic-header__links">
                <?php 
                if(have_rows('links')): 
                    foreach(get_field('links') as $link_obj) :
                        $link = $link_obj['link'];
                    ?>
                    <a href="<?= $link['url'] ?>" target="_blank" title="<?= $link['title'] ?>"><?= $link['title']; ?></a>
                <?php 
                    endforeach;
                endif; ?>
            </div>
        </div>
        <div class="epic-header__inner-bottom-right">
            <h1><?= $text_bottom_right ?></h1>
        </div>
       

        <div class="epic-header__video-wrapper">
            <div class="epic-header__video-inner">
                <?= do_video_field($video_url, 'url', $image_url); ?>
            </div>
        </div>
    </div>
</header>


<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', (e) => {
        const headerBar = document.querySelector('header#masthead');

        const sE = document.querySelector('.wp-block-beech-epic-header');
        sE.style.setProperty('--header-offset', `${headerBar.scrollHeight}px`);


        const child = document.querySelector('.epic-header__inner');

        // Listen for scroll events
        window.addEventListener('scroll', () => {
            const sRect = sE.getBoundingClientRect();
            const scrolled = Math.round( (sRect.top * -1 / sRect.height) * 100 , 0);

            const scrollMod = scrolled * 1.5;

            const scrollN = scrollMod > 100 ? 100 : scrollMod < 0 ? 0 : scrollMod;


            //console.log(Math.round(sRect.top,0), Math.round(sRect.bottom,0), Math.round(sRect.height,0));
            console.log(scrollN, scrollMod);
            sE.style.setProperty('--scroll-percentage', `${scrollN}`);
        });

        // Initial update
        //updateAnimation();
    });
</script>