<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package sop
 */

$page_for_posts = get_option( 'page_for_posts' );
$page_ID = get_the_ID();

if(is_home() || is_404()) {
	$page_ID = $page_for_posts;
}

$last_updated = get_lastpostmodified('blog'); 
$not_formatted_date = strtotime( $last_updated );
$formatted_date = date( 'j F Y \a\t g:ia', $not_formatted_date ); 
?>

	<footer id="colophon" class="site-footer has-gutter has-jet-black-background-color">
		<section class="footer-content">

			<div class="contact-details">
				<div>
					<a href="mailto:<?= get_field('email', 'options'); ?>"><?= get_field('email', 'options'); ?></a><br />
					<a href="tel:<?= get_field('phone', 'options'); ?>"><?= get_field('phone', 'options'); ?></a>
				</div>
				<div>
					<?= get_field('address', 'options'); ?>
				</div>
			</div>
			<div class="footer-nav">
				<?php wp_nav_menu(array(
					'theme_location' => 'footer-menu',
					'menu_id' => 'footer-menu', // You can specify a unique ID for the menu
					'container' => 'nav'
				)); ?>
			</div>

			<div class="footer-acknowledgement">
				<p>State of Play acknowledges the Awabakal people, the traditional custodians of the land on which we work. We pay our respects to their elders both past and present.</p>
				<p class="subtle">© <?= date('Y'); ?> State of Play Agency</p>
				<!--<p class="subtle last-updated">Last update: <?= $formatted_date ?> v<?= wp_get_theme()->get('Version') ?></p>-->
			</div>
			<div class="footer-logo"><?php sop_logo_svg(); ?></div>


					<!--
					<div>
					<?php wp_nav_menu(array(
							'theme_location' => 'footer-social',
							'menu_id' => 'footer-social', // You can specify a unique ID for the menu
							'container' => 'nav'
						)); ?>
					</div> -->
		</section>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
