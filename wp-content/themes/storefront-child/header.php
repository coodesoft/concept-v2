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
						<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'woocommerce' ); ?></label>
							<i class="fas fa-search"></i>
							<input type="search" id="product-search-input" class="search-field" placeholder="BÚSQUEDA" value="<?php echo get_search_query(); ?>" name="s" />
							<div class="social-header-links">
								<a href="https://facebook.com"><img src="<?php echo get_template_directory_uri() . '-child/assets/img/fb.png';?>" alt="Facebook"></a>
								<a href="https://instagram.com"><img src="<?php echo get_template_directory_uri() . '-child/assets/img/in.png';?>" alt="Instagram"></a>
								<a href="https://linkedin.com"><img src="<?php echo get_template_directory_uri() . '-child/assets/img/linkn.png';?>" alt="Linkedin"></a>
							</div>
							<button type="submit" class="submit-hidden" value="<?php echo esc_attr_x( 'Search', 'submit button', 'woocommerce' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'woocommerce' ); ?></button>
							<input type="hidden" name="post_type" value="product" />
						</form>
					</div>
				<?php } ?>
			</div>
			<div class="logo-container">
				<img src="<?php echo get_template_directory_uri() . '-child/assets/img/cropped-Logo-cuadrado-scaled.png';?>" alt="logo">
			</div>
			<div class="cart-container">
				<div class="sendmail">
					<i class="fas fa-envelope"></i><a class="mailto" href="mailto:info@conceptmoda.com.ar">info@conceptmoda.com.ar</a>
				</div>
				<button class="login">LOGIN </button>
				<?php custom_header_cart(); ?>
			</div>
		</div>
		<div id="navbar" class="navigation">
			<div class="logo-nav">
				<img src="<?php echo get_template_directory_uri() . '-child/assets/img/cropped-Logo-cuadrado-scaled.png';?>" alt="Concept">
			</div>
			<?php storefront_primary_navigation(); ?>
			<div class="cart-nav">
				<?php custom_header_cart(); ?>
			</div>
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
        