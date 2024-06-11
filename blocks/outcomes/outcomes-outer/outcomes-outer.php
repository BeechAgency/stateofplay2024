
<?php
/**
 * Feature Block!
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

$text = get_field('text');
$subtitle = get_field('subtitle');

$allowed_blocks = array( 'core/heading', 'core/paragraph', 'core/button', 'core/buttons', 'beech/outcomes-inner' );
$template = array(
    array(
        'core/heading', 
        array(
            'level' => 6,
            'content' => 'Outcomes'
        )
    ),
    array(
        'beech/outcomes-inner'
    )
);

$wide_style = false;

if(!empty($block['className'])) {
    if( strpos($block['className'], 'big-n-wide') !== false ) {
        $wide_style = true;
    }
}

?>

<div <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); ?>>
    <?php if(!$wide_style): ?>
    <div class="outcomes-extras">
        <?php if(!empty($subtitle)) :?><h6 class="eyebrow">
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="6" fill="currentColor" viewBox="0 0 6 6">
                <circle id="Ellipse_55" data-name="Ellipse 55" cx="3" cy="3" r="3"/>
            </svg>
            <?= $subtitle ?>
        </h6>
        <?php endif; ?>
        <?= apply_filters( 'the_content', $text ); ?>
    </div>
    <?php endif ?>
    <div class="outcomes-wrapper">        
        <InnerBlocks 
            allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
            template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
            className="outcomes__outer-blocks"
        />
    </div>
</div>