<?php

$THEME_BLOCKS = array(
    array('name' => 'core/paragraph'),
    array('name' => 'core/heading'),
    array('name' => 'core/button'),
    array('name' => 'core/buttons'),
    array('name' => 'core/code'),
    array('name' => 'core/list'),
    array('name' => 'core/list-item'),
    array('name' => 'core/pullquote'),
    array('name' => 'core/quote'),
    array('name' => 'core/table'),
    array('name' => 'core/shortcode'),
    array('name' => 'core/html'),
    array('name' => 'core/image'),
    array('name' => 'core/video'),
    array('name' => 'core/embed'),
    array('name' => 'acf/testimonial', 'args' => array('requiresRegister' => true)),
    array('name' => 'gravityforms/form', 'args' => array('requiresRegister' => true)),
    array('name' => 'beech/header', 'args' => array('path' => '/blocks/header', 'requiresRegister' => true)),
    array('name' => 'beech/block-template', 'args' => array('path' => '/blocks/block-template', 'requiresRegister' => true)),
    array('name' => 'beech/testimonial', 'args' => array('path' => '/blocks/testimonial', 'requiresRegister' => true)),
    array('name' => 'beech/text-area', 'args' => array('path' => '/blocks/text-area', 'requiresRegister' => true)),
    array('name' => 'beech/text-row', 'args' => array('path' => '/blocks/text-row', 'requiresRegister' => true)),
    array('name' => 'beech/feature-inner', 'args' => array('path' => '/blocks/feature/feature-inner', 'requiresRegister' => true)),
    array('name' => 'beech/feature-outer', 'args' => array('path' => '/blocks/feature/feature-outer', 'requiresRegister' => true)),
    array('name' => 'beech/image-text', 'args' => array('path' => '/blocks/image-text', 'requiresRegister' => true)),
    array('name' => 'beech/articles', 'args' => array('path' => '/blocks/articles', 'requiresRegister' => true)),
    array('name' => 'beech/cta', 'args' => array('path' => '/blocks/cta', 'requiresRegister' => true)),
    array('name' => 'beech/scroll-video', 'args' => array('path' => '/blocks/scroll-video', 'requiresRegister' => true)),
    array('name' => 'beech/article-text', 'args' => array('path' => '/blocks/article-text', 'requiresRegister' => true)),
    array('name' => 'beech/images', 'args' => array('path' => '/blocks/images', 'requiresRegister' => true)),
    array('name' => 'beech/carousel-section', 'args' => array('path' => '/blocks/carousel/carousel-section', 'requiresRegister' => true)),
    array('name' => 'beech/carousel-card', 'args' => array('path' => '/blocks/carousel/carousel-card', 'requiresRegister' => true)),
    array('name' => 'beech/carousel', 'args' => array('path' => '/blocks/carousel/carousel', 'requiresRegister' => true)),
    array('name' => 'beech/outcomes-outer', 'args' => array('path' => '/blocks/outcomes/outcomes-outer', 'requiresRegister' => true)),
    array('name' => 'beech/outcomes-inner', 'args' => array('path' => '/blocks/outcomes/outcomes-inner', 'requiresRegister' => true)),
    array('name' => 'beech/outcome', 'args' => array('path' => '/blocks/outcomes/outcome', 'requiresRegister' => true)),
    array('name' => 'beech/team-grid', 'args' => array('path' => '/blocks/team/team-grid', 'requiresRegister' => true)),
    array('name' => 'beech/team-member', 'args' => array('path' => '/blocks/team/team-member', 'requiresRegister' => true)),
    array('name' => 'beech/team-section', 'args' => array('path' => '/blocks/team/team-section', 'requiresRegister' => true)),
    array('name' => 'beech/accordions', 'args' => array('path' => '/blocks/accordion/accordions', 'requiresRegister' => true)),
    array('name' => 'beech/accordion-item', 'args' => array('path' => '/blocks/accordion/accordion-item', 'requiresRegister' => true)),
    array('name' => 'beech/accordion-outer', 'args' => array('path' => '/blocks/accordion/accordion-outer', 'requiresRegister' => true)),
    array('name' => 'beech/marquee', 'args' => array('path' => '/blocks/marquee', 'requiresRegister' => true)),
    array('name' => 'beech/count-indicator', 'args' => array('path' => '/blocks/count-indicator', 'requiresRegister' => true)),
    array('name' => 'beech/showcase', 'args' => array('path' => '/blocks/showcase', 'requiresRegister' => true)),
    array('name' => 'beech/contact', 'args' => array('path' => '/blocks/contact-details', 'requiresRegister' => true)),
    array('name' => 'beech/spacer', 'args' => array('path' => '/blocks/spacer', 'requiresRegister' => true)),
    array('name' => 'beech/sick-video', 'args' => array('path' => '/blocks/sick-video', 'requiresRegister' => true)),
    array('name' => 'beech/eyebrow', 'args' => array('path' => '/blocks/eyebrow', 'requiresRegister' => true)),
    array('name' => 'beech/date-category', 'args' => array('path' => '/blocks/date-category', 'requiresRegister' => true)),
    array('name' => 'beech/reading-time', 'args' => array('path' => '/blocks/reading-time', 'requiresRegister' => true)),
    array('name' => 'beech/epic-header', 'args' => array('path' => '/blocks/epic-header', 'requiresRegister' => true))
);

