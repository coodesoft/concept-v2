<?php
/**
 * @use [products]
 */
add_shortcode('products', 'productsbyCategory');
function productsbyCategory(){
    $args = array(
        'taxonomy'   => "product_cat",
        'number'     => $number,
        'orderby'    => $orderby,
        'order'      => $order,
        'hide_empty' => $hide_empty,
        'include'    => $ids
    );
    $product_categories = get_terms($args);

    $print = '<div class="row">';
    $it = 1;
    foreach ($product_categories as $key => $value){
        if ($value["parent"] = 0){
            $print .= '<div class="col-md-4"><div class="bloque_gris"></div>';
            $print .= '<h3>' . $value["name"] .'</h3>';
            $print .= '</div>';
            if ($it % 3 == 0) {
                echo $print . "</div>";
                $print = '<div class="row">';
            }
            $it++;
        }
    }
    if ($it !== 0) echo $print . "</div>";
}