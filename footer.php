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

$black_footer = get_field('black_footer', $page_ID);

$last_updated = get_lastpostmodified('blog'); 
$not_formatted_date = strtotime( $last_updated );
$formatted_date = date( 'j F Y \a\t g:ia', $not_formatted_date ); 
?>

	<footer id="colophon" class="site-footer has-gutter<?= $black_footer ? ' has-off-black-background-color' : ''; ?>">
		<section class="footer-content" data-xy="grid">
			<div class="contact-details" data-xy="col 2xl:6 xl:6 md:6 sm:6 xs:6 sm:start-7 xs:start-7">
				<p>
					<a href="mailto:<?= get_field('email', 'options'); ?>"><?= get_field('email', 'options'); ?></a><br />
					<a href="tel:<?= get_field('phone', 'options'); ?>"><?= get_field('phone', 'options'); ?></a>
				</p>
				<p>
					<?= get_field('address', 'options'); ?>
				</p>
				<?= beech_color_boiz(); ?>
			</div>
			<div data-xy="col 2xl:6 xl:6 md:6 sm:12 xs:12">

				<?php wp_nav_menu(array(
					'theme_location' => 'footer-menu',
					'menu_id' => 'footer-menu', // You can specify a unique ID for the menu
					'container' => 'nav'
				)); ?>
				<div data-xy="grid">
					<div data-xy="col 2xl:4 xl:4 md:4 sm:6 xs:6 sm:start-7 xs:start-7">
					<?php wp_nav_menu(array(
							'theme_location' => 'footer-social',
							'menu_id' => 'footer-social', // You can specify a unique ID for the menu
							'container' => 'nav'
						)); ?>
					</div>
					<div class="acknowledgement acknowledgement-desktop" data-xy="col 2xl:8 xl:8 md:12 sm:12 xs:12">
						<p>Beech acknowledges the Awabakal people, the traditional custodians of the land on which we work. We pay our respects to their elders both past and present.</p>
						<p>© <?= date('Y'); ?> Beech Agency</p>
						<p class="last-updated">Last update: <?= $formatted_date ?> v<?= wp_get_theme()->get('Version') ?></p>
					</div>
				</div>
			</div>
		</section>
		<section class="max-logo">
			<div class="acknowledgement acknowledgement-mobile" data-xy="col 2xl:8 xl:8 md:12 sm:12 xs:12">
				<p>Beech acknowledges the Awabakal people, the traditional custodians of the land on which we work. We pay our respects to their elders both past and present.</p>
				<p>© <?= date('Y'); ?> Beech Agency</p>
				<p class="last-updated">Last update: <?= $formatted_date ?> v<?= wp_get_theme()->get('Version') ?></p>
			</div>

			<svg version="1.1" id="beechLogoFull" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
				viewBox="0 0 608 55" style="enable-background:new 0 0 608 55;" xml:space="preserve">
				<g>
					<path class='letter beech' d="M34.3,53.5H0.1v-52h34.1c10.3,0,17,5.8,17,12.4c0,6.7-3.8,11.6-9.6,13.1c3.8,1,9.6,4.2,9.6,12.7
						C51.3,46.9,44.1,53.5,34.3,53.5z M29.3,17.2h-8.6v5.3h8.6c1.4,0,2.7-1.2,2.7-2.7S30.7,17.2,29.3,17.2z M29.3,32.5h-8.6v5.3h8.6
						c1.4,0,2.7-1.2,2.7-2.7C31.9,33.7,30.7,32.5,29.3,32.5z"/>
					<path class='letter beech' d="M54.7,53.5v-52h47v15.7H75.2v5.3h12.9v9.9H75.2v5.3h26.5v15.7h-47V53.5z"/>
					<path class='letter beech' d="M105.8,53.5v-52h47v15.7h-26.5v5.3h12.9v9.9h-12.9v5.3h26.5v15.7h-47V53.5z"/>
					<path class='letter beech' d="M182,54.8c-14.9,0-26.9-12.2-26.9-27.3s12-27.3,26.9-27.3c13.5,0,23,9.9,24.4,23h-16.9c-0.6-5-4-7-6.8-7
						c-3.5,0-7,3.2-7,11.3c0,8.1,3.5,11.3,7,11.3c2.7,0,6-2,6.7-6.8h17C205,45,195.4,54.8,182,54.8z"/>
					<path class='letter beech' d="M242.7,53.5V35.2h-12.2v18.3H210v-52h20.5v18.8h12.2V1.5h20.5v52H242.7z"/>
					<path class='letter agency' d="M319.3,53.5l-2.2-6.8h-16.6l-2.2,6.8h-17.2l19.3-52H321l19.6,52H319.3z M308.5,21.6l-4.4,13.8h9.1L308.5,21.6z"/>
					<path class='letter agency' d="M383.2,53.5l-3.2-6.6c-3,4.7-9.4,7.9-15.9,7.9c-14.9,0-27-12.2-27-27.3s12.1-27.3,27-27.3c13.4,0,25.2,9.8,25.2,23h-16.9
						c0-4-2.9-7-6.7-7c-4.8,0-7.9,4-7.9,11.3c0,7.2,3.6,11.3,7.8,11.3c3.9,0,6-2.8,6.6-5.9h-5.9V27h22.8v26.5H383.2z"/>
					<path class='letter agency' d="M393.3,53.5v-52h47v15.7h-26.5v5.3h12.9v9.9h-12.9v5.3h26.5v15.7h-47V53.5z"/>
					<path class='letter agency' d="M480.2,53.5l-18.3-22.8v22.8h-17.5v-52h18.3l17.5,22.6V1.5h17.5v52H480.2z"/>
					<path class='letter agency' d="M528.3,54.8c-14.9,0-26.9-12.2-26.9-27.3s12-27.3,26.9-27.3c13.5,0,23,9.9,24.4,23h-16.9c-0.7-5-4-7-6.8-7
						c-3.5,0-7,3.2-7,11.3c0,8.1,3.5,11.3,7,11.3c2.7,0,6-2,6.7-6.8h17C551.3,45,541.7,54.8,528.3,54.8z"/>
					<path class='letter agency' d="M587.8,33.1v20.4h-20.5V33.1L548.1,1.5h23.5l7.7,15.5l8.1-15.5h20.5L587.8,33.1z"/>
				</g>
			</svg>
			<div class="mobile-logo"><?php sop_logo_svg(); ?></div>
		</section>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
