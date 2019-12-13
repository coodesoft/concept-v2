<?php

require_once('GSModel.php');

class ListaPrecios extends GSModel{

    static function createTable(){

        global $wpdb;
        $table_name = static::getTableName('priceList');
        $charset_collate = $wpdb->get_charset_collate();
        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                name varchar(50) NOT NULL,
                PRIMARY KEY  (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    static function validate($param){
      return ( isset($param) && is_string($param) && strlen($param)>0 );
    }

    static function add($name){

        if ( static::validate($name) ){
            global $wpdb;
            $table_name = self::getTableName('priceList');
            $result = $wpdb->insert( $table_name, ['id'=> 0, 'name' => $name], ['%d', '%s'] );
            if ($result)
                return [ 'status' => true, 'insert_id' => $wpdb->insert_id ];
            else
                throw new Exception("Se produjo un error al guardar una lista nueva. Name: ".$name, 1);

        } else
            throw new Exception("Se produjo un error de validación de datos al guardar una lista nueva. Name: ".$name, 1);
    }

    static function getByName($name, $limit = 1){

        if (static::validate($name)){
          global $wpdb;
          $table_name = static::getTableName('priceList');

          $trimed = trim($name);
          $name = stripslashes($trimed);

          if ($name != $trimed)
              throw new Exception('ListaPrecios - Dato inválido! : El nombre contiene espacios:', 1);

          $query = "SELECT * FROM " . $table_name . " WHERE name='" . $name . "'";

          if (!$limit && is_numeric($limit) && $limit > 0)
              $query .= ' LIMIT ' . $limit;

          return $wpdb->get_results($query, ARRAY_A);
        }

        return null;
    }

    static function getAll(){
      global $wpdb;
      $table_name = static::getTableName('priceList');
      $query = "SELECT * FROM " . $table_name;
      return $wpdb->get_results($query, ARRAY_A);
    }

    static function delete($id){
        if ($id && is_numeric($id) && $id>0){
          global $wpdb;
          $table_name = static::getTableName('priceList');

          $result = $wpdb->delete( $table_name, ['id' => $id], ['%d'] );
          if ($result)
            return true;
          else
            throw new Exception("Se produjo un error al borrar una lista. Id: ".$id, 1);
        } else
          throw new Exception("Se produjo un error al borrar una lista. Error de validación en el parámetro", 1);
    }

    
    static function getBySucursal($id){
        if (isset($id) && is_numeric($id))
            return ListaPreciosSucursal::getBySucursal($id);
        else
            throw new Exception('ListPrecios - getBySucursal - error de validación en parámetros', 1);
    }
    
    static function getByCliente($id){
        if (isset($id) && is_numeric($id))
            return ListaPreciosCliente::getByClientId($id);
        else
            throw new Exception('ListPrecios - getBySucursal - error de validación en parámetros', 1);
    }

}

?>
