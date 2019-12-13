<?php

require_once('GSModel.php');

class PreciosProductos extends GSModel{


    static function createTable(){

        global $wpdb;
        $table_name = static::getTableName('productPrices');
        $charset_collate = $wpdb->get_charset_collate();

        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                product_id varchar(20) NOT NULL,
                variation_sku varchar(50),
                price float(10) NOT NULL,
                list_id bigint(20) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    static function add($params, $list_id){
        $product_sku = $params['Product_Id'];
        $variation_sku = $params['ProductVariation_Id'];
        $price = $params['Price'];

        if ($price != 0){
            if ($product_sku && is_string($product_sku)){

                $product_id = static::getProductIdBySku($product_sku);

                if ($product_id){
                    $stored = static::get($product_id, $product_sku, $list_id);

                    global $wpdb;
                    $table_name = static::getTableName('productPrices');

                    if (!$stored){
                        $toSave = [
                            'id' => 0,
                            'product_id'    => $product_id,
                            'variation_sku' => $variation_sku,
                            'price'         => $price,
                            'list_id'       => $list_id
                        ];

                        $query = "INSERT INTO $table_name ('id', 'product_id', 'variation_sku', 'price', 'list_id') VALUES (0, $product_id, $variation_sku, $price, $list_id)";
                        $result = $wpdb->insert($table_name, $toSave, ['%d', '%s', '%s', '%f', '%d']);
                        $return = $wpdb->intert_id;
                    } else{
                        $stored['price'] = $price;
                        $result = $wpdb->update($table_name, $stored, [ 'id' => $stored['id'] ]);
                        $return = $result;
                    }
                } else{
                    $result = 0;
                    $return = 0;
                }



                if ($result !== false)
                    return $return;
                else
                    throw new Exception('PreciosProductos - Se produjo un error al guardar un precio', 1);
            }
        }
        return null;
    }

    static function deleteByListId($list_id){
      global $wpdb;
      if ($list_id && is_numeric($list_id) && $list_id>0){
          $table_name = static::getTableName('productPrices');
          $result = $wpdb->delete( $table_name, ['list_id' => $list_id], ['%d']);
          if ($result)
            return true;
          else
            throw new Exception("Se produjo un error al eliminar un registro de precio. ListId: ".$list_id, 1);

      } else
        throw new Exception("Se produjo un error de validación de datos al eliminar un registro de precio.", 1);
    }

    static function batchSave($items, $list_id){
        global $wpdb;

        $valuesInsert = [];
        $valuesUpdate = [];

        foreach ( $items as $key => $item ) {

            $variation_sku  = $item['ProductVariation_Id'];
            $product_sku    = $item['Product_Id'];
            $price          = number_format($item['Price'], 2);

            if ($price != 0){
              if ($product_sku && is_string($product_sku)){
                  $product_id = static::getProductIdBySku($product_sku);
                  if ($product_id){
                      $stored = static::get($product_id, $variation_sku, $list_id);

                      if (!$stored)
                          $valuesInsert[] = $wpdb->prepare( "(%d, %s, %s, %f, %d)", [ 0, $product_id, $variation_sku, $price, $list_id ]);
                      else{
                        if ($stored['price'] != $price)
                          $valuesUpdate[] = [$stored['id'], $price];
                      }
                  }
              }
            }
          }
          $table_name = static::getTableName('productPrices');

          if (count($valuesInsert)){
            $query = "INSERT INTO $table_name (id, product_id, variation_sku, price, list_id) VALUES " . implode( ", ", $valuesInsert );
            $resultInsert = $wpdb->query( $query );
          }

          if (count($valuesUpdate))
            foreach($valuesUpdate as $value){
              $query = "UPDATE $table_name SET price=$value[1] WHERE id=$value[0];";
              $result = $wpdb->query( $query );
              if ($result === false)
                throw new Exception('Se produjo un error al actualizar precios existentes: [id: '.$value[0].']');
            }

          if ($resultInsert === false)
            throw new Exception('Se produjo un error al guardar nuevos precios en la db');

          return true;

    }

    static function batchReset(){
      $table_name = static::getTableName('productPrices');
      $query = 'UPDATE '.$table_name.' SET price=0';

      global $wpdb;
      $result = $wpdb->query( $query );
      if ($result === false)
        throw new Exception('Se produjo un error al reiniciar los precios de los productos!');

      return true;
    }

    static function get($product_id, $variation_sku, $list_id){

        if ( strpos($product_id, ' ') || strpos($variation_sku, ' ') || strpos($list_id, ' ') ){
            throw new Exception('PreciosProductos - Párametros inválidos! : Uno o mas parámetros recibidos son inválidos '.$data);
        }

        global $wpdb;
        $table_name = static::getTableName('productPrices');

        // TODO: Hay que filtrar los parametros con el método $wpdb->prepare para evitar posible inyección SQL
        $query  = "SELECT * FROM ". $table_name . " WHERE ";
        $query .= "product_id='" . $product_id . "' AND ";
        $query .= "variation_sku='" . $variation_sku . "' AND ";
        $query .= "list_id='" . $list_id . "'";

        return $wpdb->get_row($query, ARRAY_A);

    }

    static function getByListId($list_id){
        if ( isset($list_id) && is_numeric($list_id) ){
            global $wpdb;
            $table_name = static::getTableName('productPrices');

            $query = $wpdb->prepare('SELECT * FROM '.$table_name.' WHERE list_id=%d', [$list_id] );

            return $wpdb->get_results($query, ARRAY_A);
        } else
            throw new Exception('PreciosProductos -getByListId - Párametros inválidos! : Uno o mas parámetros recibidos son inválidos '.$data);
    }


    static function getByMultiplesListsIds($ids){
      if ( isset($ids) && is_array($ids) ){
          global $wpdb;
          $table_name = static::getTableName('productPrices');

          $params = [];
          foreach ($ids as $key => $id) {
            $params[] = $wpdb->prepare('%d', $id);
          }

          $query = "SELECT * FROM $table_name WHERE list_id IN (". implode(', ', $params).")";
          return $wpdb->get_results($query, ARRAY_A);
      } else
          throw new Exception('PreciosProductos -getByMultiplesListsIds - Párametros inválidos! : Uno o mas parámetros recibidos son inválidos '.json_encode($ids));

    }
}

?>
