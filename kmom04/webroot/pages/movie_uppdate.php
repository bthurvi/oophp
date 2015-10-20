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
  $out = <<<EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få editera...</h2>
    <p><a href="?p=login" class="aButton">Logga in</a></p>
</div>
EOD;
 
  die($out);
}
 


if($id!=null) // EDIT mode
{
  //do we have a valid id?
  $sql = "SELECT * FROM Movie";
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
  
  
 
  //output edit form
  echo <<<EEE
  <form method=post>
  <fieldset>
  <legend>Uppdatera info om film</legend>
  <input type='hidden' name='id' value='$movie->id'/>
  <p><label>Titel:<br/><input type='text' name='title' value='$movie->title'/></label></p>
  <p><label>År:<br/><input type='text' name='year' value='$movie->year'/></label></p>
  <p><label>Bild:<br/><input type='text' name='image' value='$movie->image'/></label></p>
  <p><input type='submit' name='save' value='Spara'/> <input type='reset' class='aButton' value='Återställ'/></p>
  <p><a class='aButton' href='?p=uppdate'>Visa alla</a></p>
  <output></output>
  </fieldset>
</form>
  
EEE;
}
else // NOT in EDIT mode
{
  echo "<h1 class='center'>Välj och uppdatera filminformation</h1>";

  echo "<table class='table'>
    <tr><th>Rad</th><th>Id</th><th>Bild</th><th>Titel</th><th>År</th><th></th></tr>";
  
   $sql = "SELECT id,title,image,year FROM Movie";
  $res = $db->ExecuteSelectQueryAndFetchAll($sql);

  foreach ($res as $i=>$row) 
  {
    echo "<tr><td>$i</td><td>{$row->id}</td><td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td>"
       . "<td>{$row->title}</td><td>{$row->year}</td><td width='5%' style='text-align:center;'><a class='aButton' href='?p=uppdate&amp;id={$row->id}'>editera</a></td></tr>";
  }
  
  echo "</table>";
}
?>




