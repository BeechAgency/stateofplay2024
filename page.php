<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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

			get_template_part( 'template-parts/content', 'page' );

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->
<?php
if($black_footer) { echo '<div class="has-off-black-background-color">';}
dynamic_sidebar('pages-footer');
if($black_footer) { echo '</div>';}
get_footer();
