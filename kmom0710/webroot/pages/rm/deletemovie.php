<?php
  $db = new CDatabase($urbax['database']);
  
  
  
  // Get parameters 
$id     = isset($_POST['id'])    ? strip_tags($_POST['id']) : (isset($_GET['id']) ? strip_tags($_GET['id']) : null);
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$year   = isset($_POST['year'])  ? strip_tags($_POST['year'])  : null;
$image  = isset($_POST['image']) ? strip_tags($_POST['image']) : null;
$genre  = isset($_POST['genre']) ? $_POST['genre'] : array();
$save   = isset($_POST['save'])  ? true : false;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// if user is NOT authenticated.
if($acronym==null)
{
  echo <<<EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få radera</h2>
    <p>Använd menyn uppe till höger på denna sida.</p>
</div>
EOD;
 
}
else
{

  if($id!=null) // DELETE mode
  {
    //do we have a valid id?
    $sql = "SELECT * FROM oophp0710_movie";
    $res = $db->ExecuteSelectQueryAndFetchAll($sql);

    $movie=null;
    foreach ($res as $mov) 
    {
      if($mov->id == $id)
      {
        $movie = $mov;
      }
    }

    if(!$movie)
        die("CHECK: invalid id");

    $sql = 'DELETE FROM oophp0710_movie2Genre WHERE idMovie = ?';
    $db->ExecuteQuery($sql, array($id));
    $db->SaveDebug("Det raderades " . $db->RowCount() . " rader från databasen.");
    
    $sql2 = 'DELETE FROM oophp0710_movie2image WHERE movie_id = ?';
    $db->ExecuteQuery($sql2, array($id));
    $db->SaveDebug("Det raderades " . $db->RowCount() . " rader från databasen.");

    $sql = 'DELETE FROM oophp0710_movie WHERE id = ? LIMIT 1';
    $db->ExecuteQuery($sql, array($id));
    $db->SaveDebug("Det raderades " . $db->RowCount() . " rader från databasen.");

  

  }
  
  echo "<h1 class='center'>Välj film att radera</h1>";

  echo "<table class='table'>
    <tr><th></th><th>Titel</th><th>År</th><th width='10%'>Skapad</th></tr>";

   $sql = "SELECT id,title,year, creationdate as tid FROM oophp0710_movie ORDER BY tid DESC";
  $res = $db->ExecuteSelectQueryAndFetchAll($sql);

  foreach ($res as $i=>$row) 
  {
    echo "<tr>"
    . "<td width='5%' style='text-align:center;'><a class='aButton' href='?p=deletemovie&amp;id={$row->id}'>radera</a></td>"
    . "<td><strong>{$row->title}</strong></td>"
    . "<td>{$row->year}</td>"
    . "<td>{$row->tid}</td>"
    . "</tr>";
  }

  echo "</table>";
  
}
?>




