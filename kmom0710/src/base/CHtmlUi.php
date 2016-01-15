<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CHtmlUi
 *
 * @author urbvik
 */
class CHtmlUi {
  //put your code here
  /*
   * Function that returns a select-box
   * @param: $item - string-array that contains the elements wanted
   */
  static function generateSelectList($items, $name=null, $selected=null, $disabled)
  {
    $h = " <select name='$name' id='$name' $disabled>";
    foreach ($items as $itm){
      if($selected==$itm){
      $h .= "<option value='$itm' selected='selected'>$itm</option>"; }
      else{
      $h .= "<option value='$itm'>$itm</option>"; } 
    }
    $h .= " </select>";
    
    return $h;
  }
 
}
