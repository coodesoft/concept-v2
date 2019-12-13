<?php
/**
 * Cart Page
 *
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
require_once(__DIR__.'/../db/UserClientRelation.php');

add_shortcode( 'gbs_cart_template', 'gbs_cart');
function gbs_cart($atts){
	wc_print_notices();

	do_action( 'woocommerce_before_cart' );

    if ( !is_admin() ){ ?>

        <div id="gbsCheckout">
            <form class="woocommerce-cart-form gbs-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

                <div class="datos_user_cart">

                <?php if( is_user_logged_in()  ) {
                    //obtengo el usuario
                    $user = wp_get_current_user(); ?>
                    <div class="order-owner trescol"> Pedido de: <?php echo $user->user_firstname ." ". $user->user_lastname ?></div>

                       <?php
                            $clientes = UserClientRelation::getClientByUserId($user->ID);
                            $countClientes = count($clientes);
                            $checkoutController = new CheckoutController();

                            if ($countClientes > 1)

                                $products = $checkoutController->_calculate();

                            elseif ($countClientes == 1){

                                $cliente = $clientes[0];
                                $sucursales = Sucursal::getByClientId($cliente['id']);
                                $countSucursales = count($sucursales);

                                if ($countSucursales > 1)

                                    $products = $checkoutController->_calculate();

                                elseif ($countSucursales == 1){
                                    $sucursal = $sucursales[0];

                                    $listas = ListaPrecios::getBySucursal($sucursal['id']);
                                    $countListas = count($listas);

                                    if ($countListas>1)

                                        $products = $checkoutController->_calculate();

                                    elseif ($countListas == 1){
                                        $lista = $listas[0];
                                        $products = $checkoutController->_calculate($lista['list_id']);
                                    }

                                } else{
                                    $listas = ListaPrecios::getByCliente($cliente['id']);
                                    $countListas = count($listas);

                                    if ($countListas > 1)

                                        $products = $checkoutController->_calculate();

                                    elseif ($countListas == 1){
                                        $lista = $listas[0];
										$products = $checkoutController->_calculate($lista['list_id']);
									} else
                                        $products = $checkoutController->_calculate();
                                }
                            }
                        ?>
                    <div class="gsSelectorContent">
                        <div class="clienteTarget"> <?php ClienteDOM::selector($clientes); ?> </div>
                        <div class="sucursalTarget"><?php isset($sucursales) ? SucursalDOM::selector($sucursales) : '';?></div>
                        <div class="priceListTarget"><?php isset($listas) ? ListaPreciosDOM::selector($listas): '' ?></div>

                    </div>
		        	</div>
                    <div class="gsCartContent">
                        <?php echo CartResumeDOM::cart($products); ?>
                    </div>


                <div class="user-actions">
                    <div class="save-order">
                        <input type="radio" name="pedido" value="G" checked=""> Agrega pendientes
                    </div>
                    <div class="null-order">
                        <input type="radio" name="pedido" value="A"> Anular pendientes
                    </div>
                </div>
		    <?php do_action( 'woocommerce_after_cart_table' ); ?>
            </form>
        </div>
        <?php }
    }
}

?>
