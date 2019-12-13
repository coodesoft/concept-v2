<?php

class Requester{

  const API_PATH = '/api';

  static function get($endpoint){
    $baseUrl = get_user_meta(1, 'url', true);
    $url = $baseUrl . self::API_PATH . '/' . $endpoint;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $json = curl_exec($ch);
    return $json;
  }



}

 ?>
