<?php

/**
 * Description of CHTMLTable
 *
 * @author urbvik
 */
class CHTMLTable 
{
  public static function generateHTMLtableResult($res,$tableCSSid='',$hits,$page, $maxresults)
	{
    //table start
    if(empty($tableCSSid))
      $html = "<table>";
     else
      $html = "<table class='$tableCSSid'>";

		
     //create table headers
     $row = $res[0];
		 $rad="<tr>"; 
		 foreach ($row as $key => $value)
     {
        $sortbtns ='';
       if(!in_array($key, array('bild','genre','handling'))) //add sort buttons for all columns - but EXCLUDE bild and genre (not so general but easy to remove...)
        $sortbtns = self::orderby($key);
        
        if($key!='id')
		    $rad .= "<th>" .ucfirst($key) ." ".$sortbtns ."</th>";
     }
		 $html .= $rad . "</tr>";

		 //fill table cells with data
     foreach ($res as $nr => $row) 
		 {
		    $rad=''; 
		    $html .= "<tr>";
        $id=0;
		    foreach ($row as $key => $value)
        {
          if(substr($value,0,3)=='img')
            $rad .= "<td><img src='$value' width='80' height='40' alt='en bild'/></td>";
          else if($key=='id'){
            $id = $value;
          }
          else if($key=='titel')
            $rad .= "<td><a href='?p=movie&amp;id=$id'>$value</a></td>";
          else
            $rad .= "<td>$value</td>";
        }
		    $html .= $rad. "</tr>";
		 }

    //close table
		$html .= "</table>";
    
    //add hits buttons
    $html .= self::getHitsPerPage(array(3,5,10));
    
    //add page navigation buttons
    $max = ceil($maxresults / $hits);
    $html .= self::getPageNavigation($hits, $page, $max);
    
		return $html;
	}
  
    /**
   * Function to create links for sorting
   *
   * @param string $column the name of the database column to sort by
   * @return string with links to order by column.
   */
    private static function orderby($column) {
    $nav  = "<a class='sortButton' href='" . self::getQueryString(array('orderby'=>$column, 'order'=>'asc')) . "'>&darr;</a>";
    $nav .= "<a class='sortButton' href='" . self::getQueryString(array('orderby'=>$column, 'order'=>'desc')) . "'>&uarr;</a>";
    return "<span class='orderby'>" . $nav . "</span>";
  }
  
    /**
  * Use the current querystring as base, modify it according to $options and return the modified query string.
  *
  * @param array $options to set/change.
  * @param string $prepend this to the resulting query string
  * @return string with an updated query string.
  */
   private static function getQueryString($options=array(), $prepend='?') {
     // parse query string into array
     $query = array();
     parse_str($_SERVER['QUERY_STRING'], $query);

     // Modify the existing query string with new options
     $query = array_merge($query, $options);

     // Return the modified querystring
     return $prepend . htmlentities(http_build_query($query));
   }
  
  
    /**
   * Create links for hits per page.
   *
   * @param array $hits a list of hits-options to display.
   * @param array $current value.
   * @return string as a link to this page.
   */
  private static function getHitsPerPage($hits, $current=null) {
    $nav = "<div id='paginationhits'>Träffar per sida: ";
    foreach($hits AS $val) {
      if($current == $val) {
        $nav .= "<a class='aButton' href='" . self::getQueryString(array('hits' => $val)) . "'>$val</a> ";
      }
      else {
        $nav .= "<a class='aButton' href='" . self::getQueryString(array('hits' => $val)) . "'>$val</a> ";
      }
    }
    $nav .= '</div>';
    return $nav;
  }
  
  
        /**
     * Create navigation among pages.
     *
     * @param integer $hits per page.
     * @param integer $page current page.
     * @param integer $max number of pages. 
     * @param integer $min is the first page number, usually 0 or 1. 
     * @return string as a link to this page.
     */
    private static function getPageNavigation($hits, $page, $max, $min=1)
    {
      
      $nav = "<div class='postNavigationButtons'>";
      $nav .= "<a class='aButton' href='" . self::getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
      $nav .= "<a class='aButton' href='" . self::getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

      for($i=$min; $i<=$max; $i++) {
        $nav .= "<a class='aButton' href='" . self::getQueryString(array('page' => $i)) . "'>$i</a> ";
      }

      $nav .= "<a class='aButton' href='" . self::getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
      $nav .= "<a class='aButton' href='" . self::getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
      $nav .= "</div>";
      return $nav;
    }
}
