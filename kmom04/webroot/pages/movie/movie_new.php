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
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få skapa ny film...</h2>
    <p><a href="?p=login" class="aButton">Logga in</a></p>
</div>
EOD;
 
}
else
{
  // Check if form was submitted
  if($create) {
    $sql = 'INSERT INTO Movie (title,year) VALUES (?,?)';
    $db->ExecuteQuery($sql, array($title,$year));
    $db->SaveDebug();
    
    echo  "Ny film sparad. <a href='?p=uppdate' class='aButton'>Editera</a>";
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


