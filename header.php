<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
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

$black_header = get_field('black_header', $page_ID);

//var_dump( strtotime('2022-06-21T00:00:00Z') );

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>

<body <?php body_class('selection-rorange'); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'beechblocks' ); ?></a>

	<header id="masthead" class="site-header<?= $black_header ? ' has-off-black-background-color' : '' ?>">
		<div class="site-branding">
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" alt="<?php bloginfo( 'name' ); ?>" rel="home">
					<?php sop_logo_svg(); ?>
				</a>
			</div>
		</div><!-- .site-branding -->

		<div class="nav-wrap"> 
			<div class="darkmode toggle-wrapper">
        		<div class="toggle">
            		<input id="darkmodeInput" type="checkbox">
            		<label class="toggle-item" for="darkmodeInput"></label>
        		</div>
    		</div>

			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'header-menu',
					'menu_id'        => 'header-menu',
					'container' => 'nav'
				)
			);
			?>
			<a id="menuButton" class="nav-mobile-menu-button">Menu</a>
		</div><!-- #site-navigation -->
	</header><!-- #masthead -->
