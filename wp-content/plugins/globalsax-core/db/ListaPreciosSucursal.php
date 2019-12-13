<?php

require_once('GSModel.php');

class ListaPreciosSucursal extends GSModel{

    static function createTable(){

        global $wpdb;
        $table_name = static::getTableName('priceListSucursal');
        $charset_collate = $wpdb->get_charset_collate();
        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                sucursal_id bigint(20) NOT NULL,
                list_id bigint(20) NOT NULL
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    static function validate($params){
      if ( !$params['sucursal_id'] || !is_numeric($params['sucursal_id']) )
        return false;

      if ( !$params['list_id'] || !is_numeric($params['list_id']) )
        return false;

      return true;
    }

    static function add($params){
      global $wpdb;
      $table_name = static::getTableName('priceListSucursal');

      $data = ['sucursal_id' => $params['sucursal_id'], 'list_id' => $params['list_id'] ];
      $result = $wpdb->insert($table_name,  $data, ['%d', '%d']);
      if ($result !== false)
        return true;
      else
        throw new Exception('Se produjo un error al asociar una lista de precios a una sucursal', 1);
    }

    static function get($sucursal_id, $list_id){
      $data = ['sucursal_id' => $sucursal_id, 'list_id' => $list_id];
      if (static::validate($data)){
        global $wpdb;
        $table_name = static::getTableName('priceListSucursal');
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE sucursal_id=%d AND list_id=%d", [$sucursal_id, $list_id]);
        return $wpdb->get_results($query, ARRAY_A);
      } else
        throw new Exception("Se produjo un error al recurar una relación entre lista de precio y sucursal", 1);
    }

    static function getBySucursal($sucursal_id){

        if ( isset($sucursal_id) && is_numeric($sucursal_id) ){
            global $wpdb;
            $table_name = static::getTableName('priceListSucursal');
            $table_list = static::getTableName('priceList');
            $query = $wpdb->prepare("SELECT * FROM $table_name LEFT JOIN $table_list ON $table_list.id=$table_name.list_id WHERE sucursal_id=%d ", [$sucursal_id]);
            return $wpdb->get_results($query, ARRAY_A);
        } else
            throw new Exception("Se produjo un error de validación al recuperar una relación listas de precio y sucursal", 1);

    }
}
