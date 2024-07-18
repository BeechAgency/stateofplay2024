<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package sop
 */

get_header();

$page_for_posts = get_option( 'page_for_posts' );
$page_ID = get_the_ID();

if(is_home() || is_404()) {
	$page_ID = $page_for_posts;
}

$black_footer = get_field('black_footer', $page_ID);
?>

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			/*
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'beechblocks' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'beechblocks' ) . '</span> <span class="nav-title">%title</span>',
				)
			);
			*/


		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

if($black_footer) { echo '<div class="has-jet-black-background-color">';}

if(get_post_type() === 'project') {

	dynamic_sidebar('projects-footer');

	
} else {
	//get_sidebar();
	dynamic_sidebar('sidebar-1');
}


if($black_footer) { echo '</div>';}
get_footer();
