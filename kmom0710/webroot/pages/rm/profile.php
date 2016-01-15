<?php
if(!isset($_SESSION['user']))
  echo("Du måste vara inloggad för att kunna se profilen. <br/>Använd menyn upppe till höger.");
else
{
  
  $user->updateSessionUser($_SESSION['user']->id);
  
  $user = $_SESSION['user'];
  //var_dump($user);
  
  echo <<< html
  <div>
    <a class="bread" href="?p=start">Start >> </a>
    <a class="bread" href="?p=profile">Visa profil </a>
  </div>
  <div id='profileinfo'>
  <p></p>
  <h1 style='margin: 0; margin-bottom:10px;'>Visa profil</h1>
  <p class='infolabel'>Namn:</p>
  <p class='infodiv'>{$user->name}&nbsp;</p>
  <p class='infolabel'>Intressen:</p>
  <p class='infodiv'>{$user->intrests}&nbsp;</p>
  <p class='infolabel'>Musik:</p>
  <p class='infodiv'>{$user->music}&nbsp;</p>
  <p class='infolabel'>Böcker:</p>
  <p class='infodiv'>{$user->books}&nbsp;</p>
  <p class='infolabel'>Favoritfilm:</p>
  <p class='infodiv'>{$user->favoritemovie}&nbsp;</p>
  </div>
html;
 
}
 
?>




