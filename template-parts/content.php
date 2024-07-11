<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package sop
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'beechblocks' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'beechblocks' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
	<?php if(get_post_type() !== 'project'): ?>
	<footer class="entry-footer" data-xy="grid">
		<div class="article-meta" data-xy="col 2xl:6 xl:6 lg:6 md:8 sm:12 xs:12 2xl:start-6 xl:start-6 lg:start-6 md:start-1 sm:start-auto xs-start-auto">
			<span class="author"><i class="dot rorange"></i><?= get_the_author(); ?></span>
			<span class="date"><i class="dot blue"></i><?= get_the_date(); ?></span>
			<!--<span class="share"><i class="dot pink"></i>SHARE STORY</span>-->
		</div>
	</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
