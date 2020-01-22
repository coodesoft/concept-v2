<?php if ( is_active_sidebar( 'envo-ecommerce-top-bar-area' ) ) { ?>
	<div class="top-bar-section container-fluid">
		<div class="<?php echo esc_attr( get_theme_mod( 'top_bar_content_width', 'container' ) ); ?>">
			<div class="row">
				<?php dynamic_sidebar( 'envo-ecommerce-top-bar-area' ); ?>
			</div>
		</div>
	</div>
<?php } ?>
<div class="site-header container-fluid">
	<div class="<?php echo esc_attr( get_theme_mod( 'header_content_width', 'container' ) ); ?>" >
		<div class="heading-row row" >
			<div class="site-heading col-md-6 col-xs-12" >
				<div class="site-branding-logo">
					<?php the_custom_logo(); ?>
				</div>
				<div class="site-branding-text">
					<?php if ( is_front_page() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>

					<?php
					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) :
						?>
						<p class="site-description">
							<?php echo esc_html( $description ); ?>
						</p>
					<?php endif; ?>
				</div><!-- .site-branding-text -->
			</div>	
		</div>
		<div class="home-link">
			<a href="#explore">
				<svg class="svg-inline--fa fa-angle-double-down fa-w-8 fa-2x" aria-hidden="true" data-fa-processed=""
					data-prefix="fal" data-icon="angle-double-down" role="img" xmlns="http://www.w3.org/2000/svg"
					viewBox="0 0 256 512">
					<path fill="currentColor"
						d="M119.5 262.9L3.5 145.1c-4.7-4.7-4.7-12.3 0-17l7.1-7.1c4.7-4.7 12.3-4.7 17 0L128 223.3l100.4-102.2c4.7-4.7 12.3-4.7 17 0l7.1 7.1c4.7 4.7 4.7 12.3 0 17L136.5 263c-4.7 4.6-12.3 4.6-17-.1zm17 128l116-117.8c4.7-4.7 4.7-12.3 0-17l-7.1-7.1c-4.7-4.7-12.3-4.7-17 0L128 351.3 27.6 249.1c-4.7-4.7-12.3-4.7-17 0l-7.1 7.1c-4.7 4.7-4.7 12.3 0 17l116 117.8c4.7 4.6 12.3 4.6 17-.1z">
					</path>
				</svg>
			</a>
		</div>
	</div>
</div>
	<?php do_action( 'envo_ecommerce_before_menu' ); ?> 
	<div id="explore" class="main-menu">
		<nav id="site-navigation" class="navbar navbar-default">     
			<div class="container">   
				<div class="navbar-header">
					<?php if ( function_exists( 'max_mega_menu_is_enabled' ) && max_mega_menu_is_enabled( 'main_menu' ) ) : ?>
					<?php elseif ( has_nav_menu( 'main_menu' ) ) : ?>
						<span class="navbar-brand brand-absolute visible-xs"><?php esc_html_e( 'Menu', 'envo-ecommerce' ); ?></span>
						<?php if ( function_exists( 'envo_ecommerce_header_cart' ) && class_exists( 'WooCommerce' ) ) { ?>
							<div class="mobile-cart visible-xs" >
								<?php envo_ecommerce_header_cart(); ?>
							</div>	
						<?php } ?>
						<?php if ( function_exists( 'envo_ecommerce_my_account' ) && class_exists( 'WooCommerce' ) ) { ?>
							<div class="mobile-account visible-xs" >
								<?php envo_ecommerce_my_account(); ?>
							</div>
						<?php } ?>
						<div id="main-menu-panel" class="open-panel" data-panel="main-menu-panel">
							<span></span>
							<span></span>
							<span></span>
						</div>
					<?php endif; ?>
				</div>
				<?php
        $menu_pos = get_theme_mod( 'main_menu_float', 'center' );
				wp_nav_menu( array(
					'theme_location'	 => 'main_menu',
					'depth'				 => 5,
					'container_id'		 => 'my-menu',
					'container'			 => 'div',
					'container_class'	 => 'menu-container',
					'menu_class'		 => 'nav navbar-nav navbar-' . $menu_pos,
					'fallback_cb'		 => 'wp_bootstrap_navwalker::fallback',
					'walker'			 => new wp_bootstrap_navwalker(),
				) );
				?>
			</div>
			<?php do_action( 'envo_ecommerce_menu' ); ?>
		</nav> 
	</div>
	<?php do_action( 'envo_ecommerce_after_menu' ); ?>