function beechblocks_register_acf_blocks() {
    /**
     * We register our block's with WordPress's handy
     * register_block_type();
     *
     * @link https://developer.wordpress.org/reference/functions/register_block_type/
     */
	$themeDir = dirname(__DIR__);

	global $THEME_BLOCKS;

	foreach ($THEME_BLOCKS as $block) {
		// Check if 'args' exists and 'path' exists within 'args'
		if (!isset($block['args']['path'])) continue;
		
		// Check if 'requiresRegister' is set and its value is true
		if (!isset($block['args']['requiresRegister']) || $block['args']['requiresRegister'] !== true) continue;

		// 'path' exists, and 'requiresRegister' is true
		$blockPath = $block['args']['path'];

		// Register the block type
		register_block_type($themeDir . $blockPath);
	}

}
// Here we call our beechblocks_register_acf_block() function on init.
add_action( 'init', 'beechblocks_register_acf_blocks' );


function beecbblocks_allowed_block_types() {
	global $THEME_BLOCKS;

	$blocks = array();

	foreach ($THEME_BLOCKS as $block) {
		$blocks[] = $block['name'];
	}

	return $blocks;
}
add_filter( 'allowed_block_types', 'beecbblocks_allowed_block_types' );


/**
 * Changes blocks based on block
 */
add_filter( 'allowed_block_types_all', 'rt_allowed_block_types', 25, 2 );
 
function rt_allowed_block_types( $allowed_blocks, $editor_context ) {
	/*
    if( 'custom_post_type' === $editor_context->post->post_type ) { 
        $allowed_blocks = array(
			'core/image',
			'core/paragraph',
			'core/heading',
			'core/list'
        );
        return $allowed_blocks;
    } else {
        return;
    }*/

	return $allowed_blocks;
}



/* Default Page Blocks */
function beechblocks_register_page_template() {
    $post_type_object = get_post_type_object( 'page' );
    $post_type_object->template = array(
        array( 'beech/header' ),
    );


    $post_type_object = get_post_type_object( 'post' );
    $post_type_object->template = array(
        array( 'beech/header' , 
			array(
				'styles' => 'article',
				'className' => 'is-style-article-image'
			),
			array(
				array('beech/date-category', array()),
				array('core/heading', array('level' => '1', 'content' => 'Title of post')),
				array('beech/reading-time', array())
			)
		),
		array('beech/article-text', array(
			'className'=> 'is-style-post-meta',
			'align'=> 'full'
		)),
		array('beech/article-text', array(
			'className'=> 'is-style-toc',
			'align'=> 'full'
		))
    );


    $project_type_object = get_post_type_object( 'project' );

	if(!empty($project_type_object)) :
		$project_type_object->template = array(
			array( 'beech/header' , array(
				'styles' => 'article',
				'className' => 'is-style-project'
			)),
			array('beech/images', array(
				'align'=> 'full'
			)),
			array('beech/images', array(
				'align'=> 'full'
			)),
			array('beech/article-text', array(
			)),
			array('beech/images', array(
				'align'=> 'full',
				'className' => 'is-style-gappy'
			)),
			array('beech/images', array(
				'align'=> 'full',
				'className' => 'is-style-gappy'
			))
		);
	endif;
}
add_action( 'init', 'beechblocks_register_page_template' );


/*
	Custom Guttenburg Style
*/
function enqueue_custom_editor_styles() {
    wp_enqueue_style('custom-editor-styles', get_template_directory_uri() . '/guttenburg-style.css');
}

add_action('enqueue_block_editor_assets', 'enqueue_custom_editor_styles');


/**
 * Register Scripts for Caro
 */
function beechblocks_register_block_script() {
	wp_register_script( 'flickity', get_template_directory_uri() . '/js/vendor/flickity.pkgd.min.js', [] );
	wp_register_script( 'carousel', get_template_directory_uri() . '/blocks/carousel/carousel/carousel.js', ['flickity'] );
	wp_register_style( 'flickity', get_template_directory_uri() . '/js/vendor/flickity.css', [] );
	wp_register_script( 'scrolly-boi', get_template_directory_uri() . '/blocks/count-indicator/scrolly-boi.js', [] );
	wp_register_script( 'showcase', get_template_directory_uri() . '/blocks/showcase/showcase.js', [] );
	wp_register_script( 'accordions', get_template_directory_uri() . '/blocks/accordion/accordions/accordions.js', [] );
}
add_action( 'init', 'beechblocks_register_block_script' );

//add_filter( 'should_load_separate_core_block_assets', '__return_true' );

