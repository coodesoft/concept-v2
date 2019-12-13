<?php


class CartResumeDOM {
    
    
    
    static function cart($product_list){ ?>
 

        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
            <thead>
                <tr>
                    <?php // ThemeFusion edit for Avada theme: change table layout and columns. ?>
                    <th class="product-name"> Categoría</th>
                    <th class="product-quantity">Cantidad</th>
                    <th class="product-price">Precio</th>
                </tr>
            </thead>
            <tbody id="gsCartContent">
                <?php 
                    $cant_total = 0;
                    $total_price = 0;
                    foreach ($product_list as $key => $category) { 
                        $cant_total += $category['cant'];
                        if ( isset($category['price']) )
                            $total_price += $category['price'];
                ?>
                <tr id="<?php echo str_replace(' ', '-', strtoupper($category['name'])) ?>">
                    <td class="product_name">
                        <div class="product-info">
                            <a href="#" class="product-title"><?php echo strtoupper($category['name']) ?> </span>
                        </div>
                    </td>
                    <td class="product-quantity">
                        <div class="quantity"><?php echo $category['cant'] ?></div>
                    </td>
                    <td class="product-price">
                        <div class="price"><?php echo isset($category['price']) ? round($category['price'], 2) : 0; ?></div>
                    </td>
                </tr>
                <?php } ?>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td class="total-ordered"><?php echo $cant_total ?></td>
                    <td class="total-price"><?php echo round($total_price, 2) ?></td>
                </tr>
            </tbody>
        </table>

        
    <?php }
       
}


?>