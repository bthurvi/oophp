
<h1 class="center">Sök efter film - via årtal</h1>
<p class="center">Söker efter en film som är skapad mellan åren.</p>

<?php
  // Get parameters for sorting
$year1 = isset($_POST['year1']) && !empty($_POST['year1']) ? $_POST['year1'] : null;
$year2 = isset($_POST['year2']) && !empty($_POST['year2']) ? $_POST['year2'] : null;
  
  
  //Connect to database
  $db = new CDatabase($urbax['database']);
 

  // SELECT from a table
  if($year1 && $year2) 
    {
    $sql = "SELECT * FROM Movie WHERE year >= ? AND year <= ?;";
    $params = array($year1,$year2);  
  } 
  else if($year1) {
    $sql = "SELECT * FROM Movie WHERE year >= ?;";
    $params = array($year1);  
  }  
  else if($year2) {
    $sql = "SELECT * FROM Movie WHERE year <= ?;";
    $params = array($year2);
  }
  else{
    $sql = "SELECT * FROM Movie;";
    $params = null;
  }

?>

<form method="post">
   <p><label>Skapad mellan åren: 
    <input type='search' name='year1' value='<?=$year1?>'/>
    - 
    <input type='search' name='year2' value='<?=$year2?>'/>
  </label>
</p>
<p><input type='submit' name='submit' value='Sök'/></p>
</form>

<p><a href='?p=movietitlesearch' class='aButton'>Visa alla</a></p>

<table class='table'>
  <tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th></tr>

  <?php
  $res = $db->ExecuteSelectQueryAndFetchAll($sql,$params);
  
  foreach ($res as $i=>$row) 
  {
    echo "<tr><td>$i</td><td>{$row->id}</td><td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td><td>{$row->title}</td><td>{$row->year}</td></tr>";
  }
?>
</table>



