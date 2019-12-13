<?php

require_once('GSModel.php');


class Sucursal extends GSModel{


    static function createTable(){

        global $wpdb;
        $table_name = static::getTableName('sucursales');
        $charset_collate = $wpdb->get_charset_collate();
        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                client_id bigint(20) NOT NULL,
                sucursal varchar(20) NOT NULL,
                seller_id bigint(20) NOT NULL,
                PRIMARY KEY (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    static function validate($params){

      if ( !isset($params['insert_id']) || !isset($params['sucname']) || !isset($params['seller_id']) )
        return false;

      if (trim($params['insert_id']) != $params['insert_id'])
        return false;

      if (trim($params['sucname']) != $params['sucname'])
        return false;

      if (trim($params['seller_id']) != $params['seller_id'])
        return false;

      return true;
    }

    static function add($params){
        $client_id = trim($params['insert_id']);
        $sucursal = trim($params['sucname']);
        $seller_id = trim($params['seller_id']);

        if (static::validate($params)){

          $stored = static::get($client_id, $sucursal);
          if (!$stored){
            global $wpdb;
            $table_name = static::getTableName('sucursales');
            $data = [
              'id' => 0,
              'client_id' => $client_id,
              'sucursal'  => $sucursal,
              'seller_id' => $seller_id,
            ];
            $result = $wpdb->insert($table_name, $data, ['%d', '%d', '%d', '%d']);
            if ($result)
              return ['status' => true, 'insert_id' => $wpdb->insert_id];
            else
              throw new Exception("Se produjo un error al guardar una sucursal", 1);

          } else
            // ahora se retorna esto pero habría que pensar el esquema de actualización
            return ['status' => true, 'insert_id' => $stored['id']];

        } else
          throw new Exception("Se produjo un error al guardar una sucursal. Error de validación en los parámetros ". json_encode($params), 1);

    }

    static function get($client_id, $sucursal){
      if (!$client_id || !$sucursal)
        throw new Exception('Sucursal Get - Parámetros inválidos', 1);

      global $wpdb;
      $table_name = static::getTableName('sucursales');

      $query = "SELECT * FROM " . $table_name . " WHERE ";
      $query .= "client_id='" . $client_id . "' AND ";
      $query .= "sucursal='" . $sucursal ."'";

      return $wpdb->get_row($query, ARRAY_A);
    }

    static function getByClientId($id){
      if ( $id && is_numeric($id) ){
        global $wpdb;
        $table_name = static::getTableName('sucursales');

        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE client_id=%d", [$id]);
        return $wpdb->get_results($query, ARRAY_A);
      } else
        throw new Exception('Sucursal getByClientId - Parámetro inválido', 1);
    }
}

?>
