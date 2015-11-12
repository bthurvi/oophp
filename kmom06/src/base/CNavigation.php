<?php

class CNavigation
{
  public static function GenerateMenu($cssClass,$menu)
  {
    $html = "<nav class='$cssClass'>\n"; 
    $html .= "<ul>\n"; 
    
    //call the callback function then remove it's value from the array
    if(isset($menu['callback']))
    {
      $items = call_user_func($menu['callback'], $menu['items']);
    }
    
    //make menu items of the remaining parts of the array
    foreach ($items as $item) {
      if($item['class']=="activeNav")
        $html .= "<li class='activeNav'><a href='{$item['url']}'>{$item['text']}</a></li>";
      else
        $html .= "<li><a href='{$item['url']}'>{$item['text']}</a></li>";
    }
    
    $html .="</ul>\n";
    $html .="</nav>\n";
    
    return  $html;
  }
}
