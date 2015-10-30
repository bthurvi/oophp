
<h1 class="center">Sök efter film - via genre</h1>
<p class="center">Söker efter en film som är skapad mellan åren.</p>

<?php  

//Connect to database
$db = new CDatabase($urbax['database']);
 

// Get all genres that are active
$sql = '
  SELECT DISTINCT G.name
  FROM Genre AS G
    INNER JOIN Movie2Genre AS M2G
      ON G.id = M2G.idGenre
';

$res  =  $db->ExecuteSelectQueryAndFetchAll($sql);

//Generate 'buttons' for all the genres
$genres = null;
foreach($res as $val) {
  $genres .= "<a class='aButton' href='?p=moviegenresearch&amp;genre={$val->name}'>{$val->name}</a> ";
}

// Get parameters
$genre = isset($_GET['genre']) ? $_GET['genre'] : null;

// Do SELECT from a table
if($genre) 
{
  $sql = '
    SELECT 
      M.*,
      G.name AS genre
    FROM Movie AS M
      LEFT OUTER JOIN Movie2Genre AS M2G
        ON M.id = M2G.idMovie
      INNER JOIN Genre AS G
        ON M2G.idGenre = G.id
    WHERE G.name = ?
    ;
  ';
  $params = array($genre);  
} 
else {
  $sql = "SELECT * FROM VMovie;";
  $params = null;
}

?>

<form method="post">
   <p><label>Välj genre: </label></p>
   <p><?=$genres;?></p>
</form>

<p><a href='?p=moviegenresearch' class='aButton'>Visa alla</a></p>

<table class='table'>
  <tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th>Genre</th></tr>

  <?php
  $res = $db->ExecuteSelectQueryAndFetchAll($sql,$params);
  
  foreach ($res as $i=>$row) 
  {
    echo "<tr><td>$i</td><td>{$row->id}</td><td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td>"
    . "<td>{$row->title}</td><td>{$row->year}</td><td>{$row->genre}</td></tr>";
  }
?>
</table>



