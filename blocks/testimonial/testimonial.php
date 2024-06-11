<?php
/**
 * Testimonial Block template.
 *
 * @param array $block The block settings and attributes.
 * https://www.billerickson.net/innerblocks-with-acf-blocks/
 */
/* 
https://fullsiteediting.com/lessons/theme-json-typography-options/ 
https://mikelaroy.ca/blog/wordpress-acf-blocks-json-innerblocks/
*/ 

// Load values and assign defaults.
$quote             = !empty(get_field( 'quote' )) ? get_field( 'quote' ) : 'Your quote here...';
$author            = get_field( 'author' );
$author_role       = get_field( 'role' );
$image             = get_field( 'image' );
$background_color  = get_field( 'background_color' ); // ACF's color picker.
$text_color        = get_field( 'text_color' ); // ACF's color picker.
$do_a_think        = get_field( 'do_a_thing' );
$quote_attribution = '';

if ( $author ) {
    $quote_attribution .= '<footer class="testimonial__attribution">';
    $quote_attribution .= '<cite class="testimonial__author">' . $author . '</cite>';

    if ( $author_role ) {
        $quote_attribution .= '<span class="testimonial__role">' . $author_role . '</span>';
    }

    $quote_attribution .= '</footer><!-- .testimonial__attribution -->';
}

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'testimonial '.$do_a_think;
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $class_name .= ' align' . $block['align'];
}
if ( $background_color || $text_color ) {
    $class_name .= ' has-custom-acf-color';
}

// Build a valid style attribute for background and text colors.
$styles = array( 'background-color: ' . $background_color, 'color: ' . $text_color );
$style  = implode( '; ', $styles );


$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/button' );

$template = array(
	array('core/heading', array(
		'level' => 2,
		'content' => 'Title Goes Here',
	)),
    array( 'core/paragraph', array(
        'content' => 'Some sweet paragraph text rocking your world!',
    ) )
);
/*
echo '<pre>';
var_dump($block);
echo '</pre>';

echo get_block_wrapper_attributes();
*/
/* ?php echo esc_attr( $anchor ); ?>class="<?php echo esc_attr( $class_name ); ?>" style="<?php echo esc_attr( $style ); ?> */
?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name )
    ); ?>>
    <div class="testimonial__col">
        <blockquote class="testimonial__blockquote">
            <?php echo esc_html( $quote ); ?>

            <?php if ( !empty( $quote_attribution ) ) : ?>
                <?php echo wp_kses_post( $quote_attribution ); ?>
            <?php endif; ?>
        </blockquote>
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="testimonial__inner-blocks" />
    </div>

    <?php if ( $image ) : ?>
        <div class="testimonial__col">
            <figure class="testimonial__image">
                <?php echo wp_get_attachment_image( $image['ID'], 'full', '', array( 'class' => 'testimonial__img' ) ); ?>
            </figure>
        </div>
    <?php endif; ?>
</div>