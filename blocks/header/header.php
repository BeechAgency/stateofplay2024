<?php
/**
 * Header Block
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

$style = '';
$featured_image_url = get_the_post_thumbnail_url( null, 'full');

$post_type = get_post_type();
$post_id = get_the_ID();


// Switch on the style
if(!empty($block['className'])):
    switch (true) {
        case strpos($block['className'], 'basic') !== false:
            $style = 'basic';
            break;
        case strpos($block['className'], 'contact') !== false:
            $style = 'contact';
            break;

        default:
            $style = '';
    }
endif;

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'gravityforms/form', 'beech/contact' );

$template = array(
	array('core/heading', array(
		'level' => 1,
		'placeholder' => get_the_title(),
	))
);

if($post_type === 'project') {
    $template = array(
        array('core/heading', array(
            'level' => 1,
            'content' => '<mark style="background-color: rgba(0,0,0,0);" class="has-grape-color has-heading-font-family">Client name,</mark> An amazing thing that happened'
        ))
    );

    $class_name .= ' project-type';
}
?>

<header <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>

    <div class="header__inner">
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="header__inner-blocks" />

        <?php if($post_type === 'project'): ?>
        <div class="project-meta">
            <div class="project-meta-item"><?php echo !empty($client = get_field('client', $post_id)) ? '<span>Client</span> <span>'.$client.'</span>' : '' ?></div>
            <div class="project-meta-item"><?php echo !empty($year = get_field('year', $post_id)) ? '<span>Year</span> <span>'.$year.'</span>' : '' ?></div>
            <div class="project-meta-item"><?php echo !empty($role = get_field('role', $post_id)) ? '<span>Role</span> <span>'.$role.'</span>' : '' ?></div>
        </div>
        <div class="project-feature-image">
            <?= get_the_post_thumbnail( null, 'full', null ); ?>
        </div>
        <?php endif; ?>
    </div>
</header>