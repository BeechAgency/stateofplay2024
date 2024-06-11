<?php
/**
 * Contact Details
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

if ( !empty($block['alignContent']) ) {
    $class_name .= ' align-content-'.$block['alignContent'];
}


?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>       
    <div class="contact-details__inner"> 
        <div>
                <h6>Find us</h6>
                <p>
                    <?= get_field('address', 'options'); ?>
                </p>
        </div>
        <div>
                <h6>Contacts</h6>
                <p>
                    <a href="mailto:<?= get_field('email', 'options'); ?>"><?= get_field('email', 'options'); ?></a><br />
                    <a href="tel:<?= get_field('phone', 'options'); ?>"><?= get_field('phone', 'options'); ?></a>
                </p>
        </div>
    </div>
</div>