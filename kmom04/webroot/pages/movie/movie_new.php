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
  $out = <<<EOD
<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h2 style="margin-top: 0;">Du måste vara inloggad för att få editera...</h2>
    <p><a href="?p=login" class="aButton">Logga in</a></p>
</div>
EOD;
 
  die($out);
}

// Check if form was submitted
if($create) {
  $sql = 'INSERT INTO Movie (title,year) VALUES (?,?)';
  $db->ExecuteQuery($sql, array($title,$year));
  $db->SaveDebug();
  header('Location: ?p=uppdate&id=' . $db->LastInsertId());
  exit;
}
?>


<div style=" border: 1px solid #777; border-radius: 3px; padding: 10px 20px;">
    <h1 class="center">Skapa ny film</h1>
<form method=post>
  <p><label>Titel:<br/><input type='text' name='title'/></label></p>
  <p><input type='submit' name='create' value='Skapa'/></p>
</form>
</div>


