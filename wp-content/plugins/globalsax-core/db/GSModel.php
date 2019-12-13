<?php

class GSModel {

    const PLUGIN_PREFIX = 'gs_';

    static function getTableName($name){
        global $wpdb;
        return  $wpdb->prefix . static::PLUGIN_PREFIX . $name;
    }

    static function getProductIdBySku( $sku ) {
        global $wpdb;

        $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

        if ( $product_id ) return $product_id;

        return null;
    }

    static function transaction(){
      global $wpdb;
      $wpdb->query("START TRANSACTION");
    }

    static function commit(){
      global $wpdb;
      $wpdb->query("COMMIT");
    }

    static function rollBack(){
      global $wpdb;
      $wpdb->query("ROLLBACK");
    }

}

?>
