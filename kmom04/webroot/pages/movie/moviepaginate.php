
<h1 class="center">Paginering av filmer</h1>
<p class="center">Visa poster på flera sidor.</p>

<?php

/**
 * Use the current querystring as base, modify it according to $options and return the modified query string.
 *
 * @param array $options to set/change.
 * @param string $prepend this to the resulting query string
 * @return string with an updated query string.
 */
function getQueryString($options, $prepend='?') {
  // parse query string into array
  $query = array();
  parse_str($_SERVER['QUERY_STRING'], $query);

  // Modify the existing query string with new options
  $query = array_merge($query, $options);

  // Return the modified querystring
  return $prepend . http_build_query($query);
}


  /**
 * Create links for hits per page.
 *
 * @param array $hits a list of hits-options to display.
 * @return string as a link to this page.
 */
function getHitsPerPage($hits) {
  $nav = "Antal poster per sida: ";
  foreach($hits AS $val) {
    $nav .= "<a class='aButton' href='" . getQueryString(array('hits' => $val)) . "'>$val</a> ";
  }  
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
function getPageNavigation($hits, $page, $max, $min=1)
{
  $nav  = "<a class='aButton' href='" . getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
  $nav .= "<a class='aButton' href='" . getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";

  for($i=$min; $i<=$max; $i++) {
    $nav .= "<a class='aButton' href='" . getQueryString(array('page' => $i)) . "'>$i</a> ";
  }

  $nav .= "<a class='aButton' href='" . getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
  $nav .= "<a class='aButton' href='" . getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
  return $nav;
}

// Get parameters for sorting
$hits  = isset($_GET['hits']) ? $_GET['hits'] : 8;
$page  = isset($_GET['page']) ? $_GET['page'] : 1;


// Check that incoming is valid
is_numeric($hits) or die('Check: Hits must be numeric.');
is_numeric($page) or die('Check: Page must be numeric.');


//create databasae connection
$db = new CDatabase($urbax['database']);

// Get max pages from table, for navigation
$sql = "SELECT COUNT(id) AS rows FROM VMovie";
$res = $db->ExecuteSelectQueryAndFetchAll($sql);

// Get maximal pages
$max = ceil($res[0]->rows / $hits);

//if current page is larger than max chose start-page
if($page>$max)
  $page=1;
  


// Do SELECT from a table
$sql = "SELECT * FROM VMovie LIMIT $hits OFFSET " . (($page - 1) * $hits);
$res = $db->ExecuteSelectQueryAndFetchAll($sql);

//print hit-buttons
echo  "<p>".getHitsPerPage(array(1,2,3,4,5,10))."<a href='?p=paginate' class='aButton'>Visa alla</a></p>";  


 ?>


<table class='table'>
  <tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>

  <?php
  foreach ($res as $i=>$row) 
  {
    echo "<tr><td width='10%'>$i</td><td width='10%'>{$row->id}</td>"
    . "<td width='15%'><img src='{$row->image}' alt='bild på film' width='100' height='50'></td>"
    . "<td>{$row->title}</td><td width='10%'>{$row->year}</td></tr>";
  }
?>
</table>

<div style="text-align: center; margin-top: 5px;">
<?php
  //print page navigation
echo getPageNavigation($hits, $page, $max);    
?>
</div>



