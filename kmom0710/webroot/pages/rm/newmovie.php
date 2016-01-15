<?php
  $db = new CDatabase($urbax['database']);
  

// get parameters
$create   = isset($_POST['create'])  ? true : false;
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$year   = isset($_POST['year'])  ? strip_tags($_POST['year'])  : 0;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;

// if user is NOT authenticated.
if($acronym==null)
{
  echo <<< EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få skapa ny film</h2>
    <p>Använd menyn uppe till höger på denna sida.</p>
</div>
EOD;
 
}
else
{
  // Check if form was submitted
  if($create) {
    $sql = 'INSERT INTO oophp0710_movie (title,year) VALUES (?,?)';
    $params = array($title,$year);
    $db->ExecuteQuery($sql,$params);
    $db->SaveDebug();
    
    $sql2 = 'INSERT INTO oophp0710_movie2genre(idMovie,idGenre) VALUES (?,?)';
    $lastInsertId = $db->LastInsertId();
    $params2 = array($lastInsertId,1);
    $db->ExecuteQuery($sql2,$params2);
    $db->SaveDebug();
    
    $sql3 = 'INSERT INTO oophp0710_movie2image(movie_id,image_id) VALUES (?,?)';
    $params3 = array($lastInsertId,1);
    $db->ExecuteQuery($sql3,$params3);
    $db->SaveDebug(); 
    
    echo  "Ny film sparad. <a href='?p=updatemovie' class='aButton'>Editera</a>";
  }
  else
  {
    //var_dump($user->isAdmin());
    $disabled='';
    $info='';
    if(!$user->isAdmin())
    {
      $disabled = "disabled";
      $info = "<p> Du kan inte editera eftersom du inte är administratör.</p>";
    }
    
      echo <<< CCCP
      <div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
          <h1 class="center">Skapa ny film</h1>
      <form method=post>
        <p><label>Titel:<br/><input type='text' name='title' $disabled/></label></p>
        <p><input type='submit' name='create' value='Skapa'$disabled/></p>
      </form>
      </div>
      $info
CCCP;
  }

}


