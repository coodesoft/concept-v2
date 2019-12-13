<?php


class PrecioProductoCriteria {

    private $product_id;
    
    private $variation_sku;

    public function prepare($param){
        $this->variation_sku = strtolower($param['variation_sku']);
        $this->product_id = $param['product_id'];
    }


    public function check($listElement){
        return  ($listElement['product_id'] == $this->product_id) && (strtolower($listElement['variation_sku']) == $this->variation_sku);
    }

}

?>