
<h1 class="center">Sortera filmer</h1>
<p class="center">Alla filmer i databasen:</p>

<?php
  /**
   * Function to create links for sorting
   */
  function orderby($column) {
    return "<span class='orderby'>"
    . "<a href='?p=moviesort&amp;orderby={$column}&amp;order=asc' class='sortButton'>&darr;</i></a>"
    . "<a href='?p=moviesort&amp;orderby={$column}&amp;order=desc' class='sortButton'>&uarr;</a>"
    . "</span>";
  }
  
  $tr = "<tr><th>Rad</th><th>Id " . orderby('id') . "</th><th>Bild</th><th>Titel " . orderby('title') . "</th><th>År " . orderby('year') . "</th><th>Genre</th></tr>";

  
    // Get parameters for sorting
  $orderby  = isset($_GET['orderby']) ? strtolower($_GET['orderby']) : 'id';
  $order    = isset($_GET['order'])   ? strtolower($_GET['order'])   : 'asc';
  
  // Check that incoming is valid
  in_array($orderby, array('id', 'title', 'year')) or die('Check: Not valid column.');
  in_array($order, array('asc', 'desc')) or die('Check: Not valid sort order.');
  
  
  //connect to database
  $db = new CDatabase($urbax['database']);
  
  //build query-string
  $sql = "SELECT * FROM VMovie ORDER BY $orderby $order;";
  
  //run query
  $res = $db->ExecuteSelectQueryAndFetchAll($sql);
  

  //build table
  echo "<table class='table'>";
  echo $tr;
  
  foreach ($res as $i=>$row) 
  {
    echo "<tr><td>$i</td><td>{$row->id}</td><td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td><td>{$row->title}</td><td>{$row->year}</td><td>{$row->genre}</td></tr>";
  }
?>
</table>



