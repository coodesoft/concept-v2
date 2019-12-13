<?php


class ClientesCriteria {

  private $internal;

  public function prepare($param){
    $this->internal = strtolower($param['client_id']);
  }


  public function check($listElement){
    return strtolower($listElement['client_id']) == $this->internal;
  }

}

?>