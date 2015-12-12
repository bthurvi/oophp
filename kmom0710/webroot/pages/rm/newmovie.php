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
    $sql = 'INSERT INTO Movie (title,year) VALUES (?,?)';
    $params = array($title,$year);
    $db->ExecuteQuery($sql,$params);
    $db->SaveDebug();
    
    $sql2 = 'INSERT INTO movie2genre(idMovie,idGenre) VALUES (?,?)';
    $params2 = array($db->LastInsertId(),1);
    $db->ExecuteQuery($sql2,$params2);
    $db->SaveDebug();
    
    echo  "Ny film sparad. <a href='?p=updatemovie' class='aButton'>Editera</a>";
  }
  else
  {
      echo <<< CCCP
      <div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
          <h1 class="center">Skapa ny film</h1>
      <form method=post>
        <p><label>Titel:<br/><input type='text' name='title'/></label></p>
        <p><input type='submit' name='create' value='Skapa'/></p>
      </form>
      </div>
CCCP;
  }

}


