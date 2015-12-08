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
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få editera</h2>
    <p>Använd menyn uppe till höger på denna sida.</p>
</div>
EOD;
 
  echo $out;
}
 else
 { 


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


    if($save && isset($title) && isset($year))
    {
    $sql = 'UPDATE Movie SET title = ?,year = ?WHERE id = ?';
    $params = array($title, $year, $id);


    $db->ExecuteQuery($sql, $params);

    echo  "Informationen sparad. <a href='?p=updatemovie' class='aButton'>Visa alla</a>";
    }
    else
    {
    //output edit form
    var_dump($movie);
    echo <<<EEE
    <form method=post>
   <div style="max-width: 500px; border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h1 style="margin-top: 0;">Ange filminformation</h1>
    <input type='hidden' name='id' value='$movie->id'/>
    <p><label>Titel:<br/><input type='text' name='title' value='$movie->title'/></label></p>
    <p><label>Ressigör:<br/><input type='text' name='director' value='$movie->director'/></label></p>
    <p><label>Längd:<br/><input type='number' name='lenght' value='$movie->length'/></label></p>
    <p><label>Handling:<br/><textarea name='lenght'/>$movie->plot</textarea></p>
    <p><label>Textning:<br/>
      <select>
            <option value='SV'>SV</option>
            <option value='EN'>EN</option>
            <option value='FR'>FR</option>
            <option value='IT'>IT</option>
            <option value='ES'>ES</option>
      </select> 
      </label></p>
    <p><label>Textning:<br/><input type='text' name='year' value='$movie->subtext'/></label></p>
    <p><label>År:<br/><input type='number' name='year' value='$movie->year'/></label></p>
    <p><label>Bild:<br/><input type='text' name='image' value='$movie->image'/></label></p>
    <p><input type='submit' name='save' value='Spara'/> <input type='reset' class='aButton' value='Återställ'/></p>
    <p><a class='aButton' href='?p=updatemovie'>Visa alla</a></p>
    <output></output>
    </div>
  </form>
EEE;
    }
  }
  else // NOT in EDIT mode
  {
    echo "<h1 class='center'>Välj och uppdatera filminformation</h1>";

    echo "<table class='table'>
      <tr><th></th><th>Titel</th><th>Bild</th><th>År</th><th width='10%'>Skapad</th></tr>";

     $sql = "SELECT id,title,image,year, creationdate as tid FROM Movie ORDER BY tid DESC";
    $res = $db->ExecuteSelectQueryAndFetchAll($sql);

    foreach ($res as $i=>$row) 
    {
      echo "<tr>" 
           ."<td width='5%' style='text-align:center;'><a class='aButton' href='?p=updatemovie&amp;id={$row->id}'>editera</a></td>"
           ."<td><strong>{$row->title}</strong></td>"
           . "<td><img src='{$row->image}' alt='bild på film' width='100' height='50'></td>"
           . "<td>{$row->year}</td>"
           . "<td>{$row->tid}</td>"
           . "</tr>";
    }

    echo "</table>";
  }
}
?>






