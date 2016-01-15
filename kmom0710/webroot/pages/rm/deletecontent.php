<?php

// get parameters
$id   = isset($_GET['id'])  ? filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE):null;
$uppdate   = isset($_POST['uppdate'])  ? true : false;
$title  = isset($_POST['title']) ? strip_tags($_POST['title']) : null;
$type   = isset($_POST['type'])  ? strip_tags($_POST['type'])  : null;
$acronym = isset($_SESSION['user']) ? $_SESSION['user']->acronym : null;


if($acronym==null)// if user is NOT authenticated.
{
  echo <<< EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få radera innehåll...</h2>
    <p><a href="?p=clogin" class="aButton">Logga in</a></p>
</div>
EOD;
 
}
else //user is authorized
{
  $cont = new CContent($urbax['database']);
  
  //time to delete a post?
  if($cont->validContentId($id))
  {
     $cont->delete($id);
     
     //use javascritp to reload - forces the the nav menu to uppdate
     //echo "<script> setTimeout(function (){ window.location.href = '?p=contentdelete'; }, 2000);</script>";
  }
  
  //var_dump($user->isAdmin());
    $disabled='';
    $info='';
    if(!$user->isAdmin())
    {
      $disabled = "disabled";
      $info = "<p> Du kan inte radera eftersom du inte är administratör.</p>";
    }
  
  //show table
  $dbc = new CDatabase($urbax['database']);
  $resultset = $dbc->ExecuteSelectQueryAndFetchAll('SELECT id, title FROM oophp0710_content WHERE deleted IS NULL');

  echo "<h2>Välj post att radera:</h2>";

  echo "<table class='table'>";
  echo "<tr><th style='width:100px;'></th><th>Id</th><th>Titel</th></tr>";
  foreach ($resultset as $res) 
  {
    echo "<tr><td>";
    
    if($user->isAdmin())
     echo "<a href='?p=deletecontent&amp;id={$res->id}' class='aButton' style='width:70px; margin:0 auto; display:block;'>Radera</a>";
    else
     echo "<a href='?p=deletecontent' class='aButton' style='width:70px; margin:0 auto; display:block;'>Radera ej</a>";
            
   echo "</td><td>{$res->id}</td><td>{$res->title}</td></tr>";
  }
  echo "</table>";
  echo $info;
  
   
   
   
}





