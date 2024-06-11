
<?php
/**
 * Accordion Item Block!
 *
 * @param array $block The block settings and attributes.
 */

// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = esc_attr( $block['anchor'] );
}


$title = get_field('title');
$button = get_field('button');
$after_button = get_field('after_button');

// Create class attribute allowing for custom "className" and "align" values.

$class_name = 'accordion-item ';


$allowed_blocks = array( 'core/heading', 'core/paragraph' );
$template = array(
    array(
        'core/heading', 
        array(
            'level' => 5,
            'placeholder' => 'A title that is interesting'
        )
    ),
    array(
        'core/paragraph',
        array(
            'placeholder' => 'We combine data, technology, and creativity to deliver web experiences and products that drive sales and growth. '
        )
    )
); 


if(!empty($button)) {
    $button['classes'] = 'btn-ghost';
}
?>

<details 
    itemscope="" 
    itemprop="mainEntity" 
    itemtype="https://schema.org/Question" 

    style=""
    <?= get_block_wrapper_attributes( array(
    'class' => $class_name,
    'id' => $anchor )
    ); 
?>> 
    <summary>
        <h3 class="" itemprop="name"><?= $title ?></h3> 
        <div class="accordion-item__toggle">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64">
                <g id="Group_2089" data-name="Group 2089" transform="translate(-1536.5 -1997.571)">
                    <line id="Line_383" data-name="Line 383" y2="64" transform="translate(1568.5 1997.571)" fill="none" stroke="currentColor" stroke-width="4"/>
                    <line id="Line_384" data-name="Line 384" y2="64" transform="translate(1600.5 2029.571) rotate(90)" fill="none" stroke="currentColor" stroke-width="4"/>
                </g>
            </svg>
        </div>
    </summary>
    <div class="answer" itemscope="" itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
         <div itemprop="text" class="text-wrapper">
            <InnerBlocks 
                    allowedBlocks="<?= esc_attr( wp_json_encode( $allowed_blocks ) ); ?>" 
                    template="<?= esc_attr( wp_json_encode( $template ) ); ?>"
                    className="accordion-item__inner-blocks"
                />
        </div>
        <?php if(!empty($button)): ?>
        <div class="accordion-item__cta">
            <?= do_a_cta($button); ?><?= $after_button ?>
        </div>
        <?php endif; ?>
    </div>
</details>
