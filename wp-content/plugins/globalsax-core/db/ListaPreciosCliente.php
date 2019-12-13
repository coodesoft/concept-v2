<?php

require_once('GSModel.php');

class ListaPreciosCliente extends GSModel{

    static function createTable(){

        global $wpdb;
        $table_name = static::getTableName('priceListClient');
        $charset_collate = $wpdb->get_charset_collate();
        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                client_id bigint(20) NOT NULL,
                list_id bigint(20) NOT NULL
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }


    static function validate($params){
      if ( !$params['client_id'] || !is_numeric($params['client_id']) )
        return false;

      if ( !$params['list_id'] || !is_numeric($params['list_id']) )
        return false;

      return true;
    }

    static function add($params){
      global $wpdb;
      $table_name = static::getTableName('priceListClient');

      $data = ['client_id' => $params['client_id'], 'list_id' => $params['list_id'] ];
      $result = $wpdb->insert($table_name,  $data, ['%d', '%d']);
      if ($result !== false)
        return true;
      else
        throw new Exception('Se produjo un error al asociar una lista de precios a un cliente', 1);
    }
    
    
    static function getByClientId($id){
        if (isset($id) && is_numeric($id)){
            global $wpdb;
            $table_name = static::getTableName('priceListClient'); 
            $table_list = static::getTableName('priceList');

            $query = $wpdb->prepare("SELECT * FROM $table_name LEFT JOIN $table_list ON $table_list.id=$table_name.list_id WHERE client_id=%d ", [$id]);

            return $wpdb->get_results($query, ARRAY_A);
        } else
            throw new Exception('Se produjo un error al recuperar una lista de precios por id de cliente. ID: '. $id, 1);
    }

    


}
