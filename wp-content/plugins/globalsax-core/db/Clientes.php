<?php


require_once('GSModel.php');

class Clientes extends GSModel{

    static function createTable(){

        global $wpdb;
        $table_name = static::getTableName('clientes');
        $charset_collate = $wpdb->get_charset_collate();
        if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {

            $sql = "CREATE TABLE $table_name (
                id bigint(20) NOT NULL AUTO_INCREMENT,
                client_id bigint(20) NOT NULL,
                name varchar(20) NOT NULL,
                seller_id bigint(20) NOT NULL,
                group_id varchar(20),
                PRIMARY KEY (id)
            ) $charset_collate;";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    static function validate($client){
        return true;
    }
    
    static function add($client){
        if (static::validate($client)){
            global $wpdb;

            $toSave = [
                $client['client_id'],
                $client['name'],
                $client['seller_id'],
                $client['enterprisegroup'] ? $client['enterprisegroup']: null,
            ];

            $table_name = self::getTableName('clientes');
            $statement = "INSERT INTO ". $table_name ." (`client_id`, `name`, `seller_id`, `group_id`) VALUES (%d, %s, %d, %s)";

            $query = $wpdb->prepare( $statement, $toSave );
            $result = $wpdb->query($query);

            if ($result)
                return ['status' => true, 'insert_id' => $wpdb->insert_id];
            else
                throw new Exception("Se produjo un error al guardar el cliente: " . json_encode([$toSave, $wpdb->last_query]), 1);
        } else
            throw new Exception("Se produjo un error de validación de parámetros al guardar un cliente con id: ".$client['client_id'], 1);

    }

    static function getByClientId($id){
        if ($id && is_numeric($id)){
            global $wpdb;
            $table_name = static::getTableName('clientes');

            $query = $wpdb->prepare("SELECT * FROM " . $table_name . " WHERE client_id=%d", $id);
            return $wpdb->get_row($query, ARRAY_A);
        } else
            throw new Exception('Clientes - Dato inválido! : El id es inválido', 1);

    }
    
    
    static function getAll(){
        global $wpdb;
        $table_name = static::getTableName('clientes');
        $query = "SELECT * FROM " . $table_name;
        return $wpdb->get_results($query, ARRAY_A);
    }


}

?>
