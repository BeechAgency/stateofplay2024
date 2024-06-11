<?php

function beechblocks_register_acf_blocks() {
    /**
     * We register our block's with WordPress's handy
     * register_block_type();
     *
     * @link https://developer.wordpress.org/reference/functions/register_block_type/
     */
	$themeDir = dirname(__DIR__);

	register_block_type( $themeDir . '/blocks/header' );

    register_block_type( $themeDir . '/blocks/block-template' );
	register_block_type( $themeDir . '/blocks/testimonial' );
	register_block_type( $themeDir . '/blocks/text-area' );
	register_block_type( $themeDir . '/blocks/text-row' );

	register_block_type( $themeDir . '/blocks/feature/feature-inner' );
	register_block_type( $themeDir . '/blocks/feature/feature-outer' );
	register_block_type( $themeDir . '/blocks/image-text' );
	register_block_type( $themeDir . '/blocks/articles' );
	register_block_type( $themeDir . '/blocks/cta' );
	register_block_type( $themeDir . '/blocks/scroll-video' );
	
	register_block_type( $themeDir . '/blocks/article-text' );
	register_block_type( $themeDir . '/blocks/images' );


	register_block_type( $themeDir . '/blocks/carousel/carousel-section' );
	register_block_type( $themeDir . '/blocks/carousel/carousel-card' );
	register_block_type( $themeDir . '/blocks/carousel/carousel' );

	register_block_type( $themeDir . '/blocks/outcomes/outcomes-outer' );
	register_block_type( $themeDir . '/blocks/outcomes/outcomes-inner' );
	register_block_type( $themeDir . '/blocks/outcomes/outcome' );

	register_block_type( $themeDir . '/blocks/team/team-grid' );
	register_block_type( $themeDir . '/blocks/team/team-member' );
	register_block_type( $themeDir . '/blocks/team/team-section' );

	register_block_type( $themeDir . '/blocks/accordion/accordions' );
	register_block_type( $themeDir . '/blocks/accordion/accordion-item' );
	register_block_type( $themeDir . '/blocks/accordion/accordion-outer' );

	register_block_type( $themeDir . '/blocks/marquee' );
	register_block_type( $themeDir . '/blocks/count-indicator' );
	register_block_type( $themeDir . '/blocks/showcase' );
	register_block_type( $themeDir . '/blocks/contact-details' );
	register_block_type( $themeDir . '/blocks/spacer' );
	register_block_type( $themeDir . '/blocks/sick-video' );
	register_block_type( $themeDir . '/blocks/eyebrow' );

	register_block_type( $themeDir . '/blocks/date-category' );
	register_block_type( $themeDir . '/blocks/reading-time' );


	register_block_type( $themeDir . '/blocks/epic-header' );
}
// Here we call our beechblocks_register_acf_block() function on init.
add_action( 'init', 'beechblocks_register_acf_blocks' );


function beecbblocks_allowed_block_types() {
	return array(
		'core/paragraph',
		'core/heading',
		'core/button',
		'core/buttons',
		'core/code',
		'core/list',
		'core/list-item',
		'core/pullquote',
		'core/quote',
		'core/table',
		'core/shortcode',
		'core/html',
		'core/image',
		'core/video',
		'core/embed',
		'acf/testimonial',
		'beech/header',
		'beech/articles',
		'beech/cta',
		'beech/scroll-video',
		'beech/carousel',
		'beech/carousel-card',
		'beech/carousel-section',
		'beech/article-text',
		'beech/text-area',
		'beech/text-row',
		'beech/images',
		'beech/outcomes-outer',
		'beech/outcomes-inner',
		'beech/outcome',
		'beech/team-member',
		'beech/team-grid',
		'beech/team-section',
		'beech/accordion-item',
		'beech/accordions',
		'beech/accordion-outer',
		'beech/marquee',
		'beech/count-indicator',
		'beech/showcase',
		'beech/contact',
		'beech/spacer',
		'beech/sick-video',
		'beech/eyebrow',
		'beech/date-category',
		'beech/reading-time',
		'beech/epic-header',
		'gravityforms/form'
	);

	/*
		'core/embed',
		'beech/feature-inner',
		'beech/feature-outer',
		'beech/image-text',
		'core/group',
		'core/columns',
		'core/column',
	*/
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

/*
 * Remove archive prefixes
 */ 
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/* Testing removing <stuff></stuff> */


remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );