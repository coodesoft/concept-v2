<?php


class ListaPreciosCriteria {

  private $internal_name;

  public function prepare($param){
    $this->internal_name = strtolower($param['name']);
  }


  public function check($listElement){
    return strtolower($listElement['name']) == $this->internal_name;
  }

}

?>
