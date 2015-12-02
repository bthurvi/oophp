<?php


/**
 * Description of CMovieSearch
 *
 * @author urbvik
 */
class CMovieSearch
{

  
  public static function getSearchForm($p,$page,$hits,$title,$year1,$year2, $databasehandle)
  {
    $genres = self::getGenres($databasehandle, $p);
    
    
    
    return <<< eod
     <form method="get" class='searchpanel'>
      <input type=hidden name=p value='$p'/>
      <input type=hidden name=hits value='$hits'/>
      <input type=hidden name=page value='1'/>
      <p><label style='display: inline-block; width:170px;'>Välj genre:</label> $genres</p>
      <p><label style='display: inline-block; width:170px;'>Titel (eller del av titel): </label><input type='search' autofocus="autofocus" name='title' value='$title'/></p>
      <p><label style='display: inline-block; width:170px;'>Skapad mellan åren: </label><input type='text' name='year1' value='$year1'/> - <input type='text' name='year2' value='$year2'/></p>
      <p><a href='?p=$p' class='aButton' style='float:right; margin-right:14px;'>Visa alla</a><input class='aButton' type='submit' name='submit' value='Sök'/></p>
    </form>    
eod;
  }
  
  private static function getGenres($databasehandle,$p)
  {
    // Get all genres that are active
    $sql = '
      SELECT DISTINCT G.name
      FROM Genre AS G
        INNER JOIN Movie2Genre AS M2G
          ON G.id = M2G.idGenre
    ';
    $res = $databasehandle->ExecuteSelectQueryAndFetchAll($sql);

    $genres = null;
    foreach($res as $val) 
    {
        $genres .= "<a class='blueButton' href='?p=$p&amp;genre={$val->name}'>{$val->name}</a> ";  
    }
    
    return $genres;
  }
  
  public static function ExecuteSelectQueryAndFetchAll($page,$hits,$title,$year1,$year2, $genre, $order, $orderby, $databasehandle)
  {
    // Prepare the query based on incoming arguments
    $sqlOrig = '
      SELECT 
           M.id as id, M.title as titel, M.image as bild ,M.plot as handling, GROUP_CONCAT(G.name) AS genre, M.rentalprice as pris
      FROM Movie AS M
        LEFT OUTER JOIN Movie2Genre AS M2G
          ON M.id = M2G.idMovie
        INNER JOIN Genre AS G
          ON M2G.idGenre = G.id
    ';
    $where    = null;
    $groupby  = ' GROUP BY M.id';
    $limit    = null;
    $sort     = " ORDER BY ".$orderby ." ".$order;
    $params   = array();

    // Select by title
    if($title) {
      $where .= ' AND title LIKE ?';
      $params[] = '%'.$title.'%';
    } 

    // Select by year
    if($year1) {
      $where .= ' AND year >= ?';
      $params[] = $year1;
    } 
    if($year2) {
      $where .= ' AND year <= ?';
      $params[] = $year2;
    } 

    // Select by genre
    if($genre) {
      $where .= ' AND G.name = ?';
      $params[] = $genre;
    } 

    // Pagination
    if($hits && $page) {
      $limit = " LIMIT $hits OFFSET " . (($page - 1) * $hits);
    }

    // Where
    $where = $where ? " WHERE 1 {$where}" : null;
    
    // Execute query without pagination and count results
    $sql = $sqlOrig . $where . $groupby . $sort;
    $res = $databasehandle->ExecuteSelectQueryAndFetchAll($sql,$params);
    $max = count($res);
    
    // Execute query with pagination
    $sql = $sqlOrig . $where . $groupby . $sort . $limit;
    $res = $databasehandle->ExecuteSelectQueryAndFetchAll($sql,$params);
    
    
    // Build array and return BOTH results
    $return['maxresults'] = $max;
    $return['resultset'] = $res;
    return $return;
   
    
  }
  
  
  

}
