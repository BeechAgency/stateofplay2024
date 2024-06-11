
<?php
/**
 * Showcase
 *
 * @param array $block The block settings and attributes.
 */



// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}

// Create class attribute allowing for custom "className" and "align" values.

$class_name = 'showcase__wrapper';

$items = get_field('items');

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/button', 'core/buttons' );

$template = array(
	array('core/heading', array(
		'content' => 'We offer expertise in:',
        'level' => '3'
	))
);
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>

    <InnerBlocks 
        allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
        template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
        className="showcase__inner-blocks" />

    <div class="showcase__items-grid">
        <div class="showcase__image-wrap">
            <?php 
            if(have_rows('items')):
                $offset = 0;
                while( have_rows('items') ) : the_row();
                    $post = get_sub_field('post');
                    $image = get_sub_field('image');

                    if(!empty($image)) {
                        $style = "style='--_image-offset: $offset'";
                        $attrs = 'data-post-id="'.$post.'" '.$style;
                        echo the_image($image,
                            array(
                                'classes' => 'showcase-item__image',
                                'attrs' => $attrs
                            )
                        );

                    } else {
                        echo get_the_post_thumbnail( $post, 'full', array(
                            'class' => 'showcase-item__image',
                            'data-post-id' => $post,
                            'style' => '--_image-offset: '.$offset
                        ));
                    }
                    
                    

                    $offset++;
                endwhile;
            endif;
            ?>
        </div>
        <div class="showcase__items-list-wrap">
            <?php 
            if(have_rows('items')):
                echo "<ul class='showcase__items-list'>";

                while( have_rows('items') ) : the_row();

                    $title = get_sub_field('title');
                    $post = get_sub_field('post');
                    $post_title = get_the_title($post);
                    $link = get_the_permalink( $post );

                    echo "<li data-post-id='$post'><a href='$link'><span class='showcase-item__title'>$title</span><span class='showcase-item__reveal'>$post_title</span></a></li>";

                endwhile;
                echo '</ul>';
            endif;
            ?>

        </div>
    </div>
</div>