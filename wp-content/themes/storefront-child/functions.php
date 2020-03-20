<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
 
    $parent_style = 'parent-style'; // 
 
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

remove_action( 'storefront_header', 'storefront_header_cart', 10 );
add_action( 'storefront_header', 'custom_header_cart', 70 );
function custom_header_cart() {
    if ( storefront_is_woocommerce_activated() ) {
        if ( is_cart() ) {
            $class = 'current-menu-item';
        } else {
            $class = '';
        }
        ?>
    <ul id="custom-header-cart" class="site-header-cart menu">
        <li class="<?php echo esc_attr( $class ); ?>">
            <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'storefront' ); ?>">
                <?php /* translators: %d: number of items in cart */ ?>
            </a>
        </li>
        <li>
            <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
        </li>
    </ul>
        <?php
    }
}

require_once(get_stylesheet_directory() . '/inc/storefront-template-functions.php');
require_once(get_stylesheet_directory() . '/inc/storefront-template-hooks.php');
require_once(get_stylesheet_directory() . '/inc/woocommerce/storefront-woocommerce-template-hooks.php');
require_once(get_stylesheet_directory() . '/inc/woocommerce/storefront-woocommerce-template-functions.php');





