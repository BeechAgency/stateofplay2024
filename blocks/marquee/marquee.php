
<?php
/**
 * Marquee
 *
 * @param array $block The block settings and attributes.
 */



// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.

$class_name = '';

$title = get_field('title');
$images = get_field('images');
$images_darkmode = get_field('images_darkmode');
$use_darkmode = get_field('use_darkmode_images');
$use_clients = get_field('use_client_logos');

if($use_clients) {
    $clients = get_field('clients', 'options');
    $images = array();
    $images_darkmode = array();
    $use_darkmode = true;

    foreach($clients as $client) {
        if(!empty($client['image'])) $images[] = $client['image'];
        if(!empty($client['image_on_black'])) $images_darkmode[] = $client['image_on_black'];
    }
}

if(!empty($images)) shuffle($images);
if(!empty($images_darkmode)) shuffle($images_darkmode);
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <?php if(!empty($title)):?><h4 class="marquee__title"><?= $title ?></h4><?php endif; ?>
    <div class="marquee__wrap <?= $use_darkmode ? 'has-dark-version' : '' ?>">
        <div class="marquee__track">
            <div class="marquee__group">
            <?php 
            foreach($images as $image):
                echo '<div class="marquee__item">';
                echo the_image($image, array(
                    'classes' => 'marquee__item-image'
                ));
                echo '</div>';
            endforeach;
            ?>
            </div>
            <div class="marquee__group">
            <?php 
            foreach($images as $image):
                echo '<div class="marquee__item">';
                echo the_image($image, array(
                    'classes' => 'marquee__item-image'
                ));
                echo '</div>';
            endforeach;
            ?>
            </div>
        </div>
    </div>
    <?php if($use_darkmode === true): ?>
    <div class="marquee__wrap dark-version">
        <div class="marquee__track">
            <div class="marquee__group">
            <?php 
            foreach($images_darkmode as $image):
                echo '<div class="marquee__item">';
                echo the_image($image, array(
                    'classes' => 'marquee__item-image'
                ));
                echo '</div>';
            endforeach;
            ?>
            </div>
            <div class="marquee__group">
            <?php 
            foreach($images_darkmode as $image):
                echo '<div class="marquee__item">';
                echo the_image($image, array(
                    'classes' => 'marquee__item-image'
                ));
                echo '</div>';
            endforeach;
            ?>
            </div>
        </div>
    </div>



    <?php endif; ?>
</div>