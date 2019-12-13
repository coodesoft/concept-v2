<?php


class Filter {


  static function filterArrayElement($array, $criteria){
      foreach($array as $element){
        if ( $criteria->check($element) )
            return $element;
      }
      return null;
  }

  static function diffArrays($arrayA, $arrayB, $criteria){
    $diffs = [];

    foreach($arrayA as $elementA){
      $criteria->prepare($elementA);
      $checked = false;    
      foreach($arrayB as $elementB){
        if ( $criteria->check($elementB) ){
            $checked = true;
            break;
        }
      }
        
      if (!$checked)
          $diffs[] = $elementA;
      
    }
    
    return $diffs;

  }


}

?>
