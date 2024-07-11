<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package sop
 */

get_header();
$error_page = get_field('404_page','options');
?>

	<main id="primary" class="site-main error-404 not-found">
		<article id="post-error-404" <?php post_class(); ?>>
			<div class="entry-content">
				<?= apply_filters( 'the_content', $error_page->post_content ) ?>
			</div>
		</article>
	</main><!-- #main -->

<?php
get_footer();
