<?php

class ClientesController {

    public function __construct(){
        add_action('wp_ajax_get_sincronizar_cliente', array($this, 'sincronizar') );
        add_action('wp_ajax_gs_load_sucursales', array($this, 'loadSucursales') );
                add_action('wp_ajax_gs_load_pricelist_by_client', array($this, 'loadPriceLists') );
    }

    public function sincronizar(){
        $successOperation = true;
        $errorMessage = '';

        //$wsNormalizedClients = [];

        $jsonClients = Requester::get('Client');
        $clients = json_decode($jsonClients, true);

        $storedClients = Clientes::getAll();
        $storedPriceLists = ListaPrecios::getAll();

        $clientCriteria = new ClientesCriteria();
        $listaCriteria = new ListaPreciosCriteria();

        Clientes::transaction();
        foreach($clients as $client){
            $client = array_change_key_case($client, CASE_LOWER);

            $clientCriteria->prepare($client);
            $stored = Filter::filterArrayElement($storedClients, $clientCriteria);
            if (!$stored){

                try{
                    $result = Clientes::add($client);

                    if($result['status']){

                        // Vinculo las listas de precios al cliente (se pasa el id interno de wordpress, no el que viene del webservice)
                        $parcial = $this->linkPriceListToClient($storedPriceLists, $client['pricelist'], $result['insert_id'], $listaCriteria);

                        // Agrego y vinculo sucursales con listas de precios existentes
                        $sucursales = array_change_key_case($client['sucs'], CASE_LOWER);
                        $this->addSucursales($sucursales, $storedPriceLists, $result['insert_id'], $listaCriteria);

                    } else{
                        $successOperation = false;
                        $errorMessage = 'No se pudo guardar el cliente';
                        break;
                    }

                } catch (Exception $e){
                    $successOperation = false;
                    $errorMessage = $e->getMessage();
                    break;
                }


            } else{
                // TO DO: agregar soporte para actualización y borrado
            }

        }

        if ($successOperation){
            Clientes::commit();
            echo json_encode(['status' => true, 'msg' => 'Sincronización de clientes exitosa!']);
        }else{
            Clientes::rollBack();
            echo json_encode(['status' => false, 'msg' => $errorMessage]);
        }

        wp_die();

    }

    private function linkPriceListToClient($storedLists, $priceLists, $client_id, $criteria){

        foreach($priceLists as $listName){

            $criteria->prepare(['name' => $listName]);
            $list = Filter::filterArrayElement($storedLists, $criteria);

            if ( $list ){
                $data = [
                    'client_id' => $client_id,
                    'list_id' => $list['id']
                ];
                ListaPreciosCliente::add($data);
            }
        }
    }

    private function linkPriceListToSucursal($listasPrecios, $storedPriceLists, $criteria, $id){

        foreach($listasPrecios as $listaPrecioSucName){
            $criteria->prepare(['name' => $listaPrecioSucName]);
            $list = Filter::filterArrayElement($storedPriceLists, $criteria);

            //si existe la lista de precios, hago la vinculación con la sucursal
            if ($list){
                $data = [
                    'sucursal_id' => $id,
                    'list_id' => $list['id'],
                ];
                ListaPreciosSucursal::add($data);
            }
        }
    }

    private function addSucursales($sucursales, $storedPriceLists, $insert_id, $criteria){
        $result = true;
        foreach($sucursales as $sucursal){
            $sucursal = array_change_key_case($sucursal, CASE_LOWER);
            $sucursal['insert_id'] = $insert_id;
            $result = Sucursal::add($sucursal);
            //retorna status=true si la pudo agregar o si ya existía.

            $listasPreciosSucursales = array_change_key_case($sucursal['pricelist'], CASE_LOWER);
            $this->linkPriceListToSucursal($listasPreciosSucursales, $storedPriceLists, $criteria, $result['insert_id'] );
        }
    }

    public function loadSucursales(){
        if (isset($_POST['client'])){
            $sucursales = Sucursal::getByClientId($_POST['client']);
            $count = count($sucursales);

            if ($count > 1){
                $return = [ 'state' => State::LIST_SUCURSALES, 'data'  => $sucursales ];
            } elseif ($count == 1){
                $return = [ 'state' => State::SINGLE_SUCURSAL, 'data'  => $sucursales[0] ];
            } else{
                $return = [ 'state' => State::NO_SUCURSALES, 'data'  => null ];
            }
        } else
            $return = [ 'state' => State::PARAM_ERROR, 'data'  => null ];

        echo json_encode($return);
        wp_die();
    }

    public function loadPriceLists(){
        if (isset($_POST['client'])){
            $priceLists = ListaPrecios::getByCliente($_POST['client']);
            $count = count($priceLists);
                                   
            if ($count>1){
                $return = [ 'state' => State::MULTIPLE_PRICELIST, 'data'  => $priceLists ];
            } elseif ($count == 1){
                $return = [ 'state' => State::SINGLE_PRICELIST, 'data'  => $priceLists[0] ];
            } else{
                $return = [ 'state' => State::NO_PRICELIST, 'data' => null ];
            }
            
        } else
            $return = [ 'state' => State::PARAM_ERROR, 'data'  => null ];
        
        echo json_encode($return);
        wp_die();
    }    
}

$clientesController = new ClientesController();

?>
