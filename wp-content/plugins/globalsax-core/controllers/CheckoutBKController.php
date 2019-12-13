<?php



class CheckoutBKController {


    public function __construct(){
        add_action('wp_ajax_gs_calculate_prices', array($this, 'calculate') );
    }

    public function _calculate($priceLists = null){
         
        if (isset($priceLists)){

            $countPriceLists = count($priceLists);
            $priceListIds = [];
            for ($i=0; $i < $countPriceLists; $i++) 
              $priceListIds[] = $priceLists[$i]['list_id'];
            
            $prices = PreciosProductos::getByMultiplesListsIds($priceListIds);
        }

        $criteria = new PrecioProductoCriteria();
        $product_list = [];

         foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ){
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
            $product_cat = get_the_terms($product_id, 'product_cat');
            $product_cat = $product_cat[0]->name;

            $variation = $cart_item['variation_id'] ? (new WC_Product_Variation($cart_item['variation_id'])) : null;

             $inCart = [
                 'product_id' => $product_id,
                 'variation_sku' => $variation ? $variation->get_sku() : $variation,
             ];
             $criteria->prepare($inCart);
             
             $price = isset($priceLists) ? Filter::filterArrayElement($prices, $criteria) : 0;

             if (array_key_exists($product_cat, $product_list) ){
               //  if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ){
                 $product_list[$product_cat]['cant'] += $cart_item['quantity'];
                 $product_list[$product_cat]['price'] += $price['price'] * $cart_item['quantity'];
                 $product_list[$product_cat]['price'] = round($product_list[$product_cat]['price'], 2);
                 
             //    }
             } else{
                 $product_list[$product_cat] = [];
                 $product_list[$product_cat]['name'] = $product_cat;
                 $product_list[$product_cat]['cant'] = $cart_item['quantity'];
                 $product_list[$product_cat]['price'] = $price['price'] * $cart_item['quantity'];
                 $product_list[$product_cat]['price'] = round($product_list[$product_cat]['price'], 2);

             }
        }
        return $product_list;
    }
    

    public function calculate(){
        $priceLists = null;

        if ( isset($_POST['sucursal']) )
            $priceLists = ListaPrecios::getBySucursal($_POST['sucursal']);

        if ( isset($_POST['client']) )
            $priceLists = ListaPrecios::getByClientId($_POST['client']);

        if ( $priceLists && !empty($priceLists) ){
            $product_list = $this->_calculate($priceLists);
            
            $return =  ['state' => State::UPDATE_PRICELIST, 'data' => $product_list];
        } else
             $return = ['state' => State::PARAM_ERROR, 'data' => null];
        
        echo json_encode($return);
        wp_die(); 
    }
}

$CheckoutController = new CheckoutBKController();

?>