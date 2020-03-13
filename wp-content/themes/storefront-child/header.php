<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package storefront
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2.0">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php do_action( 'storefront_before_site' ); ?>

<div id="page" class="hfeed site">
	<?php do_action( 'storefront_before_header' ); ?>

	<header id="masthead" class="site-header" role="banner" style="<?php storefront_header_styles(); ?>">
			
		<div class="col-full custom-container">
			<div class="search-container">
				<?php
				if ( storefront_is_woocommerce_activated() ) { ?>
					<div class="site-search custom-search">
						<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
					</div>
				<?php } ?>
			</div>
			<div class="logo-container">
				<img src="<?php echo get_template_directory_uri() . '-child/assets/img/cropped-Logo-cuadrado-scaled.png';?>" alt="logo">
			</div>
			<div class="cart-container">
				<a class="mailto" href="mailto:info@conceptmoda.com.ar">info@conceptmoda.com.ar</a>
				<?php custom_header_cart(); ?>
			</div>
		</div>
		<div class="navigation">
			<?php storefront_primary_navigation(); ?>
		</div>

	</header><!-- #masthead -->

	<?php
	/**
	 * Functions hooked in to storefront_before_content
	 *
	 * @hooked storefront_header_widget_region - 10
	 * @hooked woocommerce_breadcrumb - 10
	 */
	do_action( 'storefront_before_content' );
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

		<?php
        do_action( 'storefront_content_top' );
        